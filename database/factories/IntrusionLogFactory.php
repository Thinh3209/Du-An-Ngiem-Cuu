<?php

namespace Database\Factories;

use App\Models\IntrusionLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class IntrusionLogFactory extends Factory
{
    protected $model = IntrusionLog::class;

    public function definition(): array
    {
        return [
            // Sinh IP thật ngẫu nhiên
            'ip_address' => $this->faker->ipv4(),
            
            // Các loại hình tấn công khớp với code trên Dashboard của bạn
            'attack_type' => $this->faker->randomElement(['Scan', 'BruteForce', 'Exploit', 'Malware']),
            
            // Điểm rủi ro từ 10 đến 100 (để hiển thị High Risk)
            'risk_score' => $this->faker->numberBetween(10, 100),
            
            // Dải thời gian trong vòng 30 ngày qua để biểu đồ rải đều cho đẹp
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => now(),
        ];
    }
}