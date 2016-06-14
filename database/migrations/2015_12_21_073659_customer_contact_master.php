<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerContactMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_contact_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->string('email');
            $table->string('customer_preference');
            $table->string('contact_number');
            $table->string('name');
            $table->string('address');
            $table->string('tin');
            $table->string('cst');

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
        Schema::drop('customer_contact_master');
    }
}
