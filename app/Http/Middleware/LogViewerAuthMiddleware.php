<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogViewerAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $username = $request->header('PHP_AUTH_USER');
        $password = $request->header('PHP_AUTH_PW');

        $expectedUsername = config('log-viewer.basic_auth.username');
        $expectedPassword = config('log-viewer.basic_auth.password');

        if (!$username || !$password || $username !== $expectedUsername || $password !== $expectedPassword)
            return response('Invalid credentials.', 401, ['WWW-Authenticate' => 'Basic']);


        return $next($request);
    }
}
