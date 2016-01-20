<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Dc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc', function (Blueprint $table) {
            $table->increments('id');
            $table->string('so_number');
            $table->string('dc_number');
            $table->string('truck_number');
            $table->string('driver_id');
            $table->string('logistics_id');
            $table->string('runner_id');
            $table->string('is_tracked');
            $table->string('expected_dispatch_dt');
            $table->string('expected_delivery_dt');
            $table->string('driver_contact_number');
            $table->string('truck_type');
            $table->integer('is_delivered')->default(0);
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
        Schema::drop('dc');
    }
}
