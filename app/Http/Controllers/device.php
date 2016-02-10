<?php

namespace App\Http\Controllers;

use App\device_faults;
use App\runner;
use Illuminate\Database\Console\Migrations\ResetCommand;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Input;
use Session;

class device extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {

        $type = Input::get('type');
        $model = Input::get('model');
        $imei_number = Input::get('imei_number');
        $sim_number = Input::get('sim_number');
        $gsm_number = Input::get('gsm_number');
        $scm_id = Input::get('scm_id');
        $runner_id = Input::get('runner_id');

        $already_registered = \App\device::where('gsm_number', '=', $gsm_number)->get()->first();

        if($already_registered)
        {
            return 0;
        }


        $device = new \App\device();

        $device->device_type = $type;
        $device->device_model = $model;
        $device->imei_number = $imei_number;
        $device->sim_number = $sim_number;
        $device->gsm_number = $gsm_number;
        $device->scm_id = $scm_id;
        $device->dc_number = "0";
        $device->runner_id = $runner_id;

        try {
            $device->save();
                $tmp = \App\device::where('id','=',$device->id)->get()->first();
            $tmp->device_id = $device->id;
            $tmp->save();
            $device->device_id = $device->id;
            $device->save();
            $locationService = new  locationServices();
            $locationService->updateDeviceLocation($device->id);


            return $device->id;


        } catch (\Illuminate\Database\QueryException $e) {

            return 0;

        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $response = array();


        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $device_id = substr($id, 0, strpos($id, "("));
        $device = \App\device::where('device_id','=',$device_id)->get()->first();


        return view('device.show', compact('device'));
    }

    /**
     * tracking page for a device
     *
     * @param  Request $request
     * @return Response
     */
    public function track(Request $request)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {


    }


    public function createForm()
    {
        $vt_user = Session::get('vt_user');

        return view('device.create', compact('vt_user'));
    }


    public function allocateForm()
    {
        $devices = \App\device::where('runner_id', '=',0 )->get();
        $device_ids = array();
        foreach($devices as $device)
        {
            $device_ids[] = $device->id . "(" . $device->device_model . ")" . " " . $device->gsm_number;
        }


        $runner_names = array();

        $runners = runner::all();
        foreach($runners as $runner)
        {
            $runner_names[] = $runner->runner_name . "(" . $runner->vtiger_id . ")";
        }


//        dd($device_ids);
        return view('device.allocateForm', compact('device_ids', 'runner_names'));
    }




    public function allocate(Request $request)
    {
        $device = Input::get('device_id');
        $device_id = substr($device,0, strpos($device, "("));
        $runner_id = Input::get('runner_id');
        $vtiger_id = substr($runner_id, strpos( $runner_id, "(")+1, -1);

        $device = \App\device::where('id','=',$device_id)->get()->first();

        $device->runner_id = $vtiger_id;

        if($device->imei == "runner device")
        {
            return 0;
        }


        try {
            $device->save();
            return 1;

        } catch (\Illuminate\Database\QueryException $e) {

            return 0;

        }


    }

    public function recoverform()
    {
        $devices = array();
        $tmp = \App\device::where('sim_number', '!=', 'runner device')->where('runner_id','!=', 0)->get();
        foreach($tmp as $device)
        {
            $devices[] = $device->id . "(" . $device->device_model . ")" . " " . $device->gsm_number;
        }
        return view('device.recoverForm', compact('devices'));
    }


    public function recover(Request $request)
    {
        $device = Input::get('device_id');
        $device_id = substr($device, 0, strpos($device, "("));
        $device_id = str_replace("+","", $device_id);
        $device = \App\device::where('device_id','=', $device_id)->get()->first();
        $device->runner_id = 0;

        try {

            $device->save();
            return 1;


        } catch (\Illuminate\Database\QueryException $e) {

            return $device_id;

        }

    }


    public function lossForm(){

        $devices = \App\device::all();
        $device_ids = array();
        foreach($devices as $device)
        {
            $device_ids[] = $device->id . "(" . $device->device_model . ")" . " " . $device->gsm_number;
        }

        return view('device.lossForm', compact('device_ids'));

    }

    public function loss(Request $request){

        $device = Input::get('device_id');
        $device_id = substr($device, 0, strpos($device, "("));
        $reason = Input::get('reason');
        $device = \App\device::where('device_id','=', $device_id)->get()->first();

        if($device->dc_number !=0 || $device->dc_number != "")
        {

            return -1;
        }


        if($device->dc_number == "0")
        {
            return 0;
        }

        $device_fault = new device_faults();

        $device_fault->device_id = $device_id;
        $device_fault->runner_owner = $device->runner_id;
        $device_fault->scm_owner = $device->scm_id;
        $device_fault->reason = $reason;

        try{
            $device->delete();
            $device_fault->save();
            return 1;

        }catch (\Illuminate\Database\QueryException $e) {

            return 0;
        }

    }

    public function showAll(){

        $devices = \App\device::where('device_id','>',0)->get();
        return view('device.allDevices', compact('devices'));
    }

}
