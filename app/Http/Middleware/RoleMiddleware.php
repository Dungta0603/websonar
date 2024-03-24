<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role, $permission = null): \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    {
        $roles = explode("|", $role);
        $can_access = false;
        foreach ($roles as $user_role) {
            if($request->user()->hasRole($user_role)) {
                $can_access = true;
            }
        }
        if($permission != null && $request->user()->can($permission)) {
            $can_access = true;
        }
        return $can_access ? $next($request) : abort(401);

    }
}
