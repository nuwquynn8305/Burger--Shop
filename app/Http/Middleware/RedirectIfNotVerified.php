<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */    public function handle(Request $request, Closure $next): Response
    {
        // If user is authenticated but not verified, redirect to OTP verification page
        // Except for verification routes, logout, and public routes
        if ($request->user() && 
            !$request->user()->is_verified && 
            !$request->routeIs('verification.*') &&
            !$request->routeIs('logout') &&
            !in_array($request->route()->getName(), [
                'home',
                'products.index',
                'products.show',
                'login',
                'register',
                'password.request',
                'password.reset',
            ])) {
            return redirect()->route('verification.otp');
        }

        return $next($request);
    }
}
