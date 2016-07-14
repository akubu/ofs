<?php

namespace App\Console\Commands;

use App\BEBBPO;
use Illuminate\Console\Command;
use Log;

class pullPO extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'navision:pullPO';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Log::useDailyFiles(storage_path() . '/logs/laravel.log');

        $nav_locations = BEBBPO::where();



        foreach ($nav_locations as $nav_location) {

            $local_location = \App\BEBBLocalLocations::where('code', '=', $nav_location->{"code"});

            if ($local_location->count() < 1) {

                Log::info("entering this thing " . $nav_location->{"code"});
                $local_location = new \App\BEBBLocalLocations();


                $local_location->code = $nav_location->{"Code"};
                $local_location->name = $nav_location->{"Name"};
                $local_location->address = $nav_location->{"Address"} + " " + $nav_location->{"Address2"} ;
                $local_location->pin = $nav_location->{"Post Code"};
                $local_location->serviceTax = $nav_location->{"Service Tax Registration No_"};
                $local_location->tin = $nav_location->{"T_I_N_ No_"};
                $local_location->tan = $nav_location->{"T_A_N_ No_"};
                $local_location->cst = $nav_location->{"C_S_T No_"};
                $local_location->lst = $nav_location->{"L_S_T_ No_"};
                $local_location->cin = "";
                $local_location->ECC = $nav_location->{"E_C_C_ No_"};


                $local_location->save();



            } else {

            }
        }


        Log::info("\n\n\n\n");
    }
}
