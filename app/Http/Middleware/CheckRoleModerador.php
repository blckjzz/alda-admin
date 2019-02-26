<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoleModerador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->user()->hasRole('admin')) {
            abort('203', 'Você não tem autorização para acessar essa área!');
        }
        return $next($request);
    }
}
