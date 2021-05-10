<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create( $guard = 'user' )
    {
        if ( $guard == 'admin' )
        {
            return Inertia::render( 'Admin/Auth/Login', [
                'canResetPassword' => Route::has( 'password.request' ),
                'status'           => session( 'status' ),
            ] );
        } else
        {
            return Inertia::render( 'Frontend/Auth/Login', [
                'canResetPassword' => Route::has( 'password.request' ),
                'status'           => session( 'status' ),
            ] );
        }
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store( LoginRequest $request, $guard = 'user' )
    {
        $request->authenticate( $guard );

        $request->session()->regenerate();

        //dd( \auth()->guard( $guard )->user()->toArray() );

        $redirect_to = $guard == 'admin' ? RouteServiceProvider::ADMIN_HOME : RouteServiceProvider::HOME;

        return redirect()->intended( $redirect_to );
    }

    /**
     * Destroy an authenticated session.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy( Request $request )
    {
        Auth::guard( 'user' )->logout();
        Auth::guard( 'admin' )->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect( '/' );
    }
}
