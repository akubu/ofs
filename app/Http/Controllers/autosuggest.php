<?php

namespace App\Http\Controllers;

use App\so;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class autosuggest extends Controller
{
    public function soUndelivered()
    {
        $sos = so::where('is_delivered', '=', '0')->get();
        $so_numbers = array();
        foreach ($sos as $so) {
            $so_numbers[] = $so->so_number;
        }
        return $so_numbers;
    }
}
