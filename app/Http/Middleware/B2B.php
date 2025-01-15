<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class B2B
{
    /**
     * Middleware to check if the user is authenticated.
     * If not, redirects the user to the login page.
     *
     * @author Salah Derbas
     * @param \Illuminate\Http\Request $request The incoming request.
     * @param \Closure $next The next middleware to be executed.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response The response after middleware execution.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user())
            return redirect()->route('auth.loginPage');

        return $next($request);
    }
}
