<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Check if the user has any of the allowed roles
        if ($user && in_array($user->role, $roles)) {
            // Allow access for the correct role
            return $next($request);
        }

        // Redirect if the user does not have the correct role
        return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
    }
}
