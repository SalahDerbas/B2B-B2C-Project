<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EncryptCookies
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (!$response instanceof \Symfony\Component\HttpFoundation\Response) {
            \Log::error('Invalid response in middleware', [
                'type' => gettype($response),
                'route' => $request->path(),
            ]);

            return response('Invalid response', 500);
        }

        return $response;
    }
}
