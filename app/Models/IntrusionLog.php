<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntrusionLog extends Model
{
    protected $fillable = ['ip_address', 'attack_type', 'action_type', 'risk_score', 'status', 'latitude', 'longitude',];

    protected static function booted()
    {
        static::creating(function ($log) {
            // Kiểm tra trạng thái công tắc trong file .env
            // Nếu không tìm thấy, mặc định sẽ là true (Bật)
            $isAutoEnabled = env('AUTO_BLOCK_ENABLED', true);

            if ($isAutoEnabled && $log->risk_score >= 90) {
                $log->status = 'Auto-Blocked';
            } else {
                $log->status = 'Pending';
            }
        });
    }
}