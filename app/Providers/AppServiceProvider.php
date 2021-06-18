<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->singleton( 'settings', function () {


            if ( !Cache::has( 'settings' ) )
            {
                $settings = Setting::pluck( 'value', 'key' );
                Cache::put( 'settings', $settings );

                return Cache::get( 'settings', $settings );
            }

            return Cache::get( 'settings' );

        } );

    }
}
