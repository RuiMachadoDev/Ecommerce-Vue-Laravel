<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        \Log::info('Middleware role:admin', [
            'authenticated' => Auth::check(),
            'user_roles' => Auth::check() ? Auth::user()->roles : null,
            'required_role' => $role,
        ]);
    
        if (!Auth::check() || !Auth::user()->hasRole($role)) {
            abort(403, 'This action is unauthorized.');
        }
    
        return $next($request);
    }
}
