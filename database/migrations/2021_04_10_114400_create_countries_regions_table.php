<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'country_regions', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'name' );
            $table->unsignedInteger( 'order' )->default( 0 );
            $table->foreignId( 'country_id' )->references( 'id' )->on( 'countries' )->onDelete('cascade');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists( 'country_regions' );
    }
}
