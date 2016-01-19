<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerDestinationMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_destination_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_number');
            $table->string('destination_address');
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
        Schema::drop('customer_destination_master');
    }
}
