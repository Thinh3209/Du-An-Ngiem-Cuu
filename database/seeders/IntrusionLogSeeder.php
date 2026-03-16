<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IntrusionLog;

class IntrusionLogSeeder extends Seeder
{
    public function run()
    {
        
        $attackTypes = ['Scan', 'BruteForce', 'Exploit', 'Malware'];
        
        
        for ($i = 0; $i < 20; $i++) {
            $score = rand(40, 100); 
            
            IntrusionLog::create([
                'ip_address' => rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255),
                'attack_type' => $attackTypes[array_rand($attackTypes)],
                'action_type' => 'Simulated Attack',
                'risk_score' => $score,
               
            ]);
        }
    }
}