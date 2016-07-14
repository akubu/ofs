<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDcDetailsDeletedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_details_deleted', function (Blueprint $table) {


                    $table->increments('id');
                    $table->string('dc_number');
                    $table->string('sku');
                    $table->string('sku_quantity');
                    $table->string('sku_units');
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
                Schema::drop('dc_details_deleted');
            }
}
