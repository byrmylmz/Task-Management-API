<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureTrialIsValid
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
        if(auth()->user()->hasRole('super-admin')){
            // now dont do anyting
        }else{

            if (now()->diffInDays(auth()->user()->trial_until,false) <= 0 ) {
                $user=auth()->user();
                $user->syncRoles('timeout');
            }
        }
            
        return $next($request);   
     }
}
