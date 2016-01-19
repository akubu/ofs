<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Input;
use \App;

class so extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $so_number = Input::get('so_number');
        $raw_details = App\so_details::where('so_number', '=', $so_number)->get();
        $raw_so = App\so::where('so_number', '=', $so_number)->get()->first();
        $details = array();
        $ii = 0;
        foreach ($raw_details as $raw_detail) {
            $details[$ii]['count'] = $ii;
            $details[$ii]['sku'] = $raw_detail->sku;
            $details[$ii]['quantity'] = $raw_detail->sku_quantity;
            $details[$ii]['units'] = $raw_detail->sku_units;
            $details[$ii]['description'] = $raw_detail->sku_description;
            $details[$ii]['shipped'] = 0;
            ++$ii;
        }

//        $shipped_quantity = array_fill(0, $ii, 0);

        $shipped_dc = App\dc::where('so_number', '=', $so_number)->get();

        foreach ($shipped_dc as $dc) {

            $dc_details = App\dc_details::where('dc_number', '=', $dc->dc_number)->get();
            foreach ($dc_details as $dc_detail) {

                for( $yt = 0; $yt <$ii ; ++$yt)
                {
                    if ($dc_detail['sku'] == $details[$yt]['sku']) {
                        $details[$yt]['shipped'] += $dc_detail->sku_quantity;

                    }
                }
            }
        }


        $so_details = array();
        $so_details['so_number'] = $so_number;
        $so_details['customer_number'] = $raw_so->customer_number;
        $so_details['customer_name'] = $raw_so->bill_to_name;


        $fromDc = App\dc::where('so_number', '=', $so_number)->get();




        return view('so.soDetails', compact('so_details', 'details', 'shipped_quantity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function exists(Request $request)
    {
        $so_number = Input::get('so_number');

        $so = \App\so::where('so_number', '=', $so_number)->get();
        if ($so->count() > 0) {
            return 1;
        } else {
            return 0;
        }
    }


    public function details($so_number)
    {
        $response = array();
        $so = \App\so::where('so_number', '=', $so_number)->get()->first();

        if( ! $so){
            Artisan::call('navision:pullSO');
        }


        $details = \App\so_details::where('so_number', '=', $so_number)->get()->toArray();
        $response['details'] = $details;
        $response['ship_to_address'] = $so->ship_to_address;

        $locator =new  locationServices();
        $end_location = $locator->getLatLongFromAddress($response['ship_to_address']);

        if($end_location['end_lat'] == 0)
        {
            $notifier = new notifications();
            $notifier->sendIncorrectAddress($so_number, $so->ship_to_address);
        }
        $response['lat'] = $end_location['end_lat'];
        $response['long'] = $end_location['end_long'];
//        $response['address'] = $end_location['end_address'];

        if($response['lat'] == 0)
        {

        }



//        $response['details'] = array();
//        $ii = 1;
//
//        foreach ($details as $detail) {
//
//            $response['details'][$ii]['sku'] = $detail->sku;
//            $response['details'][$ii]['description'] = $detail->sku_description;
//            $response['details'][$ii]['quantity'] = $detail->sku_quantity;
//            $response['details'][$ii]['unit'] = $detail->sku_units;
//            ++$ii;
//        }
//

        return $response;
    }


    public function test()
    {
        return $this->details("SO/1415/01656");
    }

}
