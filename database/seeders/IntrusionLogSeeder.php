<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IntrusionLog;

class IntrusionLogSeeder extends Seeder
{
    public function run()
    {
        // 4 loại tấn công chuẩn xác để Biểu đồ có thể đếm được
        $attackTypes = ['Scan', 'BruteForce', 'Exploit', 'Malware'];
        
        // Tự động tạo 20 vụ tấn công ngẫu nhiên
        for ($i = 0; $i < 20; $i++) {
            $score = rand(40, 100); // Random điểm rủi ro từ 40 đến 100
            
            IntrusionLog::create([
                'ip_address' => rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255),
                'attack_type' => $attackTypes[array_rand($attackTypes)],
                'action_type' => 'Simulated Attack',
                'risk_score' => $score,
                // Không cần ghi 'status' ở đây, Bộ não AI (Model) sẽ tự động chấm điểm và Block!
            ]);
        }
    }
}