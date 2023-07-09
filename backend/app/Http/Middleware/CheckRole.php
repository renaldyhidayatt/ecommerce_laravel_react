<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roleIds): Response
    {
        $user = $request->user();

        if (!$user || !$this->hasRoleIds($user, $roleIds)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }

    private function hasRoleIds($user, $roleIds): bool
    {
        return $user->roles()->whereIn('roles.id', $roleIds)->exists();
    }
}
