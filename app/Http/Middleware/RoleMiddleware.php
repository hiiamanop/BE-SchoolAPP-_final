<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  The required role (admin or guru)
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $userRole = Auth::user()->role_id;

            if ($role === 'admin' && $userRole === 1) {
                return $next($request); // Allow admin access
            }

            if ($role === 'guru' && $userRole === 2) {
                return $next($request); // Allow guru access
            }

            // If role does not match, redirect
            return redirect('/dashboard')->withErrors(['access' => 'You do not have access to this area.']);
        }

        // If not authenticated, redirect to login
        return redirect('/')->with('error', 'You need to login first.');
    }
}
