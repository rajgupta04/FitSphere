<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOnboarding
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->is_onboarded) {
            // Allow access to onboarding routes, logout, and email verification
            if (!$request->routeIs('onboarding.*') && 
                !$request->routeIs('logout') && 
                !$request->routeIs('verification.*')) {
                return redirect()->route('onboarding.index');
            }
        }

        return $next($request);
    }
}
