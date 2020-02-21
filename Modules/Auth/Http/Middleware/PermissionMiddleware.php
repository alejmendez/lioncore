<?php

namespace Modules\Auth\Http\Middleware;

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
        $roles = $user->roles;

        foreach ($permissions as $permission) {
            if ($user->can($permission)) {
                return $next($request);
            }
            foreach ($roles as $role) {
                if ($role->hasPermissionTo($permission)) {
                    return $next($request);
                }
            }
        }

        throw UnauthorizedException::forPermissions($permissions);
    }
}
