<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Notifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('notification_id')->unique();
            $table->string('dc_number');
            $table->string('so_number');
            $table->string('runner_id');
            $table->string('notification_type');
            $table->string('notification');
            $table->string('response');
            $table->timestamps();
        });



    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notifications');
    }
}
