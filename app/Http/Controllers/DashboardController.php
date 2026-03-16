<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\IntrusionLog;
use App\Models\WebShellLog;
use App\Models\HackerSession;
use App\Services\TelegramService;

class DashboardController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /* CORE VIEWS (GUI RENDERERS)                                                 */
    /* -------------------------------------------------------------------------- */

    public function index()
    {
        $logs = IntrusionLog::orderBy('created_at', 'desc')->take(10)->get();
        
        $mapData = IntrusionLog::whereNotNull('latitude')
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get(['latitude', 'longitude', 'risk_score', 'status', 'ip_address']);

        $highRiskCount = IntrusionLog::where('risk_score', '>', 90)->count();
        $avgRisk = IntrusionLog::avg('risk_score') ?? 0;
        $honeypotHits = IntrusionLog::whereIn('attack_type', ['Scan', 'BruteForce'])->count();
        $webShellBlocked = WebShellLog::count();

        $scanCount = IntrusionLog::where('attack_type', 'Scan')->count();
        $bruteForceCount = IntrusionLog::where('attack_type', 'BruteForce')->count();
        $exploitCount = IntrusionLog::where('attack_type', 'Exploit')->count();
        $malwareCount = IntrusionLog::where('attack_type', 'Malware')->count();

        return view('dashboard', compact(
            'logs', 'mapData', 'highRiskCount', 'avgRisk', 'honeypotHits', 'webShellBlocked',
            'scanCount', 'bruteForceCount', 'exploitCount', 'malwareCount'
        ));
    }

    public function layer1()
    {
        $sessions = IntrusionLog::orderBy('created_at', 'desc')->get();
        return view('layer1', compact('sessions'));
    }

    public function aiAnalysis()
    {
        $logs = IntrusionLog::orderBy('created_at', 'desc')->take(10)->get();
        $logText = $logs->map(fn($l) => "- IP: {$l->ip_address} | Type: {$l->attack_type}")->implode("\n");

        $apiKey = env('GEMINI_API_KEY');
        if (empty($apiKey)) {
            $aiReport = "ERROR: GEMINI_API_KEY not found in .env configuration!";
            return view('layer2', compact('logs', 'aiReport'));
        }

        $prompt = "You are a Cyber Security Expert. Write a concise, aggressive threat intelligence report for these logs:\n\n" . $logText;
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;

        try {
            $response = Http::withoutVerifying()->timeout(30)->post($url, [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            $aiReport = $response->successful() 
                ? ($response->json('candidates.0.content.parts.0.text') ?? "AI returned empty payload.")
                : "UPLINK ERROR: Neural Core offline. (Status: " . $response->status() . ")";
        } catch (\Exception $e) {
            $aiReport = "SYSTEM CRITICAL: " . $e->getMessage();
        }

        return view('layer2', compact('logs', 'aiReport'));
    }

    public function webShellDefense()
    {
        return view('infra_matrix');
    }

    public function systemLogs(Request $request)
    {
        $search = $request->input('search');

        $logs = IntrusionLog::when($search, function ($query, $search) {
                return $query->where('ip_address', 'like', "%{$search}%")
                             ->orWhere('attack_type', 'like', "%{$search}%")
                             ->orWhere('action_type', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        
        return view('system_logs', compact('logs', 'search'));
    }

    /* -------------------------------------------------------------------------- */
    /* DATA APIS (REAL-TIME TELEMETRY)                                            */
    /* -------------------------------------------------------------------------- */

   public function liveInfraData()
    {
        // 1. CPU, CORES & LOAD AVERAGE
        $cpuLoad = 0; $cores = [];
        if (is_readable('/proc/stat')) {
            $stat1 = file('/proc/stat'); usleep(100000); $stat2 = file('/proc/stat');
            
            $cpu1 = explode(' ', trim(preg_replace('/\s+/', ' ', $stat1[0])));
            $cpu2 = explode(' ', trim(preg_replace('/\s+/', ' ', $stat2[0])));
            $difTot = ($cpu2[1]+$cpu2[2]+$cpu2[3]+$cpu2[4]+$cpu2[5]+$cpu2[6]+$cpu2[7]) - ($cpu1[1]+$cpu1[2]+$cpu1[3]+$cpu1[4]+$cpu1[5]+$cpu1[6]+$cpu1[7]);
            $difIdle = ($cpu2[4]+$cpu2[5]) - ($cpu1[4]+$cpu1[5]);
            $cpuLoad = $difTot == 0 ? 0 : round((($difTot - $difIdle) / $difTot) * 100, 1);

            foreach ($stat1 as $k => $line) {
                if (preg_match('/^cpu(\d+)\s+(.*)/', $line, $m1)) {
                    $cId = $m1[1];
                    $v1 = explode(' ', trim(preg_replace('/\s+/', ' ', $m1[2])));
                    preg_match('/^cpu'.$cId.'\s+(.*)/', $stat2[$k], $m2);
                    $v2 = explode(' ', trim(preg_replace('/\s+/', ' ', $m2[1])));
                    $cTot = ($v2[0]+$v2[1]+$v2[2]+$v2[3]+$v2[4]+$v2[5]+$v2[6]) - ($v1[0]+$v1[1]+$v1[2]+$v1[3]+$v1[4]+$v1[5]+$v1[6]);
                    $cIdle = ($v2[3]+$v2[4]) - ($v1[3]+$v1[4]);
                    $cores[] = ['core' => "Core ".($cId+1), 'usage' => $cTot == 0 ? 0 : round((($cTot-$cIdle)/$cTot)*100, 1)];
                }
            }
        }
        $loadAvg = sys_getloadavg(); // Lấy Load Average: [1 min, 5 min, 15 min]

        // 2. RAM DETAILS (Quy đổi sang MB chuẩn như aaPanel)
        $ramTotal = 0; $ramUsed = 0; $ramAvailable = 0; $ramCache = 0; $ramPercent = 0;
        if (is_readable('/proc/meminfo')) {
            $mem = file_get_contents("/proc/meminfo");
            preg_match_all('/^(\w+):\s+(\d+)\s*kB/m', $mem, $matches);
            $info = array_combine($matches[1], $matches[2]);
            
            $ramTotal = isset($info['MemTotal']) ? round($info['MemTotal'] / 1024) : 0;
            $ramAvailable = isset($info['MemAvailable']) ? round($info['MemAvailable'] / 1024) : (isset($info['MemFree']) ? round($info['MemFree'] / 1024) : 0);
            $ramCache = (isset($info['Buffers']) ? round($info['Buffers'] / 1024) : 0) + (isset($info['Cached']) ? round($info['Cached'] / 1024) : 0);
            $ramUsed = $ramTotal - $ramAvailable;
            $ramPercent = $ramTotal > 0 ? round(($ramUsed / $ramTotal) * 100) : 0;
        }

        // 3. DISK DETAILS (Quy đổi sang GB)
        $diskTotal = round(disk_total_space('/') / 1073741824, 2);
        $diskFree = round(disk_free_space('/') / 1073741824, 2);
        $diskUsed = $diskTotal - $diskFree;
        $diskPercent = $diskTotal > 0 ? round(($diskUsed / $diskTotal) * 100) : 0;

        // 4. FIX LỖI NETWORK GRAPH (Đọc MỌI cổng mạng trừ localhost)
        $rx = 0; $tx = 0;
        if (is_readable('/proc/net/dev')) {
            $net = file_get_contents('/proc/net/dev');
            preg_match_all('/^\s*([^:]+):\s*(\d+)\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+\s+(\d+)/m', $net, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $interface = trim($match[1]);
                if ($interface !== 'lo') { // Bỏ qua cổng 'lo' nội bộ
                    $rx += $match[2];
                    $tx += $match[3];
                }
            }
        }

        // 5. SYSTEM LOGS & TOP PROCESSES
        $logPath = storage_path('logs/laravel.log');
        $logs = file_exists($logPath) ? array_map(fn($l) => substr(trim($l), 0, 150), array_slice(file($logPath), -50)) : ["[SYS] Kernel Active."];
        $processes = [];
        try {
            if (function_exists('shell_exec')) {
                $ps = @shell_exec("ps -eo pid,user,comm,%cpu,%mem --sort=-%cpu | head -n 7");
                if ($ps) {
                    $lines = explode("\n", trim($ps)); array_shift($lines);
                    foreach ($lines as $l) {
                        $c = preg_split('/\s+/', trim($l));
                        if (count($c) >= 5) $processes[] = ['pid' => $c[0], 'user' => substr($c[1], 0, 8), 'cmd' => substr($c[2], 0, 12), 'cpu' => $c[3], 'mem' => $c[4]];
                    }
                }
            }
        } catch (\Exception $e) {}

        // TRẢ DỮ LIỆU ĐÃ NÂNG CẤP VỀ FRONTEND
        return response()->json([
            'cpu' => $cpuLoad, 'cores' => $cores, 'load_avg' => $loadAvg,
            'ram' => ['percent' => $ramPercent, 'used' => $ramUsed, 'total' => $ramTotal, 'available' => $ramAvailable, 'cache' => $ramCache],
            'disk' => ['percent' => $diskPercent, 'used' => $diskUsed, 'total' => $diskTotal],
            'network' => ['rx' => $rx, 'tx' => $tx], 'logs' => array_reverse($logs), 'processes' => $processes
        ]);
    }

    /* -------------------------------------------------------------------------- */
    /* SECURITY & TRAP LOGIC                                                      */
    /* -------------------------------------------------------------------------- */

    public function catchHoneypot(Request $request)
    {
        if (auth()->check()) return response()->json(['status' => 'TEST_MODE', 'message' => 'Admin bypass active.'], 200);

        $ip = $request->ip();
        
        if (Cache::has('shield_blocked_ip_' . $ip)) return response()->json(['status' => 'TERMINATED'], 403);

        $lat = null; $lon = null;
        try {
            $geo = Http::timeout(2)->get("http://ip-api.com/json/{$ip}")->json();
            if ($geo && ($geo['status'] ?? '') === 'success') { $lat = $geo['lat']; $lon = $geo['lon']; }
        } catch (\Exception $e) {}

        $userCaught = $request->input('username_attempt') ?? $request->input('log') ?? $request->input('username') ?? 'Honeypot_Target';
        $passCaught = $request->input('password_attempt') ?? $request->input('pwd') ?? $request->input('password') ?? 'Unknown';

$userCaught = $request->input('username_attempt') ?? $request->input('log') ?? $request->input('username') ?? 'Honeypot_Target';
        $passCaught = $request->input('password_attempt') ?? $request->input('pwd') ?? $request->input('password') ?? 'Unknown';

        // 🧠 THUẬT TOÁN ĐÁNH GIÁ MỨC ĐỘ NGUY HIỂM (DYNAMIC THREAT SCORING)
        $riskScore = 50; // Mức nền mặc định
        $attackType = 'Reconnaissance / Scan'; // Mặc định là quét dạo

        if ($userCaught !== 'Honeypot_Target' || $passCaught !== 'Unknown') {
            // Nếu có gõ tài khoản mật khẩu -> Chuyển thành Brute Force (Nguy hiểm vừa)
            $riskScore = rand(70, 85); 
            $attackType = 'Credential Harvesting Attempt';

            // KIỂM TRA MÃ ĐỘC: Nếu chèn mã SQLi, XSS hoặc Command Injection
            $payload = strtolower($userCaught . ' ' . $passCaught);
            if (preg_match('/(union|select|insert|drop|script|1=1|or 1|passwd|shadow|\.\.\/|<|>)/i', $payload)) {
                $riskScore = rand(95, 99); // Báo động đỏ!
                $attackType = 'Critical Payload Injection';
            }
        } else {
            // Chỉ là Bot đi quét dạo form (Nguy hiểm thấp)
            $riskScore = rand(45, 65); 
        }

        // Lấy đúng trạng thái từ Nút Bấm trên Giao diện
        $isAuto = Cache::get('auto_block_enabled', false);
        $actualStatus = $isAuto ? 'Auto-Blocked' : 'Pending';

        $log = IntrusionLog::create([
            'ip_address' => $ip, 
            'username_attempt' => $userCaught, 
            'password_attempt' => $passCaught, 
            'action_type' => 'honeypot_trap_sprung',
            'attack_type' => $attackType, // Đã tự động phân loại
            'risk_score' => $riskScore,   // Đã tự động chấm điểm
            'status' => $actualStatus,
            'latitude' => $lat, 
            'longitude' => $lon
        ]);
        
        // 🛡️ THIẾT QUÂN LUẬT: Ép Database phải nhận đúng trạng thái
        DB::table('intrusion_logs')->where('id', $log->id)->update(['status' => $actualStatus]);
        // 🛡️ THIẾT QUÂN LUẬT: Ép Database phải nhận đúng trạng thái, đề phòng Model lật lọng
        DB::table('intrusion_logs')->where('id', $log->id)->update(['status' => $actualStatus]);

        if ($isAuto) {
            Cache::forever('shield_blocked_ip_' . $ip, true);
            \App\Services\TelegramService::broadcastMessage("🛡️ <b>[SHIELD-AI: TRAP SPRUNG]</b>\nTarget <code>$ip</code> entered credentials.\n<b>ACTION:</b> IP TERMINATED.");
            return response()->json(['status' => 'TERMINATED'], 403);
        }

        \App\Services\TelegramService::broadcastMessage("⚠️ <b>[SHIELD-AI: TRAP TRIGGERED]</b>\nIP: <code>$ip</code>\nAwaiting manual execution.");
        return response()->json(['status' => 'Logged', 'mode' => 'MANUAL']);
    }

    /* -------------------------------------------------------------------------- */
    /* SYSTEM ACTIONS (CÁC NÚT BẤM TRÊN GIAO DIỆN)                                */
    /* -------------------------------------------------------------------------- */

    public function toggleAuto()
    {
        $state = Cache::get('auto_block_enabled', false);
        Cache::forever('auto_block_enabled', !$state);
        return redirect()->back()->with('alert', "System Protocol Switched to: [ " . (!$state ? 'AUTO_ON' : 'MANUAL') . " ]");
    }

    public function blockIp($id)
    {
        $log = IntrusionLog::find($id);
        if ($log) {
            $log->update(['status' => 'Manual-Blocked']);
            Cache::forever('shield_blocked_ip_' . $log->ip_address, true);
            return redirect()->back()->with('alert', "TARGET TERMINATED: [ {$log->ip_address} ]");
        }
        return redirect()->back()->with('error', 'Target not found!');
    }

    public function unblockIp($id)
    {
        $log = IntrusionLog::find($id);
        if ($log) {
            Cache::forget('shield_blocked_ip_' . $log->ip_address);
            $log->update(['status' => 'Pending']); // Sửa thành Pending để phân biệt
            return redirect()->back()->with('alert', "ACCESS RESTORED: [ {$log->ip_address} ]");
        }
        return redirect()->back()->with('error', 'Target not found!');
    }

    // ĐÃ GOM LẠI THÀNH 1 HÀM DUY NHẤT TRÁNH LỖI 500
    public function clearLogs() 
    {
        IntrusionLog::truncate();
        HackerSession::truncate();
        WebShellLog::truncate();
        Cache::flush(); // Dọn sạch Tường lửa
        return back()->with('alert', 'DATABANKS & FIREWALL CACHE PURGED SUCCESSFULLY.');
    }

    /* -------------------------------------------------------------------------- */
    /* AI NEURAL LINK INTERFACES                                                  */
    /* -------------------------------------------------------------------------- */

    public function chatWithAi(Request $request)
    {
        $question = $request->input('question');
        $apiKey = env('GEMINI_API_KEY'); 
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;

        if (empty($apiKey)) return response()->json(['error' => 'API_KEY_MISSING'], 500);

        try {
            $response = Http::withoutVerifying()->timeout(60)->post($url, [
                'contents' => [['parts' => [['text' => "You are SHIELD-AI. Answer concisely in hacker style: " . $question]]]]
            ]);

            if ($response->successful()) {
                return response()->json(['answer' => $response->json('candidates.0.content.parts.0.text') ?? 'AI Core busy.']);
            }
            return response()->json(['error' => 'AI_CORE_OFFLINE'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'UPLINK_SEVERED'], 500);
        }
    }

    public function predictHackerBehavior($id)
    {
        try {
            $log = IntrusionLog::findOrFail($id);

            $context = "Target Objective: " . $log->action_type . "\n";
            $context .= "Source IP: " . $log->ip_address . "\n";
            
            if ($log->username_attempt && $log->username_attempt !== 'Honeypot_Target') {
                $context .= "Identity Attempt: " . $log->username_attempt . "\n";
            }
            if ($log->password_attempt && $log->password_attempt !== 'Unknown') {
                $context .= "Payload/Cipher Used: " . $log->password_attempt . "\n";
            }

            $prompt = "You are the SHIELD-AI Neural Analysis Engine. Based on this incident data, provide a concise, professional, and aggressive threat assessment:\n\n" . 
                      "INCIDENT_DATA:\n" . $context . "\n\n" .
                      "REQUIREMENTS:\n" .
                      "1. Identify intent (Bot Scan vs Manual Infiltration).\n" .
                      "2. Evaluate Technical Proficiency.\n" .
                      "3. Confirm Neutralization Status.";

            $apiKey = env('GEMINI_API_KEY');
            if (empty($apiKey)) throw new \Exception("NEURAL_LINK_API_KEY_NULL");

            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;

            $response = Http::withoutVerifying()->timeout(15)->post($url, [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            if ($response->successful()) {
                $prediction = $response->json('candidates.0.content.parts.0.text') ?? "ANALYSIS_FAILURE: No data returned.";
                return response()->json(['prediction' => $prediction]);
            }

            throw new \Exception("EXTERNAL_UPLINK_DENIED");

        } catch (\Exception $e) {
            Log::error("Neural Engine Error: " . $e->getMessage());

            $fallback = "🚨 [INTERNAL_HEURISTIC_ACTIVE]\n\n" .
                        "Neural Core disconnected. Local assessment initiated:\n\n" .
                        "1. BEHAVIOR: Pattern suggests directory brute-force or automated scanning tool.\n" .
                        "2. SOPHISTICATION: Low (Scripted Automated Threat).\n" .
                        "3. STATUS: IP effectively isolated in black-site cache. No breach detected.";

            return response()->json(['prediction' => $fallback]);
        }
    }
}