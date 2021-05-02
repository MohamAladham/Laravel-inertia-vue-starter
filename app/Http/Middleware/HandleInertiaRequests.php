<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
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
        if ( request()->is( 'admin/login' ) )
        {
            $this->rootView = 'admin_auth';
        } elseif ( request()->is( 'admin/*' ) )
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
        return array_merge( parent::share( $request ), [
            'auth'    => [
                'user' => $request->user(),
            ],
            'appName' => config( 'app.name' ),
        ] );
    }
}
