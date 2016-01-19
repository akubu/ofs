<?php

namespace App\Console\Commands;

use App\SalesHeader;
use App\so;
use Illuminate\Console\Command;
use \App\Classes\Curl;
use \App;
use Log;
use Mockery\Exception;
use Redis;

class deviceLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'device:getLocation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'gets location for all devices from Vodafone.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //confingure log
        Log::useDailyFiles(storage_path() . '/logs/device-pull.log');

        $devices = App\device::all();

        foreach ($devices as $device) {

            $gsm_number = $device->gsm_number;

            $device_id = $device->device_id;
            $url = "http://uat.power2sme.com/p2sapi/ws/v3/orderLocation?deviceId=" . $gsm_number;
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
                Log::info("\nAPI not working\n\n");
            }


            $dec = json_decode($result, true);

            if (is_null($dec) || $dec == "") {
                Log::info("\nAPI resulted in null\n\n");
            }

            $cord = $dec['Data'];

            $long = $cord[0]["long"];
            $lat = $cord[0]["lat"];

            $location = new \App\locations();
            $location->device_id = $device_id;
            $location->lat = $lat;
            $location->long = $long;
            $location->save();

        }

        Log::info("\n\n\n\n");
    }
}
