<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'users', function ( Blueprint $table ) {
            $table->foreignId( 'country_id' )->references( 'id' )->on( 'countries' );
            $table->foreignId( 'region_id' )->nullable()->references( 'id' )->on( 'country_regions' );
            $table->foreignId( 'city_id' )->nullable()->references( 'id' )->on( 'country_region_cities' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table( 'users', function ( Blueprint $table ) {
            //
        } );
    }
}
