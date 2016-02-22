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

class locationPoll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'gets location of all devices.';

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
        Log::useDailyFiles(storage_path() . '/logs/cron-poll.log');

        try{
        $dev = \App\device::all();
        foreach ($dev as $d) {
            $number = $d->gsm_number;
            $dc_number = 0;
            $dc = App\dc_track::where('device_id', '=', $d->device_id)->get()->first();
            if ($dc) {
                $dc_number = $dc->dc_number;
            }
            $url = "http://uat.power2sme.com/p2sapi/ws/v3/orderLocation?deviceId=" . $number;
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

            Log::info($result);

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
            if ($cord) {


                if ($cord[0]["long"] && $cord[0]["lat"]) {
                    $long = $cord[0]["long"];
                    $lat = $cord[0]["lat"];
                } else {

                    $long = 0;
                    $lat = 0;

                }

            }

            $loc = new \App\locations();
            $loc->device_id = $d->device_id;
            $loc->lat = $lat;
            $loc->long = $long;
            $loc->dc_number = $dc_number;

            if($loc->lat != 0)
            {
                $loc->save();
            }


        }
        Log::info("\n\n\n\n*******\n\n\n\n");
    }catch (\Exception $e)
        {
            Log::info($e);
        }
        }

}
