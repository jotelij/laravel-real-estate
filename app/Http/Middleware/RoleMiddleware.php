<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, int ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Check if the user's role matches any of the allowed roles
        if (!in_array($user->role->value ?? $user->role, $roles, true)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}