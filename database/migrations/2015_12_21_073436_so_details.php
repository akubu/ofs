<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SoDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('so_details', function (Blueprint $table) {
        $table->increments('id');
        $table->string('so_number');
        $table->string('sku');
        $table->string('shipment_date');
        $table->string('sku_description');
        $table->string('sku_units');
        $table->string('sku_quantity');
        $table->float('amount_to_customer');
        $table->string('requested_delivery_dt');
        $table->string('promised_delivery_dt');
        $table->string('planned_delivery_dt');
        $table->string('planned_shipment_dt');
        $table->string('wishlist_number');
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
        Schema::drop('so_details');
    }
}
