<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NotificationPushTarget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('notification_push_target', function (Blueprint $table) {
            $table->increments('id');
            $table->string('notofication_id')->unique()->increments();
            $table->string('scm_flag');
            $table->string('scm_logistics_flag');
            $table->string('customer_flag');
            $table->string('tech_flag');
            $table->string('is_sent');
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
        Schema::drop('notification_push_target');
    }
}
