<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRunnerSinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('runner_sink', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string("current_lat");
            $table->string("current_long");
            $table->string("runner_id");
            $table->string("timestamp");
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
        Schema::drop('runner_sink');
    }
}
