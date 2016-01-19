<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DriverMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('driver_id')->unique();
            $table->string('provider_id');
            $table->string('driver_name');
            $table->string('driver_contact_number');
            $table->string('driver_location');
            $table->string('driver_license_number');
            $table->string('driver_rating');
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
        Schema::drop('driver_master');
    }
}
