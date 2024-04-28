<?php

use App\Http\Middleware\AuthAdmCli;
use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\AuthClient;
use App\Http\Middleware\AuthStorageAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'authStorageAdmin' => AuthStorageAdmin::class,
            'authAdmin' => AuthAdmin::class,
            'authClient' => AuthClient::class,
            'authAdmCli' => AuthAdmCli::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
