<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class So extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('so', function (Blueprint $table) {
            $table->increments('id');
            $table->string('so_number')->unique();
            $table->string('customer_number');
            $table->string('shipment_type');
            $table->string('bill_to_name');
            $table->string('bill_to_address');
            $table->string('ship_to_customer');
            $table->string('ship_to_name');
            $table->string('ship_to_address');
            $table->string('location_code');
            $table->string('order_date');
            $table->string('posting_date');
            $table->string('shipment_date');
            $table->string('due_date');
            $table->string('requested_delivery_dt');
            $table->string('promised_delivery_date');
            $table->string('wishlist_number');
            $table->string('is_delivered');

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
        Schema::drop('so');
    }
}
