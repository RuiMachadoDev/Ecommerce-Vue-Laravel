<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        \Log::info('Role Middleware Triggered', [
            'user' => auth()->user(),
            'roles' => auth()->check() ? auth()->user()->getRoleNames() : null,
            'required_role' => $role,
        ]);

        if (!auth()->check() || !auth()->user()->hasRole($role)) {
            abort(403, 'This action is unauthorized.');
        }

        return $next($request);
    }
}
