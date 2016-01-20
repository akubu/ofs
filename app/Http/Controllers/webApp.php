<?php

namespace App\Http\Controllers;

use App\dc;
use App\device;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class webApp extends Controller
{
    public function index(){

        return view('appView.index');

    }





    public function startLoading(){

        $runner_id = Session::get('vt_user');
        $dcs = dc::where('runner_id','=', $runner_id)->get();
        $truck_numbers = array();
        foreach($dcs as $dc)
        {
            $truck_numbers[] = $dc->truck_number;
        }
        $devices = device::where('runner_id', '=', $runner_id)->get();
        $device_numbers = array();
        foreach( $devices as $device)
        {
            $device_numbers[] = $device->device_id;// . " (" . $device->gsm_number . ")";
        }

        return view('appView.startLoading', compact('device_numbers', 'truck_numbers'));
    }


    public function dispatchIt(){

        return view('appView.dispatch');

    }

    public function deliver(){

        return view('appView.deliver');
    }


    public function track(){

        return view('appView.track');

    }


}
