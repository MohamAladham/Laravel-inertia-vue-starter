<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'admin_role', function ( Blueprint $table ) {
            $table->id();
            $table->foreignId( 'admin_id' )->references( 'id' )->on( 'admins' );
            $table->foreignId( 'role_id' )->references( 'id' )->on( 'roles' );
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
        Schema::dropIfExists( 'admin_role' );
    }
}
