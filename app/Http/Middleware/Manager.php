<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Manager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        else if(Auth::user()->usertype != 'manager'){
            if(Auth::user()->usertype == 'admin'){
                return $next($request);
            }
            else if(Auth::user()->usertype == 'user'){
                return redirect('dashboard');
            }
        }

        return $next($request);
    }
}
