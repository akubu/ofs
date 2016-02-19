<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class getLocation extends Controller
{

    public function getDeviceLocation($device_id, $dc_number)
    {
        $number = $device_id;

        $url = "http://uat.power2sme.com/p2sapi/ws/v3/orderLocationGroup?deviceIds=" . $number;
        $username = 'admin';
        $password = 'admin';
        $process = curl_init($url);

        curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($process, CURLOPT_HTTPGET, TRUE);
        curl_setopt($process, CURLOPT_POSTFIELDS, NULL);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($process);
        curl_close($process);

        if (is_null($result) || $result == "" || !$result || empty($result)) {
            Log::info("\n Java API did not respond \n");
            return 0;
        }

        $dec = json_decode($result, true);

        if (is_null($dec) || $dec == "") {
            Log::info("\n Java API did respond but with a NULL \n");
            return 0;
        }

        $cord = $dec['Data'];

        $long = $cord[0]["long"];
        $lat = $cord[0]["lat"];

        $loc = new \App\locations();
        $loc->device_id = $device_id;
        $loc->dc_number = $dc_number;
        $loc->lat = $lat;
        $loc->long = $long;
        $loc->save();

    }


}
