<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesRegionsCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'country_region_cities', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'name' );
            $table->unsignedInteger( 'order' )->default( 0 );
            $table->foreignId( 'region_id' )->references( 'id' )->on( 'country_regions' )->onDelete( 'cascade' );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'country_region_cities' );
    }
}
