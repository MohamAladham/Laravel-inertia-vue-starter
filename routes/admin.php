<?php

use App\Http\Controllers\Admin\Countries\CountryController;
use App\Http\Controllers\Admin\Countries\RegionCityController;
use App\Http\Controllers\Admin\Countries\RegionController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;


Route::middleware( 'auth:admin' )->name( 'admin.' )->prefix( 'admin' )->group( function () {
    Route::get( '/dashboard', [ DashboardController::class, 'index' ] )->name( 'dashboard' );
    Route::resource( 'countries', CountryController::class );
    Route::post( '/countries/order', [ CountryController::class, 'order' ] )->name( 'countries.order' );
    Route::resource( 'countries.regions', RegionController::class );
    Route::post( '/countries-regions/order', [ RegionController::class, 'order' ] )->name( 'countries.regions.order' );
    Route::resource( 'countries.regions.cities', RegionCityController::class );
    Route::post( '/countries-regions-cities/order', [ RegionCityController::class, 'order' ] )->name( 'countries.regions.cities.order' );
    Route::get( '/countries-regions/get-regions-json/{countryId}', [ RegionController::class, 'getRegionsJson' ] )->name( 'countries.regions.get_regions_json' );
    Route::get( '/countries-regions-cities/get-cities-json/{regionId}', [ RegionCityController::class, 'getCitiesJson' ] )->name( 'countries.regions_cities.get_cities_json' );
} );

