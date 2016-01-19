<?php

namespace App\Http\Controllers;

use App\device;
use App\locations;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class trackDevice extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function currentDeviceLocation()
    {
        $gsm_number = Input::get('gsm_number');
        $device_id = device::where('gsm_number','=',$gsm_number)->get()->first()->device_id;
        $location = \App\locations::where('device_id','=', $device_id)->orderBy('created_at', "DESC")->get()->first();
        $response['current_lat'] = $location->lat ;
        $response['current_long'] = $location->long ;
        $location_service = new locationServices();
        $response['current_address'] = $location_service->getLocationFromLatLong($location->lat, $location->long); ;

        return view('map.singlePoint', compact('response'));
    }


}
