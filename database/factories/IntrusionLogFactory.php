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
            
            'ip_address' => $this->faker->ipv4(),
            
           
            'attack_type' => $this->faker->randomElement(['Scan', 'BruteForce', 'Exploit', 'Malware']),
            
         
            'risk_score' => $this->faker->numberBetween(10, 100),
            
          
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => now(),
        ];
    }
}