<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLineSKU extends Model
{
	protected $connection = 'mysql_cscart';
	protected $table = 'product_line_sku';
	public $timestamps = false;
}
