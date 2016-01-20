<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('user_permissions', function($table)
		{
			$table->increments('id');
			$table->string('vtiger_user_id', 10);
			$table->integer('permission_id')->unsigned()->references('id')->on('permissions');;
			$table->integer('assigned_by')->references('vtiger_user_id')->on('users');;
			$table->integer('updated_by')->references('vtiger_user_id')->on('users');;
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
		Schema::drop('user_permissions');
    }
}
