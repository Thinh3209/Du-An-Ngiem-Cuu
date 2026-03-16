<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\WebShellShield;
use App\Http\Middleware\ShieldFirewall;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| SHIELD-AI SYSTEM CORE - NEURAL LINK ESTABLISHED
|--------------------------------------------------------------------------
*/

// --- ROOT REDIRECTION ---
Route::get('/', function () {
    return redirect()->route('login');
});

// --- PUBLIC AUTHENTICATION ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// --- SECURE COMMAND CENTER (ADMIN ONLY) ---
Route::middleware(['auth'])->group(function () {
    
    // Main Dashboard & Layers
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/layer1', [DashboardController::class, 'layer1'])->name('honeypot');      // Honeypot Matrix
    Route::get('/layer2', [DashboardController::class, 'aiAnalysis'])->name('ai_analysis'); // AI Threat Intel
    Route::get('/webshell-defense', [DashboardController::class, 'webShellDefense'])->name('webshell'); // Infra Matrix
    Route::get('/system-logs', [DashboardController::class, 'systemLogs'])->name('system_logs'); // Audit Logs

    // Real-time Data Endpoints (APIs)
    Route::get('/api/infra-data', [DashboardController::class, 'liveInfraData']);
    Route::get('/live-radar', [DashboardController::class, 'liveRadar']);
    
    // Administrative Actions
    Route::get('/block-ip/{id}', [DashboardController::class, 'blockIp'])->name('block.ip');
    Route::get('/unblock-ip/{id}', [DashboardController::class, 'unblockIp'])->name('unblock.ip');
    Route::post('/clear-logs', [DashboardController::class, 'clearLogs'])->name('clear.logs');
    Route::post('/toggle-auto', [DashboardController::class, 'toggleAuto'])->name('toggle.auto');
    
    // AI Neural Link Endpoints
    Route::post('/ai-chat', [DashboardController::class, 'chatWithAi'])->name('ai.chat');
    Route::get('/predict-hacker-behavior/{id}', [DashboardController::class, 'predictHackerBehavior']);
});
// AI Neural Engine Route
Route::get('/predict/{id}', [\App\Http\Controllers\DashboardController::class, 'predictHackerBehavior'])->name('ai.predict');
/*
|--------------------------------------------------------------------------
| HONEYPOT TRAP SYSTEM (PUBLIC VECTORS)
|--------------------------------------------------------------------------
*/

/**
 * 🎯 PHASE 1: THE LURE (Entry Points)
 * Strategy: Do NOT block on entry. Let the target see the fake login page.
 */
/**
 * 🎯 PHASE 1: THE LURE & THE WALL (Entry Points)
 * Đã nâng cấp: Đọc thẳng từ Database, bỏ qua Cache để đảm bảo chặn 100%
 */
$honeyTraps = ['wp-admin', 'phpmyadmin', '.env', 'admin', 'config.php', 'wp-login.php'];

foreach ($honeyTraps as $trap) {
    Route::any('/' . $trap, function (\Illuminate\Http\Request $request) use ($trap) {
        
        $ip = $request->ip();

        // 1. KIỂM TRA TRONG SỔ ĐEN DATABASE (CHÍNH XÁC TUYỆT ĐỐI 100%)
        $isBlocked = \App\Models\IntrusionLog::where('ip_address', $ip)
                        ->whereIn('status', ['Auto-Blocked', 'Manual-Blocked'])
                        ->exists();

        // NẾU CÓ TỘI -> TỬ HÌNH NGAY LẬP TỨC
        if ($isBlocked) {
            return response('<body style="background:#000; color:#f00; display:flex; justify-content:center; align-items:center; height:100vh; font-family:monospace; text-align:center;"><div><h1 style="font-size: 50px; text-shadow: 0 0 10px red;">[!] ACCESS DENIED [!]</h1><p>CONNECTION PERMANENTLY TERMINATED BY SHIELD-AI.</p></div></body>', 403);
        }

        // 2. KIM BÀI MIỄN TỬ: Nếu Sếp đang đăng nhập quyền Admin thì không làm gì cả
        if (auth()->check()) { return view('decoy'); }

        // 3. NẾU LÀ IP MỚI -> CHO VÀO TRANG NHỬ (Đợi chúng nhập form sẽ xích sau)
        return view('decoy'); 

    })->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
}

/**
 * 🎯 PHASE 2: THE EXECUTION (Credential Catching)
 * Strategy: Log credentials and terminate the connection here.
 */
Route::post('/honeypot-catch', [DashboardController::class, 'catchHoneypot'])
    ->name('honeypot.catch')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);


// --- EXTERNAL API & SCRIPT TRAP ---
Route::post('/api/honeypot', function (Request $request) {
    $ip = $request->ip();
    $isAuto = Cache::get('auto_block_enabled', false);

    \App\Models\IntrusionLog::create([
        'ip_address' => $ip,
        'username_attempt' => $request->input('username', 'API_BOT'),
        'password_attempt' => $request->input('password', 'brute_force_payload'),
        'attack_type' => 'BruteForce',
        'action_type' => 'External API Vector Triggered',
        'risk_score' => 99,
        'status' => $isAuto ? 'Auto-Blocked' : 'pending_block'
    ]);

    if ($isAuto) {
        Cache::forever('shield_blocked_ip_' . $ip, true);
    }

    return response()->json([
        'status' => 'TERMINATED', 
        'message' => 'SHIELD-AI: Malicious signature recorded. Access revoked.'
    ], 403);
})->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);


// --- FILE UPLOAD EXPLOIT PROTECTION ---
Route::post('/upload-test', function (Request $request) {
    return "SHIELD-AI: Payload clean. No malicious signatures identified.";
})->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class])
  ->middleware([WebShellShield::class]);