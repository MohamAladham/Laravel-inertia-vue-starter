<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'notification_templates', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'key' )->unique();
            $table->string( 'name' );
            $table->string( 'email_subject' )->nullable();
            $table->text( 'email_text' )->nullable();
            $table->string( 'sms_text' )->nullable();
            $table->string( 'notification_text' )->nullable();
            $table->string( 'description' )->nullable();
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
        Schema::dropIfExists( 'notification_templates' );
    }
}
