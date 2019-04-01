<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class studentLogged
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
        if(!Session::has('studentID')){
            if(Session::has('adminID')){
                return redirect('aDashboard');
            }
            return redirect()->route('login');
        }
        return $next($request);
    }
}
