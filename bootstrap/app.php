<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureModuleSubscribed;
use App\Http\Middleware\EnsurePermission;
use App\Http\Middleware\EnsureSubscriptionActive;
use App\Http\Middleware\ResolveTenantContext;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->appendToGroup('web', ResolveTenantContext::class);
        $middleware->alias([
            'subscription.active' => EnsureSubscriptionActive::class,
            'module.subscribed' => EnsureModuleSubscribed::class,
            'permission' => EnsurePermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
