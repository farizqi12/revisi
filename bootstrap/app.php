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
    ->withMiddleware(function (Middleware $middleware) {
        // Registrasi middleware
        $middleware->alias([
            'only.kepala.sekolah' => \App\Http\Middleware\OnlyKepalaSekolah::class,
            'only.guru' => \App\Http\Middleware\OnlyGuru::class,
            ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
