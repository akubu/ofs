<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Route;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;
    
    protected $data = array();
	
	public function __construct()
	{
		$controller = explode('\\', get_called_class());
		$this->data['controller'] = str_replace('Controller', '', end($controller));
		$this->data['controller'] = strtolower($this->data['controller']);

		$this->data['rewrite_base'] = config('app.rewrite_base');
	}
	
}
