<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class frontend extends Controller
{

    public function index()
    {

        $error = "no";
        $baseURL = \URL::to('/');
        return view('frontend.index', compact('error', 'baseURL'));
    }

}
