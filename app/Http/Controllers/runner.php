<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Mockery\CountValidator\Exception;

class runner extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $response = array();
        $runners = App\runner::all();
        $ii = 0;
        foreach ($runners as $runner) {
//            $response[] = $runner->runner_name;

            $response[$ii]['name'] = $runner->runner_name;
            $response[$ii]['vtiger_id'] = $runner->vtiger_id;
        }
        return $response;
//        return response()->json($response);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {

        $runner_name = Input::get('runner_name');
        $vtiger_id = strtoupper(Input::get('vtiger_id'));
        $runner_address = Input::get('runner_address');
        $runner_station_address = Input::get('runner_station_address');
        $runner_contact_number_1 = Input::get('runner_contact_number_1');
        $runner_contact_number_2 = Input::get('runner_contact_number_2');
        $runner_email = Input::get('runner_email');
        $reports_to_name = Input::get('reports_to_name');
        $reports_to_email = Input::get('reports_to_email');

        $runner = App\runner::where('vtiger_id', '=', $vtiger_id)->get();
        if ($runner->count() > 0) {
            return -1;
        }

        $runner = new App\runner();

        $runner->runner_name = $runner_name;
        $runner->vtiger_id = $vtiger_id;
        $runner->runner_address = $runner_address;
        $runner->runner_station_address = $runner_station_address;
        $runner->runner_contact_number_1 = $runner_contact_number_1;
        $runner->runner_contact_number_2 = $runner_contact_number_2;
        $runner->runner_email = $runner_email;
        $runner->reports_to_email = $reports_to_email;
        $runner->reports_to_name = $reports_to_name;


        $device = new \App\device();

        $device->device_type = "Android device";
        $device->device_model = "runner device";
        $device->imei_number = "runner device";
        $device->sim_number = "runner device";
        $device->gsm_number = $runner_contact_number_1;
        $device->scm_id = Session::get('vt_user');;
        $device->runner_id = $vtiger_id;


        try {
            $device->save();

            $tmp = \App\device::where('id', '=', $device->id)->get()->first();
            $tmp->device_id = $device->id;
            $tmp->save();
            $device->device_id = $device->id;
            $device->save();
            $locationService = new locationServices();
            $locationService->updateDeviceLocation($device->id);
            $runner->save();

            $locationservice = new locationServices();
            $locationservice->updateDeviceLocation($device->id);

            return 1;


        } catch (\Illuminate\Database\QueryException $e) {

//            var_dump($e->errorInfo );
//                $response = array();
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
        //
    }


    /**
     * tracking page for a runner
     *
     * @param  Request $request
     * @return Response
     */
    public function track(Request $request)
    {


    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function showAll()
    {
        $response = array();
        $runners = App\runner::all();
        $ii = 0;
        foreach ($runners as $runner) {
            $response[$ii]['runner_info'] = $runner;
            $gsm_number = $runner->runner_contact_number_1;

            $device_id = App\device::where('gsm_number', '=', $gsm_number)->get()->first()->device_id;
            $location = App\locations::where('device_id', '=', $device_id)->orderBy('created_at', "DESC")->get()->first();
            $response[$ii]['current_lat'] = $location->lat;
            $response[$ii]['current_long'] = $location->long;
            $location_service = new locationServices();
            if ($location->lat > 0 && $location->long > 0) {

                $response[$ii]['current_address'] = $location_service->getLocationFromLatLong($location->lat, $location->long);
            } else {
                $response[$ii]['current_address'] = "Unknown";
            }

            ++$ii;
        }

        return view('runner.all', compact('response'));
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
    public function update(Request $request)
    {

        $runner_name = Input::get('runner_name');


        $vtiger_id = Input::get('vtiger_id');
        $runner_address = Input::get('runner_address');
        $runner_station_address = Input::get('runner_station_address');
        $runner_contact_number_1 = Input::get('runner_contact_number_1');
        $runner_contact_number_2 = Input::get('runner_contact_number_2');
        $runner_email = Input::get('runner_email');
        $reports_to_name = Input::get('reports_to_name');
        $reports_to_email = Input::get('reports_to_email');

        $runner = App\runner::where('vtiger_id', '=', $vtiger_id)->get()->first();

        $runner->runner_address = $runner_address;
        $runner->runner_station_address = $runner_station_address;
        $runner->runner_contact_number_1 = $runner_contact_number_1;
        $runner->runner_contact_number_2 = $runner_contact_number_2;
        $runner->runner_email = $runner_email;
        $runner->reports_to_email = $reports_to_email;
        $runner->reports_to_name = $reports_to_name;
        $runner->reports_to_name = $reports_to_name;
        try {
            $runner->save();
        } catch (Exception $e) {
            $x = $e;
            return e;
        }
        return "<h3> Info for Runner : \" " . $runner_name . " \" Modified</h3>";


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $runner_name = Input::get('runner_name');
        $vtiger_id = substr($runner_name, strpos($runner_name, "(") + 1, -1);
        $runner = App\runner::where('vtiger_id', '=', $vtiger_id)->get()->first();
        $device = App\device::where('gsm_number', '=', $runner->runner_contact_number_1)->get()->first();

        $runner_dc = App\dc::where('runner_id', '=', $vtiger_id)->where('is_delivered', '=', 0)->get()->first();


        if ($runner_dc) {
            return -1;
        }


        try {

            $runner->delete();

            $device->delete();

            return 1;
        } catch (Exception $e) {
            $x = $e;
            return 0;
        }

        return 1;
    }

    public function  createForm()
    {
        return view('runner.create');
    }

    public function deleteForm()
    {

        $runners = App\runner::all();
        $response = array();
        foreach ($runners as $runner) {
            $response[] = $runner->runner_name . "(" . $runner->vtiger_id . ")";
        }
        $runner_names = $response;

        return view('runner.deleteForm', compact('runner_names'));
    }


    public function editForm(Request $request)
    {
        $runner_name = Input::get('runner_name');


        if ($runner_name) {

            $vtiger_id = substr($runner_name, strpos($runner_name, "(") + 1, -1);
            $runner = App\runner::where('vtiger_id', '=', $vtiger_id)->get()->first();
            if (!$runner) {
                return $vtiger_id;
            }
//            dd($runner);
            return view('runner.editForm', compact('runner'));
        } else {
            $response = array();

            $runners = App\runner::all();
            foreach ($runners as $runner) {
                $response[] = $runner->runner_name . "(" . $runner->vtiger_id . ")";
            }
            $runner_names = $response;

            return view('runner.edit', compact('runner_names'));
        }
    }

    public function validateRunner()
    {


        $runner_name = Input::get('runner');
        $vtiger_id = substr($runner_name, strpos($runner_name, "(") + 1, -1);
        $runner = App\runner::where('vtiger_id', '=', $vtiger_id)->get();

        if ($runner->count()) {
            return 1;
        } else {
            return 0;
        }

    }

}
