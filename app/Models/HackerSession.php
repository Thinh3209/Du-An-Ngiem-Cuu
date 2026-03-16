<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HackerSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'ip_address',
        'username',
        'password',
        'commands',
        'ai_prediction'
    ];

   
    protected $casts = [
        'commands' => 'array',
    ];
}