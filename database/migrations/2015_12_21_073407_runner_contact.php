<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RunnerContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('runner_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vtiger_id')->unique();
            $table->string('phone_number');
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
        Schema::drop('runner_contact');
    }
}
