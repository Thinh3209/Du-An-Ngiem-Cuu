<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IntrusionLog;
use App\Models\WebShellLog;
use App\Models\HackerSession;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Trang chủ Dashboard - Hiển thị bản đồ và số liệu tổng quan
     */
    public function index()
    {
        // 1. Lấy danh sách 10 log mới nhất cho bảng Live Stream
        $logs = IntrusionLog::orderBy('created_at', 'desc')->take(10)->get();

        // 2. Lấy 50 tọa độ mới nhất để vẽ các chấm đỏ trên bản đồ
        $mapData = IntrusionLog::whereNotNull('latitude')
                                ->orderBy('created_at', 'desc')
                                ->take(50)
                                ->get(['latitude', 'longitude', 'risk_score']);

        // 3. Tính toán các chỉ số thống kê cho các ô HUD
        $highRiskCount = IntrusionLog::where('risk_score', '>', 90)->count();
        $avgRisk = IntrusionLog::avg('risk_score') ?? 0;
        $honeypotHits = IntrusionLog::whereIn('attack_type', ['Scan', 'BruteForce'])->count();
        $webShellBlocked = WebShellLog::count();

        // 4. Thống kê theo loại tấn công cho biểu đồ Bar Chart
        $scanCount = IntrusionLog::where('attack_type', 'Scan')->count();
        $bruteForceCount = IntrusionLog::where('attack_type', 'BruteForce')->count();
        $exploitCount = IntrusionLog::where('attack_type', 'Exploit')->count();
        $malwareCount = IntrusionLog::where('attack_type', 'Malware')->count();

        return view('dashboard', compact(
            'logs', 'mapData', 'highRiskCount', 'avgRisk', 'honeypotHits', 'webShellBlocked',
            'scanCount', 'bruteForceCount', 'exploitCount', 'malwareCount'
        ));
    }

    /**
     * Lớp 2: Gửi dữ liệu log sang AI Gemini để viết báo cáo tổng hợp
     */
    public function aiAnalysis()
    {
        $logs = IntrusionLog::orderBy('created_at', 'desc')->take(10)->get();
        $logText = $logs->map(fn($l) => "- IP: {$l->ip_address} | Loại: {$l->attack_type}")->implode("\n");

        $apiKey = config('services.gemini.api_key');
        if (empty($apiKey)) {
            $aiReport = "LỖI: Chưa cấu hình GEMINI_API_KEY!";
            return view('layer2', compact('logs', 'aiReport'));
        }

        $prompt = "Bạn là chuyên gia bảo mật. Viết báo cáo ngắn cho các log sau:\n\n" . $logText;
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;

        try {
            $response = Http::withoutVerifying()->post($url, [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            if ($response->successful()) {
                $aiReport = $response->json('candidates.0.content.parts.0.text') ?? "AI trả về rỗng.";
            } else {
                $aiReport = "LỖI API: " . $response->body(); 
            }
        } catch (\Exception $e) {
            $aiReport = "LỖI KẾT NỐI: " . $e->getMessage();
        }

        return view('layer2', compact('logs', 'aiReport'));
    }

    /**
     * Lớp 1: Hiển thị danh sách phiên làm việc của Hacker từ Honeypot
     */


public function layer1()
    {
        // Xoay Camera về đúng bảng chứa dữ liệu thật
        $sessions = \Illuminate\Support\Facades\DB::table('intrusion_logs')
                        ->orderBy('created_at', 'desc')
                        ->get();
                        
        return view('layer1', compact('sessions'));
    }
    /**
     * AI Dự đoán hành vi hacker dựa trên chuỗi lệnh đã gõ
     */
    public function predictHackerBehavior($id)
    {
        $session = HackerSession::findOrFail($id);

        if (empty($session->commands)) {
            return response()->json(['error' => 'Hacker chưa gõ lệnh nào.']);
        }

        if ($session->ai_prediction) {
            return response()->json(['prediction' => $session->ai_prediction]);
        }

        $commandList = implode("\n- ", $session->commands);
        $prompt = "Bạn là chuyên gia Threat Intelligence. Phân tích hành vi hacker qua lệnh sau:\n- " . $commandList;

        $apiKey = config('services.gemini.api_key');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;

        try {
            $response = Http::withoutVerifying()->post($url, [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            if ($response->successful()) {
                $prediction = $response->json('candidates.0.content.parts.0.text') ?? "AI không thể phân tích.";
                $session->ai_prediction = $prediction;
                $session->save();
                return response()->json(['prediction' => $prediction]);
            }
            return response()->json(['error' => "LỖI API"], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => "LỖI KẾT NỐI"], 500);
        }
    }

    /**
     * Lớp 3: Quét và hiển thị các file Web Shell nguy hiểm
     */
    public function webShellDefense()
    {
        $hunter = new \App\Services\ShellHunterService();
        $hunter->scanDirectory(public_path('uploads'));
        $badFiles = WebShellLog::orderBy('created_at', 'desc')->get();
        $quarantinedCount = $badFiles->count();
        return view('webshell', compact('badFiles', 'quarantinedCount'));
    }

    /**
     * AI Chat: Gửi câu hỏi từ người dùng đến Gemini AI và nhận phản hồi
     */
    public function chatWithAI(Request $request)
    {
        $question = $request->input('question');

        if (empty($question)) {
            return response()->json(['answer' => 'Vui lòng nhập câu hỏi.']);
        }

        $apiKey = config('services.gemini.api_key');
        if (empty($apiKey)) {
            return response()->json(['answer' => 'LỖI: Chưa cấu hình GEMINI_API_KEY!']);
        }

        $logs = IntrusionLog::orderBy('created_at', 'desc')->take(10)->get();
        $logText = $logs->map(fn($l) => "- IP: {$l->ip_address} | Loại: {$l->attack_type} | Risk: {$l->risk_score}")->implode("\n");

        $prompt = "Bạn là chuyên gia bảo mật SHIELD-AI. Dựa trên dữ liệu log:\n{$logText}\n\nTrả lời câu hỏi: {$question}";
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;

        try {
            $response = Http::withoutVerifying()->post($url, [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            if ($response->successful()) {
                $answer = $response->json('candidates.0.content.parts.0.text') ?? "AI không thể phân tích.";
            } else {
                $answer = "LỖI API: Không thể kết nối đến Gemini AI.";
            }
        } catch (\Exception $e) {
            $answer = "LỖI KẾT NỐI: " . $e->getMessage();
        }

        return response()->json(['answer' => e($answer)]);
    }

    /**
     * Auto Radar: Tự động sinh dữ liệu tấn công mô phỏng cho Dashboard
     */
    public function autoGenerateAttack()
    {
        $attackTypes = ['Scan', 'BruteForce', 'Exploit', 'Malware'];
        $lat = fake()->latitude(-60, 70);
        $lng = fake()->longitude(-170, 170);

        $log = IntrusionLog::create([
            'ip_address' => fake()->ipv4(),
            'attack_type' => $attackTypes[array_rand($attackTypes)],
            'action_type' => 'Auto Radar Simulated',
            'risk_score' => rand(10, 100),
            'latitude' => $lat,
            'longitude' => $lng,
        ]);

        $logs = IntrusionLog::orderBy('created_at', 'desc')->take(10)->get();
        $highRiskCount = IntrusionLog::where('risk_score', '>', 90)->count();

        return response()->json([
            'status' => 'success',
            'highRiskCount' => $highRiskCount,
            'new_hacker' => [
                'lat' => $lat,
                'lng' => $lng,
                'risk' => $log->risk_score,
            ],
            'logs' => $logs,
        ]);
    }

    /**
     * Nút bấm Chặn IP thủ công từ Dashboard
     */
    public function blockIp($id)
    {
        $log = IntrusionLog::find($id);
        
        if ($log) {
            $log->status = 'Manual-Blocked';
            $log->save();
            return redirect()->back()->with('alert', '⚠️ SHIELD-AI: ĐÃ CHẶN ĐỨNG IP [ ' . $log->ip_address . ' ]');
        }

        return redirect()->back()->with('error', 'Không tìm thấy IP!');
    }

    public function clearLogs() 
    { 
        \Illuminate\Support\Facades\DB::table('intrusion_logs')->truncate(); 
        \Illuminate\Support\Facades\DB::table('hacker_sessions')->truncate(); 
        return back(); 
    }
public function catchHoneypot(\Illuminate\Http\Request $request)
 {
     // 1. Tóm cổ địa chỉ IP thật của Hacker
     $ip = $request->ip();

     // 2. Tịch thu tang vật (Mật khẩu và Đường dẫn bẫy)
     $passwordAttempt = $request->input('password_attempt', 'Unknown');
     $attackPath = $request->input('attack_path', '/wp-admin');

     // 3. Ghi vào Sổ Nam Tào (Database)
     // LƯU Ý: Chữ 'honeypot_logs' ở dưới là tên bảng CSDL. 
     // Nếu bảng của bạn tên khác (vd: intrusions, layer1_logs...), hãy đổi lại cho đúng nhé!
// 3. Ghi vào Sổ Nam Tào (Database) - Đã chuẩn hóa theo bảng thật
        \Illuminate\Support\Facades\DB::table('intrusion_logs')->insert([
            'ip_address' => $ip,
            'username_attempt' => 'root', // Trên màn hình đen đang giả vờ login root
            'password_attempt' => $passwordAttempt,
            'action_type' => 'honeypot_trap_triggered',
            'attack_type' => 'SSH/Terminal Brute Force', 
            'risk_score' => 99, 
            'status' => 'sys_block',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
     // 4. Báo cáo lại cho Javascript biết là đã bắt thành công (âm thầm)
     return response()->json(['status' => 'Target Locked', 'ip' => $ip]);
 }
}
