<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ofs extends Controller
{

        public function home(){

            return view('newx.backend.home');

        }

        public function dc_manage (){

            return view('newx.backend.dcManage');
        }

        public function dc_create(){

            return view ('newx.backend.dcCreate');
        }

        public function dcCreated(){

            return view ('newx.backend.dcCreated');

        }


}
