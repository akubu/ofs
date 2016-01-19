<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LogisticsMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistics_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('provider_id');
            $table->string('provider_name');
            $table->string('provider_address');
            $table->string('provider_rating');
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
        Schema::drop('logistics_master');
    }
}
