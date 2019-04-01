<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class adminLogged
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
        if(!Session::has('adminID')){
            if(Session::has('studentID')){
                return redirect('uDashboard');
            }
            return redirect()->route('login');
        }
        return $next($request);
    }
}
