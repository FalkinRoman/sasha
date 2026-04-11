<?php

use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
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
        // За docker-nginx с TLS Laravel должен видеть https (X-Forwarded-Proto из fastcgi).
        $middleware->trustProxies(at: '*');
        $middleware->alias([
            'admin' => EnsureUserIsAdmin::class,
            'verified' => EnsureEmailIsVerified::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'webhooks/yookassa',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
