<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $value = $request->session()->has('auth');
        if (!$value) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
