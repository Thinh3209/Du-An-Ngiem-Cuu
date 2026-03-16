<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class TelegramService
{
    /**
     * Dispatch a secure notification to a specific recipient or the default administrative ID.
     */
    public static function sendMessage($message, $chatId = null)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $recipientId = $chatId ?? env('TELEGRAM_CHAT_ID'); 

        if (!$botToken || !$recipientId) {
            Log::warning("TELEGRAM_SERVICE: Dispatch failed. Authentication token or recipient ID missing.");
            return;
        }

        try {
            Http::withoutVerifying()->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $recipientId,
                'text' => $message,
                'parse_mode' => 'HTML'
            ]);
        } catch (\Exception $e) {
            Log::error('TELEGRAM_SERVICE_ERROR: Unhandled exception during dispatch. ' . $e->getMessage());
        }
    }

    /**
     * GLOBAL_BROADCAST_PROTOCOL: Transmit notification to all verified administrative endpoints.
     */
    public static function broadcastMessage($message)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        if (!$botToken) return;

        // Retrieve all administrative chat IDs registered in the system
        $administrativeIds = User::whereNotNull('telegram_chat_id')
                                ->where('telegram_chat_id', '!=', '')
                                ->pluck('telegram_chat_id');

        // Fallback to primary administrative ID if no user-specific IDs are found
        if ($administrativeIds->isEmpty()) {
            self::sendMessage($message);
            return;
        }

        foreach ($administrativeIds as $targetId) {
            try {
                Http::withoutVerifying()->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                    'chat_id' => $targetId,
                    'text' => $message,
                    'parse_mode' => 'HTML'
                ]);
            } catch (\Exception $e) {
                Log::error("TELEGRAM_SERVICE_BROADCAST_ERROR: Communication failure with ID: {$targetId}");
            }
        }
    }
}