<?php

namespace App\Http\Controllers;

use App\device;
use App\locations;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;

class trackDevice extends Controller
{


    public function currentDeviceLocation()
    {
        try {

            $gsm_number = Input::get('gsm_number');
            $device_id = device::where('gsm_number', '=', $gsm_number)->get()->first()->device_id;
            $location = \App\locations::where('device_id', '=', $device_id)->where('lat', '!=', '0')->orderBy('created_at', "DESC")->get()->first();
            if($location) {


                $response['current_lat'] = $location->lat;
                $response['current_long'] = $location->long;
            }
            else {
                return "<center>Device Cannot be tracked</center>";
            }

            $location_service = new locationServices();
            $response['current_address'] = $location_service->getLocationFromLatLong($location->lat, $location->long);
        } catch (Exception $e){
        return "<center>Device Cannot be tracked</center>";
    }


        return view('map.singlePoint', compact('response'));
    }


}
