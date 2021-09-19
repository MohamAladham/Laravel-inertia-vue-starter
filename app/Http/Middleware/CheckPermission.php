<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\Role\Permission;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param $permissions
     * @return mixed
     */
    public function handle( $request, Closure $next, ...$permissions )
    {
        $admin          = auth()->user();
        $has_permission = Permission::hasPermission( $admin, $permissions );

        return $next( $request );

        if ( $has_permission )
        {
            return $next( $request );
        }

        abort( JsonResponse::HTTP_UNAUTHORIZED );
    }
}
