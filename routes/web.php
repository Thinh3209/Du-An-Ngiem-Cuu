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
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Core Dashboard & AI Features (Bảo vệ bằng middleware auth)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/ai-chat', [DashboardController::class, 'chatWithAI'])->name('ai.chat');
    Route::get('/hacker-session/{id}/predict', [DashboardController::class, 'predictHackerBehavior']);

    // Layer 1: Honeypot
    Route::get('/layer1', [DashboardController::class, 'layer1'])->name('honeypot');

    // Layer 2: AI Analysis
    Route::get('/layer2', [DashboardController::class, 'aiAnalysis'])->name('ai_analysis');

    // Layer 3: Web Shell Defense
    Route::get('/webshell-defense', [DashboardController::class, 'webShellDefense'])->name('webshell');

    // Các luồng dữ liệu tự động & Cấu hình
    Route::post('/clear-logs', [DashboardController::class, 'clearLogs'])->name('clear.logs');

    // Chặn IP thủ công - dùng POST thay GET để tránh CSRF
    Route::post('/block-ip/{id}', [DashboardController::class, 'blockIp'])->name('block.ip');

    // Auto Radar: Tự động sinh dữ liệu tấn công mô phỏng
    Route::get('/auto-generate-attack', [DashboardController::class, 'autoGenerateAttack'])->name('auto.generate');

    // Route để bật/tắt chế độ tự động khóa IP
    Route::post('/toggle-auto-block', function () {
        $current = config('services.shield.auto_block_enabled') ? 'true' : 'false';
        $next = config('services.shield.auto_block_enabled') ? 'false' : 'true';

        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                'AUTO_BLOCK_ENABLED=' . $current,
                'AUTO_BLOCK_ENABLED=' . $next,
                file_get_contents($path)
            ));
        }
        return back();
    })->name('toggle.auto');
});

// Cổng ngầm hứng dữ liệu từ bẫy Honeypot (không cần auth - honeypot trap)
Route::post('/honeypot-catch', [App\Http\Controllers\DashboardController::class, 'catchHoneypot'])
    ->name('honeypot.catch')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);

// --- CÁC ROUTE PHÒNG THỦ & API ĐỂ MỞ ---

// Đường dẫn giả lập form tải lên, ép qua Lớp 3
Route::post('/upload-test', function (Request $request) {
    return "Tải file an toàn thành công!";
})->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class])
  ->middleware([WebShellShield::class]);

// Cổng API tiếp nhận dữ liệu từ Cowrie Honeypot
Route::post('/api/honeypot', function (Request $request) {
    $validated = $request->validate([
        'ip' => 'required|ip',
        'username' => 'nullable|string|max:255',
        'password' => 'nullable|string|max:255',
    ]);

    \App\Models\IntrusionLog::create([
        'ip_address' => $validated['ip'],
        'username_attempt' => $validated['username'] ?? null,
        'password_attempt' => $validated['password'] ?? null,
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
