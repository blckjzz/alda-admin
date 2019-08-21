<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckConselheiro
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
        if(Auth::guest()){
            return redirect('/');
        }else{
            if(Auth::user()->hasRole('conselheiro') || Auth::user()->hasRole('admin') )
                return $next($request);
            else
                abort(403, "Área reservada para conselheiro!");
            }
        }

}
