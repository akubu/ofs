<?php

namespace App\Http\Controllers;

use App\dc;
use App\so;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use DateTime;
use Carbon\Carbon ;

class panel extends Controller
{

    public function index()
    {
        $xx = 0;
        $yy = $xx + 1;
        return view('backend.index');
    }

    public function home()
    {
        $response = array();
        $so_undelivered = so::where('is_delivered','=',0)->get();
        $so_undelivered_count = $so_undelivered->count();
        $response['so_undelivered_count'] = $so_undelivered_count;

        $dc_undelivered = dc::where('is_delivered','=',0)->get();
        $dc_undelivered_count = $dc_undelivered->count();

        $response['dc_undelivered_count'] = $dc_undelivered_count;
//User::where('created_at', '>=', new DateTime('today'))

        $date_today = Carbon::now()->toDateString('yy-mm-dd');


        $dispatch_pending_today = dc::whereDate('expected_dispatch_dt','=', $date_today)->where('is_delivered', '=', 0)->get();
        $dispatch_pending_today_count = $dispatch_pending_today->count();
        $response['dispatch_pending_today_count'] = $dispatch_pending_today_count;

        $delivery_pending_today = dc::whereDate('expected_delivery_dt', '=',  $date_today)->where('is_delivered', '=', 0)->get();
        $delivery_pending_today_count = $delivery_pending_today->count();
        $response['delivery_pending_today_count'] = $delivery_pending_today_count;

        $late_delivery = dc::whereDate('expected_delivery_dt', '<', $date_today)->where('is_delivered', '=', 0)->get();
        $late_delivery_count = $late_delivery->count();
        $response['late_delivery_count'] = $late_delivery_count;

        $late_dispatch = dc::whereDate('expected_dispatch_dt', '<', $date_today)->where('is_delivered', '=', 0)->get();
        $late_dispatch_count = $late_dispatch->count();
        $response['late_dispatch_count'] = $late_dispatch_count;



        return view('backend.home', compact('response'));
    }




    public function test()
    {
            echo "hello!!";
    }


}
