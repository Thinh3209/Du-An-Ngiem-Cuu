<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Middleware\WebShellShield;

Route::get('/', function () {
    return redirect('/login');
});

// Auth & Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Core Dashboard & AI Features
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::post('/ai-chat', [DashboardController::class, 'chatWithAI'])->name('ai.chat');
Route::get('/hacker-session/{id}/predict', [DashboardController::class, 'predictHackerBehavior']);

// Layer 1: Honeypot
Route::get('/layer1', [DashboardController::class, 'layer1'])->name('honeypot');
// Cổng ngầm hứng dữ liệu từ bẫy Honeypot
Route::post('/honeypot-catch', [App\Http\Controllers\DashboardController::class, 'catchHoneypot'])->name('honeypot.catch');
// Layer 2: AI Analysis
Route::get('/layer2', [DashboardController::class, 'aiAnalysis'])->name('ai_analysis');

// Layer 3: Web Shell Defense
Route::get('/webshell-defense', [DashboardController::class, 'webShellDefense'])->name('webshell');

// Các luồng dữ liệu tự động & Cấu hình
Route::post('/clear-logs', [DashboardController::class, 'clearLogs'])->name('clear.logs');
Route::view('/telegram-settings', 'telegram')->name('telegram');

// [ĐÃ SỬA] Đổi từ POST sang GET để hoạt động hoàn hảo với thẻ <a>
Route::get('/block-ip/{id}', [DashboardController::class, 'blockIp'])->name('block.ip');


// --- CÁC ROUTE PHÒNG THỦ & API ĐỂ MỞ ---

// Đường dẫn giả lập form tải lên, ép qua Lớp 3
Route::post('/upload-test', function (Request $request) {
    return "Tải file an toàn thành công!";
})->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class])
  ->middleware([WebShellShield::class]);

// Cổng API tiếp nhận dữ liệu từ Cowrie Honeypot
Route::post('/api/honeypot', function (Request $request) {
    \App\Models\IntrusionLog::create([
        'ip_address' => $request->input('ip'),
        'username_attempt' => $request->input('username'),
        'password_attempt' => $request->input('password'),
        'attack_type' => 'BruteForce',
        'action_type' => 'SSH Login Attempt',
        'risk_score' => 99 
    ]);

    return response()->json([
        'status' => 'success', 
        'message' => 'SHIELD-AI da ghi nhan thong tin tu Honeypot'
    ]);
})->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);

// BẪY HONEYPOT LỚP 1: Bắt các đường kẻ tấn công hay quét
$honeyTraps = ['wp-admin', 'phpmyadmin', '.env', 'admin', 'config.php'];
foreach ($honeyTraps as $trap) {
    Route::any('/' . $trap, function (Request $request) use ($trap) {
        \App\Models\IntrusionLog::create([
            'ip_address' => $request->ip(),
            'attack_type' => 'Scan',
            'action_type' => 'Hit Honeypot Trap: /' . $trap,
            'risk_score' => 99
        ]);
        return view('decoy');
    })->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
}

// Route để bật/tắt chế độ tự động khóa IP
Route::post('/toggle-auto-block', function () {
    $path = base_path('.env');
    $current = env('AUTO_BLOCK_ENABLED') ? 'true' : 'false';
    $next = env('AUTO_BLOCK_ENABLED') ? 'false' : 'true';

    if (file_exists($path)) {
        file_put_contents($path, str_replace(
            'AUTO_BLOCK_ENABLED=' . $current,
            'AUTO_BLOCK_ENABLED=' . $next,
            file_get_contents($path)
        ));
    }
    return back();
})->name('toggle.auto');
