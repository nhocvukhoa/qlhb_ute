<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLoginClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) {
            if(Auth::user()->quyen==2 || Auth::user()->quyen==3){
                return $next($request);
            }
            return redirect()->route('show_form_login_home');
        }
        return redirect()->route('show_form_login_home');
       
    }
}
