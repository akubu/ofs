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

class SoFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'navision:pullSO';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'gets SO information from Navision.';

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
        Log::useDailyFiles(storage_path() . '/logs/navision-pull.log');

        $nav_so = SalesHeader::where('1','=','1')->get();
        Log::info("Master SO count : "  .$nav_so->count() . "\n");

        foreach ($nav_so as $so) {

            $local_so = so::where('so_number', '=', $so->{"No_"});

            if ($local_so->count() < 1) {

                Log::info("entering this thing " . $local_so->count());
                $local_so = new so();

                $local_so->so_number = $so->{"No_"};
                $local_so->customer_number = $so->{"Sell-to Customer No_"};
                $local_so->shipment_type = $so->{"No_"};
                $local_so->bill_to_name = $so->{"Bill-to Name"};
                $local_so->bill_to_address = $so->{"Bill-to Address"};
                $local_so->ship_to_customer = $so->{"No_"};
                $local_so->ship_to_name = $so->{"Ship-to Name"};
                $local_so->ship_to_address = $so->{"Ship-to Address"};
                $local_so->location_code = $so->{"Location Code"};
                $local_so->order_date = $so->{"Order Date"};
                $local_so->posting_date = $so->{"Posting Date"};
                $local_so->shipment_date = $so->{"Shipment Date"};
                $local_so->due_date = $so->{"Due Date"};
                $local_so->requested_delivery_dt = $so->{"Requested Delivery Date"};
                $local_so->promised_delivery_date = $so->{"Promised Delivery Date"};
                $local_so->wishlist_number = $so->{"Quote No_"};
                $local_so->is_delivered = 0;

                $nav_so_details = App\SalesLine::where('Document No_', '=', $local_so->so_number)->get();

                foreach ($nav_so_details as $so_details) {
                    $local_so_details = new App\so_details();
                    $local_so_details->so_number = $so_details->{"Document No_"};
                    $local_so_details->sku = $so_details->{"No_"};
                    $local_so_details->shipment_date = $so_details->{"Shipment Date"};
                    $local_so_details->sku_description = $so_details->{"Description"};
                    $local_so_details->sku_units = $so_details->{"Unit of Measure"};
                    $local_so_details->sku_quantity = $so_details->{"Quantity"};
                    $local_so_details->requested_delivery_dt = $so_details->{"Requested Delivery Date"};
                    $local_so_details->promised_delivery_dt = $so_details->{"Promised Delivery Date"};
                    $local_so_details->planned_delivery_dt = $so_details->{"Planned Delivery Date"};
                    $local_so_details->planned_shipment_dt = $so_details->{"Planned Shipment Date"};
                    $local_so_details->wishlist_number = $so_details->{"Wish List No_"};
                    $local_so_details->save();

                }


                $navContact = App\BEBB_IndiaContact::where('No_', '=', $so->{"Sell-to Customer No_"})->get();
                foreach ($navContact as $navC) {
                    $customer = new  App\customer_contact_master();
                    $customer->customer_number = $navC->{"No_"};
                    $customer->customer_contact_number = $navC->{"Phone No_"};
                    $customer->customer_email = $navC->{"E-Mail"};
                    $customer->save();
                }


                $local_so->save();

                Log::info(" So input " . $local_so->so_number . " \n*\n*\n*cd ");

            } else {
                Log::info("not running for : "  .$so->{"No_"} . "\n");
            }
        }


        Log::info("\n\n\n\n");
    }
}
