<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
    // if the user is logged in
    if(Auth::check()){

        //check if the logged in user is admin
        if(Auth::user()->isAdmin()){

            // return the next request of the application
            return $next($request);
            // return redirect('/admin/users');


        }
    }

    // if the user us not logged in return him to home page
    return redirect('/');
}
}
