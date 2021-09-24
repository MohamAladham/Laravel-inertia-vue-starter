<?php

namespace App\Http\Middleware;

use App\Models\Role\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'frontend';

    public function __construct()
    {
        if ( in_array( request()->route()->getName(), [ 'login', 'password.request', 'password.reset', 'password.confirm' ] )
            && \request()->route()->parameter( 'guard' ) == 'admin'
        )
        {
            $this->rootView = 'admin_auth';
        } elseif ( request()->is( 'admin/*' ) || request()->is( 'admin' ) )
        {
            $this->rootView = 'admin';
        } else
        {
            $this->rootView = 'frontend';
        }
    }

    /**
     * Determine the current asset version.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    public function version( Request $request )
    {
        return parent::version( $request );
    }

    /**
     * Define the props that are shared by default.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function share( Request $request )
    {
        $user = NULL;

        if ( Auth::check() )
        {
            $user = $request->user( 'user' );

            if ( $request->user( 'admin' ) )
            {
                $user = $request->user( 'admin' );
                //get permissions
                $user->permissions = Permission::whereHas( 'roles', function ( Builder $query ) use ( $user ) {
                    $query->whereHas( 'admins', function ( Builder $users_query ) use ( $user ) {
                        $users_query->where( 'admins.id', '=', $user->id );
                    } );
                } )->pluck( 'name' );
            }
        }

        return array_merge( parent::share( $request ), [
            'auth'           => [
                'user'                     => $user,
                'unreadNotificationsCount' => $user ? $user->unreadNotifications->count() : 0,
            ],
            'appName'        => get_setting( 'site_title', 'اسم النظام' ),
            'adminPanelLogo' => get_setting( 'admin_panel_logo', asset( 'assets/admin/custom/img/logo_placeholder.png' ) ),
            'error'          => $request->session()->get( 'error' ),
            'success'        => $request->session()->get( 'success' ),
        ] );
    }
}
