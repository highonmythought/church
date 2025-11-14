<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Get the required permission for this route
        $permission = $request->route()?->defaults['permission'] ?? null;

        // If no permission is defined, allow access
        if (!$permission) {
            return $next($request);
        }

        // Admin bypass: Admin can access everything
        if ($user?->hasRole('Admin')) {
            return $next($request);
        }

        // Check if user has the required permission
        if ($user?->can($permission)) {
            return $next($request);
        }

        // If user lacks permission, abort with 403
        abort(403, 'Unauthorized: You do not have permission to access this page.');
    }
}
