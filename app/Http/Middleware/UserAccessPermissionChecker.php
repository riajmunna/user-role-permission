<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UserAccessPermissionChecker
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $permission
     * @return Response
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // Fetch user's direct permissions
        $directPermissions = DB::table('permissions')
            ->join('user_permissions', 'permissions.id', '=', 'user_permissions.permission_id')
            ->where('user_permissions.user_id', $request->user()->id)
            ->pluck('permissions.name');

        // Fetch user's inherited permissions through roles
        $inheritedPermissions = DB::table('permissions')
            ->join('role_permissions', 'permissions.id', '=', 'role_permissions.permission_id')
            ->join('roles', 'roles.id', '=', 'role_permissions.role_id')
            ->join('user_roles', 'roles.id', '=', 'user_roles.role_id')
            ->where('user_roles.user_id', $request->user()->id)
            ->pluck('permissions.name');

        // Check if user has required permission directly or through a role
        if (!$directPermissions->contains($permission) && !$inheritedPermissions->contains($permission)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'You do not have permission to access this.'
            ], 403);
        }

        return $next($request);
    }
}
