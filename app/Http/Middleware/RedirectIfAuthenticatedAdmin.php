<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedAdmin
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        // Check only the 'admin' guard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        // If a normal user is logged in → do NOT redirect from admin area
        // Let them see the login page or get 403
        return $next($request);
    }
}
