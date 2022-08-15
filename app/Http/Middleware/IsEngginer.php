<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsEngginer
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
        $data = session('auth');
        if (!$data || $data['user']['role']['id'] != 1) {
            abort(403);
        }
        return $next($request);
    }
}
