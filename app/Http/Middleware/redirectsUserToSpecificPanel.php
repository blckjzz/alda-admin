<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class redirectsUserToSpecificPanel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (\Request::route()->getName() == 'voyager.dashboard' && Auth::user()->hasRole('conselheiro')) {
                return redirect()->route('conselheiro.dashboard');
            }
        }
        return $next($request);
    }
}
