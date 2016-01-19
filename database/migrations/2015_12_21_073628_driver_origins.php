<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DriverOrigins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_origins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('driver_id');
            $table->string('lat');
            $table->string('long');
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
        Schema::drop('driver_origins');
    }
}
