<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleOrPermissionMiddleware
{
    public function handle($request, Closure $next, $roleOrPermission, $guard = null)
    {
        $authGuard = Auth::guard($guard);

        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $user = $authGuard->user();

        if (! $user->hasAnyRole(explode('|', $roleOrPermission)) &&
            ! $user->hasAnyPermission(explode('|', $roleOrPermission))) {
            throw UnauthorizedException::forRolesOrPermissions([$roleOrPermission]);
        }

        return $next($request);
    }
}
