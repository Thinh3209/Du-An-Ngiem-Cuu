<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    public static function sendMessage($message)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        if ($token && $chatId) {
            try {
                // Thêm withoutVerifying() để vượt qua lỗi SSL môi trường local
                // Thêm timeout(5) để tối đa 5s là phải thả cho web chạy tiếp
                Http::withoutVerifying()->timeout(5)->post("https://api.telegram.org/bot{$token}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $message,
                    'parse_mode' => 'HTML'
                ]);
            } catch (\Exception $e) {
                // Nếu lỗi mạng, ghi log ngầm chứ không làm sập giao diện đăng nhập
                Log::error("Lỗi gửi cảnh báo Telegram: " . $e->getMessage());
            }
        }
    }
}