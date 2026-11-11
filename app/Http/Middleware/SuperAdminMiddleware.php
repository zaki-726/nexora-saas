<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('warning', 'Please login with your Super Admin account.');
        }

        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Access denied. You do not have Super Admin privileges for Nexora SaaS.');
        }

        return $next($request);
    }
}
