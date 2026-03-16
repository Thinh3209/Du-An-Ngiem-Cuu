<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        \App\Models\HackerSession::factory(50)->create();

        
        $attackTypes = ['Scan', 'BruteForce', 'Exploit', 'Malware'];
        $logs = [];
        
        for ($i = 0; $i < 100; $i++) {
            $logs[] = [
                
                'ip_address' => rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255),
                'attack_type' => $attackTypes[array_rand($attackTypes)],
                'risk_score' => rand(10, 100),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ];
        }
        
        
        DB::table('intrusion_logs')->insert($logs);
    }
}