<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeviceFaults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_faults', function (Blueprint $table) {
            $table->increments('id');
            $table->string('device_id');
            $table->string('runner_owner');
            $table->string('scm_owner');
            $table->string('reason');
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
        Schema::drop('device_faults');
    }
}
