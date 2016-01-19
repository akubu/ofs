<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SoDtRevision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('so_dt_revision', function (Blueprint $table) {
            $table->increments('id');
            $table->string('so_number')->unique();
            $table->string('Xexpected_shipment_dt');
            $table->string('Xexpected_delivery_dt');
            $table->string('reason_message');
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
        //
        Schema::drop('so_dt_revision');
    }
}
