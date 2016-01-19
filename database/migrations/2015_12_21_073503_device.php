<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Device extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device', function (Blueprint $table) {
            $table->increments('id');
            $table->string('device_id')->unique();
            $table->string('device_type');
            $table->string('device_model');
            $table->string('imei_number');
            $table->string('sim_number');
            $table->string('gsm_number');
            $table->string('scm_id');
            $table->string('runner_id');
            $table->string('dc_number');
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
        Schema::drop('device');
    }
}
