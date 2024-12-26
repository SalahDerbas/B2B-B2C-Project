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
            //
        ]);

        $middleware->api(prepend: [
            //
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response) {
            if ($response->getStatusCode() === 401)
                return respondUnauthorized('Unauthorized');
            if ($response->getStatusCode() === 403)
                return respondForbidden('Forbidden');
            if ($response->getStatusCode() === 404)
                return respondNotFound('Not Found');
            if ($response->getStatusCode() === 405)
                return respondMethodAllowed('Method Not Allowed');
            if ($response->getStatusCode() === 422)
                return respondUnprocessableEntity('Unprocessable Entity');
            if ($response->getStatusCode() === 429)
                return respondTooManyRequest('Too Many Requests');
            // if ($response->getStatusCode() === 500)
            //     return respondInternalError('Internal Server Error');

            return $response;
        });
    })
    ->create();
