<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // 🛡️ KÍCH HOẠT LÍNH GÁC SHIELD-AI TRÊN TOÀN BỘ HỆ THỐNG
        $middleware->append(\App\Http\Middleware\ShieldFirewall::class);
        
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();