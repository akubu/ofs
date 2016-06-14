<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BEBBLocalLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bebb_locations', function(Blueprint $table)
        {

            $table->increments('id');
            $table->string("code")->nullable();
            $table->string("name")->nullable();
            $table->string("address")->nullable();
            $table->string("pin")->nullable();
            $table->string("serviceTax")->nullable();
            $table->string("tin")->nullable();
            $table->string("tan")->nullable();
            $table->string("cst")->nullable();
            $table->string("lst")->nullable();
            $table->string("cin")->nullable();
            $table->string("ecc")->nullable();

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
        Schema::drop('bebb_locations');
    }

}
