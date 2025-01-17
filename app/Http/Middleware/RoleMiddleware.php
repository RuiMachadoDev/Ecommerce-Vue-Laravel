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
            'user_id' => auth()->id(),
            'roles' => auth()->check() ? auth()->user()->getRoleNames() : null,
            'required_role' => $role,
        ]);

        if (!auth()->check() || !auth()->user()->hasRole($role)) {
            \Log::error('Role Middleware Failure', [
                'user_id' => auth()->id(),
                'roles' => auth()->check() ? auth()->user()->getRoleNames() : null,
                'required_role' => $role,
            ]);

            abort(403, 'This action is unauthorized.');
        }

        return $next($request);
    }
}
