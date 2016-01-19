<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists('users');
        Schema::create('users', function($table) 
        {
            $table->increments('id');
            $table->string('name');
            $table->string('vtiger_user_id', 10)->unique();
            $table->enum('is_active', array('0', '1'));
            $table->string('created_by', 10);
            $table->string('deleted_by', 10);

            $table->timestamps();
            $table->softDeletes();
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
    }
}
