<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Peninjauan
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
        $not_have_access = ["Bagian UREL", "Lab Device", "Lab Energy", "Lab Kabel dan Aksesoris FTTH", "Lab Transmisi", "Lab Kalibrasi"];

        if (!$data) {
            return redirect()->route('login');
        }

        for ($i = 0; $i <= count($not_have_access) - 1; $i++) {
            if (!$data || $data[0]['role'] == $not_have_access[$i]) {
                abort(403);
            }
        }
        return $next($request);
    }
}
