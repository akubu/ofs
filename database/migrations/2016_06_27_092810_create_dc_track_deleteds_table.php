<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDcTrackDeletedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_track_deleted', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dc_number');
            $table->string('device_id');
            $table->string('loading_start_dt');
            $table->string('shipment_start_dt');
            $table->string('no_track_reason');
            $table->string('delivered_dt');
            $table->string('address');
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

        Schema::drop('dc_track_deleted');
    }
}
