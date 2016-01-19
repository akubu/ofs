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
use Carbon\Carbon ;

class notificationAutomatic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:automaticReport';

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
        Log::useDailyFiles(storage_path() . '/logs/notification_automatic.log');


        $dcs = App\dc::where('is_delivered','=', 0)->get();



            $date_today = Carbon::now()->toDateString('yy-mm-dd');


            $dispatch_pending_today = \App\dc::whereDate('expected_dispatch_dt','=', $date_today)->where("is_delivered", '=', 0)->get();
            $dispatch_pending_today_count = $dispatch_pending_today->count();
            $response['dispatch_pending_today_count'] = $dispatch_pending_today_count;

            $delivery_pending_today =\App\dc::whereDate('expected_delivery_dt', '=',  $date_today)->where("is_delivered", '=', 0)->get();
            $delivery_pending_today_count = $delivery_pending_today->count();
            $response['delivery_pending_today_count'] = $delivery_pending_today_count;

            $late_delivery = \App\dc::whereDate('expected_delivery_dt', '<', $date_today)->where("is_delivered", '=', 0)->get();
            $late_delivery_count = $late_delivery->count();
            $response['late_delivery_count'] = $late_delivery_count;

            $late_dispatch = \App\dc::whereDate('expected_dispatch_dt', '<', $date_today)->where("is_delivered", '=', 0)->get();
            $late_dispatch_count = $late_dispatch->count();
            $response['late_dispatch_count'] = $late_dispatch_count;

            $notifier = new App\Http\Controllers\notifications();


            $status = $notifier->reportNotification($response);

        Log::info("\n\n\n\n" . implode(" ",$status['payload']). "\n\n" . $status['status']. "\n\n");






    }
}
