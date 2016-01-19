<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('permissions', function($table)
		{
			$table->increments('id');
			$table->string('permission');
			$table->timestamps();
			$table->softDeletes();
		});

		DB::table('permissions')->delete();
		DB::table('permissions')->insert([
			['permission' => 'CAN_MANAGE_ACCESS_CONTROL', 'created_at' => date('Y-m-d H:i:s')],
			['permission' => 'CAN_ADD_PRODUCTS', 'created_at' => date('Y-m-d H:i:s')],
			['permission' => 'CAN_APPROVE_ADDED_PRODUCTS', 'created_at' => date('Y-m-d H:i:s')],
			['permission' => 'CAN_CHANGE_PRODUCT_NAMING_FORMAT', 'created_at' => date('Y-m-d H:i:s')],
			['permission' => 'CAN_MAP_REQUIRED_FEATURES_FOR_CATEGORY', 'created_at' => date('Y-m-d H:i:s')],
			['permission' => 'CAN_MAP_BRAND_TO_CATEGORY', 'created_at' => date('Y-m-d H:i:s')],
			['permission' => 'CAN_CLEAR_CACHE', 'created_at' => date('Y-m-d H:i:s')]
		]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('permissions');
    }
}
