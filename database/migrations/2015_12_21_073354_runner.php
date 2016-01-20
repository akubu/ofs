<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Runner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('runners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vtiger_id')->unique();
            $table->string('runner_name');
            $table->string('runner_station_address');
            $table->string('runner_address');
            $table->string('reports_to_id');
            $table->string('reports_to_name');
            $table->string('reports_to_email');
            $table->string('runner_to_phone');
            $table->string('reports_to_reports_to_id');
            $table->string('reports_to_reports_to_name');
            $table->string('reports_to_reports_to_email');
            $table->string('runner_to_reports_to_phone');
            $table->string('runner_contact_number_1');
            $table->string('runner_contact_number_2');
            $table->string('runner_email');
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
        Schema::drop('runners');
    }
}
