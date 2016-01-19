<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NotificationTypeMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notofication_type_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('notification_type');
            $table->string('type_string');
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
        Schema::drop('notofication_type_master');
    }
}
