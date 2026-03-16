<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntrusionLog extends Model
{
    // 🔓 ĐÃ MỞ KHÓA KÉT SẮT: Bổ sung 2 biến hứng Tài khoản và Mật khẩu
    protected $fillable = [
        'ip_address', 
        'username_attempt',  // <--- THÊM MỚI
        'password_attempt',  // <--- THÊM MỚI
        'attack_type', 
        'action_type', 
        'risk_score', 
        'status', 
        'latitude', 
        'longitude'
    ];

    protected static function booted()
    {
        static::creating(function ($log) {
            
            $isAutoEnabled = env('AUTO_BLOCK_ENABLED', true);

            // Bổ sung: Chỉ gán tự động nếu file Controller chưa truyền status vào
            // Tránh việc Model tự ý ghi đè lệnh của Controller
            if (empty($log->status)) {
                if ($isAutoEnabled && $log->risk_score >= 90) {
                    $log->status = 'Auto-Blocked';
                } else {
                    $log->status = 'Pending';
                }
            }
        });
    }
}