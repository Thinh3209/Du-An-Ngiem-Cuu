<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Thêm thư viện này để can thiệp sâu vào DB

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo 50 hacker Lớp 1 (Giữ nguyên)
        \App\Models\HackerSession::factory(50)->create();

        // 2. CODE BẤT BẠI: Bơm thẳng 100 log vào DB bằng vòng lặp (Không bao giờ lỗi)
        $attackTypes = ['Scan', 'BruteForce', 'Exploit', 'Malware'];
        $logs = [];
        
        for ($i = 0; $i < 100; $i++) {
            $logs[] = [
                // Sinh IP giả mạo
                'ip_address' => rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255),
                'attack_type' => $attackTypes[array_rand($attackTypes)],
                'risk_score' => rand(10, 100),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ];
        }
        
        // Nhét 1 cục 100 dòng vào bảng intrusion_logs
        DB::table('intrusion_logs')->insert($logs);
    }
}