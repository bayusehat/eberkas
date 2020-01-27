<?php

namespace App\Http\Middleware;

use Closure;

class IfLogged
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
        if(session('token')){
            return redirect('home');
        }
        return $next($request);
    }
}
