<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'menus', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'title' );
            $table->string( 'url' );
            $table->boolean( 'is_active' );
            $table->unsignedInteger( 'parent_id' )->default( 0 );
            $table->unsignedInteger( 'order' )->default( 0 );;
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'menus' );
    }
}
