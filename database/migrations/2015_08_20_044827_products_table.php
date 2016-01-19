<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('products', function($table)
		{
			$table->increments('id');
			$table->integer('cscart_product_id');
			$table->string('name');
			$table->string('sku');
			$table->integer('category_id');
			$table->integer('company_id');
			$table->double('price', 12, 2);
			$table->enum('pushed_to_navision', array(0, 1, 2))
				  ->comment = '0 - Not pushed, 1 - Pushing, 2 - Pushed';
			$table->string('created_by');
			$table->string('updated_by')->nullable();
			$table->string('deleted_by')->nullable();
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
        Schema::drop('products');
    }
}
