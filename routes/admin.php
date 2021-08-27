<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Countries\CountryController;
use App\Http\Controllers\Admin\Countries\RegionCityController;
use App\Http\Controllers\Admin\Countries\RegionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware( 'auth:admin' )->name( 'admin.' )->prefix( 'admin' )->group( function () {
    Route::get( '/', [ DashboardController::class, 'index' ] )->name( 'admin' );
    Route::get( '/dashboard', [ DashboardController::class, 'index' ] )->name( 'dashboard' );
    Route::resource( 'countries', CountryController::class );
    Route::post( '/countries/order', [ CountryController::class, 'order' ] )->name( 'countries.order' );
    Route::resource( 'countries.regions', RegionController::class );
    Route::post( '/countries-regions/order', [ RegionController::class, 'order' ] )->name( 'countries.regions.order' );
    Route::resource( 'countries.regions.cities', RegionCityController::class );
    Route::post( '/countries-regions-cities/order', [ RegionCityController::class, 'order' ] )->name( 'countries.regions.cities.order' );
    Route::get( '/countries-regions/get-regions-json/{countryId}', [ RegionController::class, 'getRegionsJson' ] )->name( 'countries.regions.get_regions_json' );
    Route::get( '/countries-regions-cities/get-cities-json/{regionId}', [ RegionCityController::class, 'getCitiesJson' ] )->name( 'countries.regions_cities.get_cities_json' );
    Route::get( 'admins/export', [ AdminController::class, 'export' ] )->name( 'admins.export' );
    Route::resource( 'admins', AdminController::class );
    Route::get( 'users/export', [ UserController::class, 'export' ] )->name( 'users.export' );
    Route::resource( 'users', UserController::class );

    /***** SETTINGS *****/
    Route::get( '/settings/general', [ SettingController::class, 'general' ] )->name( 'settings.general' );
    Route::post( '/settings/update-general', [ SettingController::class, 'updateGeneral' ] )->name( 'settings.update_general' );
    /***** /SETTINGS *****/

    Route::resource( 'menus', MenuController::class );
    Route::post( '/menus/order', [ MenuController::class, 'order' ] )->name( 'menus.order' );

} );

