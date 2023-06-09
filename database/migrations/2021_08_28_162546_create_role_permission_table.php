<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'role_permission', function ( Blueprint $table ) {
            $table->id();
            $table->foreignId( 'role_id' )->references( 'id' )->on( 'roles' )->onDelete('cascade');
            $table->foreignId( 'permission_id' )->references( 'id' )->on( 'permissions' );
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
        Schema::dropIfExists( 'role_permission' );
    }
}
