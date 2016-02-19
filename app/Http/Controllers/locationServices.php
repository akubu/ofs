<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;

class locationServices extends Controller
{

    public function getLatLongFromAddress($address)
    {

        $response = array();

        $ch = curl_init();
        $location = curl_escape($ch, $address);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $location . "&key=AIzaSyBXxkYt5TxoLuIxJZSDjSd0v--rrbC-b3s";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $address = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($address, true);

        if ($json['status'] == "ZERO_RESULTS") {

            $response['end_lat'] = 0;
            $response['end_long'] = 0;
            $response['end_address'] = 'wrong address';

            // send notification TODO

//            $endLat = "00";   //28
//            $endLong = "00";   //77
        } else {

            $response['end_lat'] = $json['results'][0]['geometry']['location']['lat'];
            $response['end_long'] = $json['results'][0]['geometry']['location']['lng'];
            $response['end_address'] = $json['results'][0]['formatted_address'];

        }

        return $response;

    }




        public function getLocationFromLatLong($lat, $long)
        {
            $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat . "," . $long . "&sensor=true";
            $location = $this->get_data($url);
            $json = json_decode($location, true);
            if($json['status'] == "ZERO_RESULTS")
            {
                return "Unknown";
            }


            $address = $json['results'][0]['formatted_address'];
            return $address;
        }



    public static function get_data($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }


    public function updateDeviceLocation ($device_id){

        Log::useDailyFiles(storage_path() . '/logs/cron-poll.log');


        $number = \App\device::where('device_id','=', $device_id)->get()->first()->gsm_number;

        $dc_number = 0;
        $dc = \App\dc_track::where('device_id', '=', $device_id)->get()->first();

        if($dc){
            $dc_number = $dc->dc_number;
        }

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

        if(count($cord) > 1) {
            if ($cord[0]["long"] && $cord[0]["lat"]) {
                $long = $cord[0]["long"];
                $lat = $cord[0]["lat"];
            }
        }
        else {

                $long = 0;
                $lat = 0;

            }

        $loc = new \App\locations();
        $loc->device_id = $device_id;
        $loc->lat = $lat;
        $loc->long = $long;
        $loc->dc_number = $dc_number;
        $loc->save();

        Log::info("\n\ " . $number . "   " . " \n\n");

    }

}
