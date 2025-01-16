<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role, $guard = null)
    {
        $authGuard = Auth::guard($guard);

        if ($authGuard->guest()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        if (!$authGuard->user()->hasRole($role)) {
            return response()->json(['message' => 'Unauthorized: Missing required role'], 403);
        }

        return $next($request);
    }
}
