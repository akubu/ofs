<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActionLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vtiger_id');
            $table->string('action');
            $table->string('parameter_string');
            $table->string('response');
            $table->string('method');
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
        Schema::drop('action_log');
    }
}
