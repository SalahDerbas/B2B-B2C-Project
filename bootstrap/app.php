<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            // \App\Http\Middleware\B2B::class,
        ]);

        $middleware->api(prepend: [
            //
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response ) {
            // if ( request()->is('api/*') )
            //     return ExceptionAPI($response);
            // else
                // return ExceptionWeb($response);
            // return $response;
        });
    })
    ->create();
