<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permission)
    {
        if (app('auth')->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);

        $user = app('auth')->user();
        foreach ($permissions as $permission) {
            if ($user->hasPermissionTo($permission, 'api')) {
                return $next($request);
            }

            foreach ($user->roles as $role) {
                if ($role->hasPermissionTo($permission, 'api')) {
                    return $next($request);
                }
            }
        }

        throw UnauthorizedException::forPermissions($permissions);
    }
}
