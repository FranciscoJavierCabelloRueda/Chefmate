<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'acceso'        => \App\Http\Middleware\Acceso::class,
            'redireccion' => \App\Http\Middleware\Redireccion::class,
        ]) ;

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
