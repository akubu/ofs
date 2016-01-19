<?php

namespace App\Http\Controllers;

use App\dc_details;
use App\dc_track;
use App\device;
use App\document_type_master;
use App\documents;
use App\runner;
use App\so;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Validator;
use Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class dc extends Controller
{
    public function test()
    {
        return view('dc.create');
    }

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
    public function create(Request $request)
    {
        $response = array();
        $response['error'] = '200';
        $response['message'] = 'DC Created';


        $jsonInput = Input::get('json');
        $decoded = json_decode($jsonInput, true);

        $dc_number = $decoded['dc_number'];
        $runner_assigned = $decoded['runner_assigned'];

        $runner_id = substr($runner_assigned, strpos($runner_assigned, "(") + 1, -1);
        $driver_name = $decoded['driver_name'];
        $driver_contact_number = $decoded['driver_contact_number'];
        $truck_number = $decoded['truck_number'];
        $truck_type = $decoded['truck_type'];
        $expected_delivery_date = $decoded['expected_delivery_date'];

        $expected_dispatch_date = $decoded['expected_dispatch_date'];
        $address = $decoded['address'];;
        $lat = $decoded['lat'];
        $long = $decoded['long'];
        $tracking_status = $decoded['tracking_status'];
        $no_tracking_reason = $decoded['no_tracking_reason'];
        $so_number = $decoded['so_number'];


        $sku_details = $decoded['sku_details'];

        //  validate dc_number //

        $validate_dc = \App\dc::where('dc_number', '=', $dc_number)->get()->first();
        if ($validate_dc) {
            $response['error'] = "1001";
            $response['message'] = "please change DC Number";
            return $response;
        }


        $dc = new \App\dc();

        $dc->so_number = $so_number;
        $dc->dc_number = $dc_number;
        $dc->runner_id = $runner_id;
        $dc->driver_id = $driver_name;   //////////////////////   TODO   /////////////////
        $dc->driver_contact_number = $driver_contact_number;
        $dc->truck_number = $truck_number;
        $dc->truck_type = $truck_type;
        $dc->expected_delivery_dt = $expected_delivery_date;
        $dc->expected_dispatch_dt = $expected_dispatch_date;


        $dc->is_tracked = $tracking_status;


        $dc->save();

        foreach ($decoded['sku_details'] as $sku_detail) {
            $dc_detail = new dc_details();
            $dc_detail->dc_number = $dc_number;
            $dc_detail->sku = $sku_detail['sku'];
            $dc_detail->sku_quantity = $sku_detail['sku_quantity'];

            $dc_detail->save();
        }

        $dc_track = new dc_track();
        $dc_track->dc_number = $dc_number;
        $dc_track->no_track_reason = $no_tracking_reason;
        $dc_track->address = $address;
        $dc_track->lat = $lat;
        $dc_track->long = $long;
        $dc_track->device_id = 0;
        $dc_track->save();

        $document_count = document_type_master::all()->count();

        for ($ii = 1; $ii < $document_count + 1; ++$ii) {
            $document = new documents();
            $document->dc_number = $dc_number;
            $document->so_number = $so_number;
            $document->document_type = $ii;
            $document->is_mandatory = 1;
            $document->file_name = 0;
            $document->save();

        }

        $notifier = new notifications();
        $notifier->sendDcCreatedNotification($dc_number, $so_number);


        return 1;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createForm()
    {
        $sos = so::where('is_delivered', '=', 0)->get();
        $so_numbers = array();

        foreach ($sos as $so) {
            $so_numbers[] = $so->so_number;
        }

        return view('dc.create', compact('so_numbers'));
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
    public function show($id)
    {
        //
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

    public function update(Request $request)
    {
        $dc_number = Input::get('dc_number');
        $expected_dispatch_dt = Input::get('expected_dispatch_dt');
        $expected_delivery_dt = Input::get('expected_delivery_dt');

        $dc = \App\dc::where('dc_number', '=', $dc_number)->get()->first();

        $dc->expected_dispatch_dt = $expected_dispatch_dt;
        $dc->expected_delivery_dt = $expected_delivery_dt;
        try {
            $dc->save();
            return 1;
        } catch (\Illuminate\Database\QueryException $e) {
            return 0;
        }
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


    public function newDC(Request $request)
    {
        $so_number = Input::get('so_number');

        $so = new \App\Http\Controllers\so();

        $details = $so->details($so_number);
        $runner_names = array();
        $runners = runner::all();
        foreach ($runners as $runner) {
            $runner_names[] = $runner->runner_name . "(" . $runner->vtiger_id . ")";
        }

//dd($details);
        return view('dc.newDc', compact('details', 'runner_names'));

    }

    public function generateDCNumber()
    {
        $so_number = Input::get('so_number');


        $test = false;
        while(!test) {
            $dc_count = \App\dc::where('so_number', '=', $so_number)->get()->count() + 1;
            $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'); // and any other characters
            shuffle($seed); // probably optional since array_is randomized; this may be redundant
            $rand = array();
            foreach (array_rand($seed, 5) as $k) $rand [] = $seed[$k];

            $dc_number = $so_number . "/" . $dc_count . $rand[3];
            $dc_number = str_replace("SO", "DC", $dc_number);
            $dc = \App\dc::where('dc_number','=',$dc_number)->get()->first();
            if(!$dc){
                $test = true;
            }
        }
//        $dc = \App\dc::where('dc_number','=',$dc_number)->get()->first();
//        if($dc)
//        {
//            TODO
//        }

        return $dc_number;
    }

    public function showAll()
    {
        $responses = array();
        $dcs = \App\dc::where('is_delivered', '=', 0)->get();
        $ii = 0;
        foreach ($dcs as $dc) {
            $responses[$ii]['dc'] = $dc;
            $responses[$ii]['so'] = so::where('so_number', '=', $dc->so_number)->get()->first();
            ++$ii;
        }

        return view('dc.showAll', compact('responses'));
    }


    public function currentAssignments()
    {

        $response = array();
        $dcs = \App\dc::where('is_delivered', '=', 0)->get();
        //
    }


    public function uploadDocumentsSelectDC()
    {
        $dc_numbers = array();
        $dc = \App\dc::where('is_delivered', '=', 0)->get();
        foreach ($dc as $d) {
            $dc_numbers[] = $d->dc_number;
        }

        return view('dc.uploadDocumentsSelectDC', compact('dc_numbers'));
    }

    public function  documentsForDC()
    {
        $response = array();
        $dc_number = Input::get('dc_number');
        $documents = documents::where('dc_number', '=', $dc_number)->get();
        $ii = 1;
        foreach ($documents as $document) {
            $response[$ii]['sno'] = $ii;
            $response[$ii]['id'] = $document->id;
            $response[$ii]['file_name'] = $document->file_name;
            $response[$ii]['sno'] = $ii;
            $response[$ii]['document'] = $document;
            $response[$ii]['type_number'] = $document->document_type;
            $response[$ii]['type'] = document_type_master::where('id', '=', $document->document_type)->get()->first()->document_type;
            ++$ii;
        }
        $dc_number = $dc_number;

        return view('dc.documentsForDC', compact('response', 'dc_number'));
    }


    ///////////////  TODO


    public function documentUpload()
    {

//        dd(Input::all());
//        dd(Input::file('files'));

        $dc_number = Input::get('dc');
        $type = Input::get('type');
        $type_name = document_type_master::where('id', '=', $type)->get()->first()->document_type;
        $type_name = str_replace(" ", "_", $type_name);

        if (Input::hasFile('files')) {
            //upload an image to the /img/tmp directory and return the filepath.
            $file = Input::file('files')[0];
            $tmpFilePath = '/uploads/' . $dc_number . '/';

            $name = $file->getClientOriginalName();
            $ext = end((explode(".", $name)));

            if (strpos($name, 'jpg') || strpos($name, 'jpeg') || strpos($name, 'pdf') || strpos($name, 'doc') || strpos($name, 'docx') || strpos($name, 'png') || strpos($name, 'odt') || strpos($name, 'jpg')
            ) {

                $tmpFileName = $type_name . '-' . str_replace("/", "_", $dc_number) . "." . $ext;//$file->getClientOriginalName();
                $file = $file->move(public_path() . "/" . $tmpFilePath, $tmpFileName);
                $path = $tmpFilePath . $tmpFileName;

                $document = documents::where('dc_number', '=', $dc_number)->where('document_type', '=', $type)->get()->first();
                $document->file_name = "/uploads/" . $dc_number . "/" . $tmpFileName;
                $document->save();

                return response()->json(array('path' => $path), 200);
            } else {
                return 0;
            }
        } else {
            return -1;
        }
    }


    public function manageDC()
    {
        $response = array();
        $dcs = \App\dc::where('is_delivered', '=', 0)->get();
        $ii = 0;
        foreach ($dcs as $dc) {
            $response[$ii]['dc_info'] = $dc;
            $so = so::where('so_number', '=', $dc->so_number)->get()->first();
            $response[$ii]['so_info'] = $so;
            $dc_track = dc_track::where('dc_number', '=', $dc->dc_number)->get()->first();
            $response[$ii]['dc_track_info'] = $dc_track;
            $gsm_number = device::where('device_id', '=', $dc_track->device_id)->get()->first();
            if ($gsm_number) {
                $response[$ii]['device_gsm_number'] = $gsm_number->gsm_number;
            } else {
                $response[$ii]['device_gsm_number'] = 0;
            }
            ++$ii;
        }
        return view('dc.all', compact('response'));
    }

    public function updateForm()
    {

        $dc_number = Input::get('dc_number');
        $dc = \App\dc::where('dc_number', '=', $dc_number)->get()->first();

        return view('dc.update', compact('dc'));
    }

    public function updateDCSelection()
    {

        $response = array();
        $dcs = \App\dc::where('is_delivered', '=', 0)->get();
        $ii = 0;
        foreach ($dcs as $dc) {
            $response[$ii]['dc_info'] = $dc;
            ++$ii;
        }

        return view('dc.dcSelection', compact('response'));
    }

    public function getDownload()
    {

        $file_id = Input::get('file_id');
        $file = documents::where('id', '=', $file_id)->get()->first()->file_name;


        $file_name = end((explode("/", $file)));


        $file_path = public_path() . $file;
        $rr = 0;

        return Response::download($file_path, $file_name);
    }


    public function markDeliveredSelection()
    {

        $dcs = \App\dc::where('is_tracked', '=', 0)->get();
        $dc_numbers = array();
        foreach ($dcs as $dc) {
            $dc_numbers[] = $dc->dc_number;
        }

        return view('dc.markDeliverySelection', compact('dc_numbers'));
    }

    public function markDeliveredForm()
    {

        $dc_number = Input::get('dc_number');

        return view('dc.markDelivered', compact('dc_number'));

    }

    public function markDelivered()
    {

        $dc_number = Input::get('dc_number');
        $date = Input::get('date');

        $dc_track = dc_track::where('dc_number', '=', $dc_number)->get()->first();

        $dc = \App\dc::where('dc_number', '=', $dc_number)->get()->first();

        if (!$dc_track || !$dc) {
            return 0;
        }
        $dc_track->delivered_dt = $date;
        $dc_track->save();


        $dc->is_deliverd = 1;
        $dc->save();

        return 1;

    }

}
