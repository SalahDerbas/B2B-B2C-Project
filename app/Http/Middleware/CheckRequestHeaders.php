<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Config;

class CheckRequestHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @author Salah Derbas
     */
    public function handle(Request $request, Closure $next)
    {
        $header = [
            'ip'         => $request->ip(),
            'lang'       => $request->header('lang'),
        ];

        Config::set('header', array_merge(config('header'), $header));
        app()->setLocale($header['lang']) ;


        return $next($request);
    }
}
