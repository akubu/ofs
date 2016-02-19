<?php

namespace App\Http\Controllers;

use App\dc;
use App\dc_details;
use App\dc_track;
use App\delivery;
use App\device;
use App\locations;
use App\runner;
use App\so_details;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class androidApi extends Controller
{


    public function runnerDetails($id)
    {

        $response = array();

        $idCheck = \App\runner::where('vtiger_id', '=', $id)->get()->first();

        if (!$idCheck) {
            $response['error'] = "1";
            $response['id'] = "0";
            $response['password'] = "xfcgdfg435ersgs";
            return $response;
        }


        $response['error'] = "0";

        $runner = \App\runner::where('vtiger_id', '=', $id)->get()->first();
        $dc = \App\dc::where('runner_id', '=', $id)->where('is_delivered', '=', 0)->where('is_tracked', '=', 3)->get();

        $response['name'] = $runner->runner_name;
        $response['id'] = $runner->vtiger_id;
        $response['password'] = "123456";

        $dcCount = $dc->count();

        if ($dcCount > 0) {

//            $response['invoices'] = array();

            $ii = 0;
            //echo "<br>".$invoiceCount."<br>";

            foreach ($dc as $inv) {

                $dc_details = dc_details::where('dc_number', '=', $inv->dc_number)->get();

                $detail = "";

                $device_for_dc = device::where('dc_number', '=', $inv->dc_number)->get()->first();
                if ($device_for_dc) {

                    foreach ($dc_details as $dc_detail) {
                        $sku = so_details::where('so_number', '=', $inv->so_number)->where('sku', '=', $dc_detail->sku)->get()->first();

                        if ($dc_detail->sku_quantity > 0) {
                            $detail .= $sku->sku_description . " " . $dc_detail->sku_quantity . " " . $sku->sku_units . ";";
                        }

                    }


                    $response['invoices'][$ii]['invoice_id'] = $inv->dc_number;
                    $response['invoices'][$ii]['vehicle_number'] = $inv->truck_number;
                    $response['invoices'][$ii]['details'] = $detail;
                    $response['invoices'][$ii]['devices'] = array();

                    $deviceList = \App\device::where('dc_number', '=', $inv->dc_number)->get();

                    $dx = 0;
                    foreach ($deviceList as $dev) {
                        $response['invoices'][$ii]['devices'][$dx]['id'] = $dev->device_id;
                        ++$dx;
                    }
                    ++$ii;
                }


            }

        }

        //var_dump($response);
        return $response;


    }


    public function getRunnerAllocations($runner_id)
    {

        $runner_id = strtoupper($runner_id);

        $response = array();

        $runner_alocation = \App\dc::where('runner_id', '=', $runner_id)->where('is_delivered', '=', 0)->where('is_tracked', '=', 1)->get();

        $count = $runner_alocation->count();


        $ii = 0;

        if ($count == 0) {

            $response['count'] = 0;
            $response[$ii]['vehicle_number'] = "not available";
            $response[$ii]['invocie_number'] = "not available";

            return $response;
        }


        foreach ($runner_alocation as $assignment) {

            $start_check = device::where('dc_number', '=', $assignment->dc_number)->get();
            if ($start_check->count() == 0) {
                $response[$ii]['vehicle_number'] = $assignment->truck_number;
                $response[$ii]['invocie_number'] = $assignment->dc_number;
                ++$ii;
            }
        }

        $response['count'] = $ii;
        return $response;

    }


    public function getAttachedDevices($runner_id)
    {
        $response = array();
        $runner_id = strtoupper($runner_id);

        $dcs = dc::where('runner_id', '=', $runner_id)->where('is_delivered', '=', 0)->where('is_tracked', '=', 2)->get();

        $count = $dcs->count();


        $response['count'] = $count;
        $response[0]['vehicle_number'] = "not available";
        $response[0]['invocie_number'] = "not available";
        $response[0]['device_id'] = "not available";


        $ii = 0;
        foreach ($dcs as $dc) {
            $device = device::where('dc_number', '=', $dc->dc_number)->get()->first();
            if ($device) {

                $response[$ii]['vehicle_number'] = $dc->truck_number;
                $response[$ii]['invocie_number'] = $dc->dc_number;
                $response[$ii]['device_id'] = $device->device_id;
                ++$ii;
            }
        }

        $response['count'] = $ii;

        return $response;

    }


    public function deliver($d1, $d2, $d3, $d4, $deviceId, $comment)
    {
        $response = array();

        $dc_number = $d1 . "/" . $d2 . "/" . $d3 . "/" . $d4;

        $dc = dc::where('dc_number', '=', $dc_number)->where('is_delivered', '=', 0)->get()->first();

        if ($dc) {

            $device = device::where('device_id', '=', $deviceId)->get()->first();
            $device->dc_number = '0';
            $device->runner_id = '0';
            $dc->is_delivered = 1;
            $dc_track = dc_track::where('dc_number', '=', $dc_number)->get()->first();
            $dc_track->delivered_dt = \Carbon\Carbon::now();
            $dc_track->save();
            $delivery = new delivery();
            $delivery->dc_number = $dc_number;
            $delivery->comment = $comment;
            $delivery->runner_id = $dc->runner_id;
            $delivery->save();


            $device->save();
            $dc->save();

            $notifier = new notifications();
            $notifier->sendDeliveredNotification($dc_number);

            $response['status'] = "1";
            return $response;
        } else {
            $response['status'] = "0";
            return $response;
        }


    }


    public function attach($truck_number, $device_id)
    {

        $response = array();

        $device = device::where('device_id', '=', $device_id)->where('dc_number', '=', '0')->get()->first();
        $dc = dc::where('truck_number', '=', $truck_number)->where('is_tracked', '=', 1)->where('is_delivered', '=', 0)->get()->first();


        if ($device && $dc) {

            $dc->is_tracked = 2;
            $dc->save();

            if ($device->dc_number == 0) {
                $device->dc_number = $dc->dc_number;
                $device->runner_id = $dc->runner_id;
                $device->save();
                $dc_track = dc_track::where('dc_number', '=', $dc->dc_number)->get()->first();
                $dc_track->loading_start_dt = \Carbon\Carbon::now();
                $dc_track->device_id = $device_id;
                $dc_track->save();

                $response['status'] = "1";

                $notifier = new notifications();
                $notifier->sendLoadingStartedNotification($device->dc_number);

            } else {
                $response['status'] = "0";

            }
            return $response;
        } else {

            $response['status'] = "0";
            return $response;
        }

    }


    public function startTracking($id1, $id2, $id3, $id4, $device_id, $runner_id)
    {


        $runner_id = strtoupper($runner_id);

        $response = array();
        $dc_number = $id1 . "/" . $id2 . "/" . $id3 . "/" . $id4;
        $device = device::where('device_id', '=', $device_id)->where('dc_number', '=', $dc_number)->get()->first();
        $runner = runner::where('vtiger_id', '=', $runner_id)->get()->first();


        if (is_null($device) || is_null($runner)) {
            $response['msg'] = "error";
            $response['invoice'] = "0";
            $response['device'] = "0";
            return $response;
        }

        $dc_track = dc_track::where('dc_number', '=', $dc_number)->get()->first();
        $dc = dc::where('dc_number', '=', $dc_number)->get()->first();
        $dc->is_tracked = 3;
        $dc->save();

        if ($dc_track) {
            $response['msg'] = "success";
            $response['invoice'] = "1";
            $response['device'] = "1";
            $dc_track->shipment_start_dt = \Carbon\Carbon::now();
            $dc_track->save();

            $notifications = new notifications();
            $notifications->sendDispatchNotification($dc_number);

            $location_service = new locationServices();
            $location_service->updateDeviceLocation($device_id);

            return $response;
        } else {
            $response['msg'] = "error";
            $response['invoice'] = "0";
            $response['device'] = "0";
            return $response;
        }

    }

    public function getLocation($device_id)
    {

        $response = array();
        $device = device::where('device_id', '=', $device_id)->get()->first();

        $response['error'] = "0";

        if (!$device) {
            $response['startLat'] = "28.613939";
            $response['startLong'] = "77.209021";
            $response['currLat'] = "28.613939";
            $response['currLong'] = "77.209021";
            $response['endLat'] = "28.613939";
            $response['endLong'] = "77.209021";
            $response['error'] = "7001";
            return $response;
        }

        $dc_number = $device->dc_number;

        $dc_track = dc_track::where('dc_number', '=', $dc_number)->get()->first();

        if (!$dc_track) {

            $response['startLat'] = "28.613939";
            $response['startLong'] = "77.209021";
            $response['currLat'] = "28.613939";
            $response['currLong'] = "77.209021";
            $response['endLat'] = "28.613939";
            $response['endLong'] = "77.209021";
            $response['error'] = "7001";
            return $response;
        }

        $start = locations::where('device_id', '=', $device_id)->where('created_at', '>=', $dc_track->shipment_start_dt)->orderBy('created_at', "ASC")->get()->first();

        $start_lat = $start->lat;
        $start_long = $start->long;

        $current = locations::where('device_id', '=', $device_id)->where('created_at', '>=', $dc_track->shipment_start_dt)->orderBy('created_at', "DESC")->get()->first();

        $current_lat = $current->lat;
        $current_long = $current->long;


        $end_lat = $dc_track->lat;
        $end_long = $dc_track->long;


        if( $start_lat == 0 || $start_long || $end_lat == 0 || $end_long == 0 || $current_lat == 0 || $current_long == 0 )
        {
            $response['error'] = "7001";
        }

        $response['startLat'] = $start_lat;
        $response['startLong'] = $start_long;
        $response['currLat'] = $current_lat;
        $response['currLong'] = $current_long;
        $response['endLat'] = $end_lat;
        $response['endLong'] = $end_long;

        return $response;

    }


    public function getLocationWithAddress($device_id)
    {

        $response = array();
        $device = device::where('device_id', '=', $device_id)->get()->first();
        $dc_number = $device->dc_number;

        $dc_track = dc_track::where('dc_number', '=', $dc_number)->get()->first();

        $start = locations::where('device_id', '=', $device_id)->where('created_at', '>=', $dc_track->shipment_start_dt)->orderBy('created_at', "ASC")->get()->first();

        if(!$start)
        {
            $response['startLat'] = "28.613939";
            $response['startLong'] = "77.209021";
            $response['currLat'] = "28.613939";
            $response['currLong'] = "77.209021";
            $response['endLat'] = "28.613939";
            $response['endLong'] = "77.209021";
            $start_address = "Cannot determine address";
            $end_address = "Cannot determine address";
            $current_address = "Cannot determine address";
            $response['start_address'] = $start_address;
            $response['current_address'] = $current_address;
            $response['end_address'] = $end_address;
            return $response;
        }


        $start_lat = $start->lat;
        $start_long = $start->long;

        $current = locations::where('device_id', '=', $device_id)->where('created_at', '>=', $dc_track->shipment_start_dt)->orderBy('created_at', "DESC")->get()->first();

        if(!$current)
        {
                $response['startLat'] = "28.613939";
                $response['startLong'] = "77.209021";
                $response['currLat'] = "28.613939";
                $response['currLong'] = "77.209021";
                $response['endLat'] = "28.613939";
                $response['endLong'] = "77.209021";
                $start_address = "Cannot determine address";
                $end_address = "Cannot determine address";
                $current_address = "Cannot determine address";
                $response['start_address'] = $start_address;
                $response['current_address'] = $current_address;
                $response['end_address'] = $end_address;
                return $response;

        }

        $current_lat = $current->lat;
        $current_long = $current->long;

        $end = dc_track::where('dc_number', '=', $dc_number)->get()->first();

        if(!$end)
        {
            $response['startLat'] = "28.613939";
            $response['startLong'] = "77.209021";
            $response['currLat'] = "28.613939";
            $response['currLong'] = "77.209021";
            $response['endLat'] = "28.613939";
            $response['endLong'] = "77.209021";
            $start_address = "Cannot determine address";
            $end_address = "Cannot determine address";
            $current_address = "Cannot determine address";
            $response['start_address'] = $start_address;
            $response['current_address'] = $current_address;
            $response['end_address'] = $end_address;
            return $response;
        }

        $end_lat = $end->lat;
        $end_long = $end->long;

        $locationService = new locationServices();

        $start_address = "Cannot determine address";
        $end_address = "Cannot determine address";
        $current_address = "Cannot determine address";


        if ($start_lat == 0) {

        } else {
            $start_address = $locationService->getLocationFromLatLong($start_lat, $start_long);
        }

        if ($end_lat == 0) {

        } else {
            $end_address = $locationService->getLocationFromLatLong($end_lat, $end_long);
        }
        if ($current_lat == 0) {

        } else {
            $current_address = $locationService->getLocationFromLatLong($current_lat, $current_long);
        }


        //{"startLat":"28.47814","startLong":"77.13025","endLat":"28.8054651","endLong":"77.0463008","currLat":"28.47814","currLong":"77.13025"}

        $response['startLat'] = $start_lat;
        $response['startLong'] = $start_long;
        $response['currLat'] = $current_lat;
        $response['currLong'] = $current_long;
        $response['endLat'] = $end_lat;
        $response['endLong'] = $end_long;
        $response['start_address'] = $start_address;
        $response['current_address'] = $current_address;
        $response['end_address'] = $end_address;


        return $response;


    }


    public function  getTrackingStatus(Request $request)
    {
        $response = array();

        if ($request->input('sme_id')) {
            $SMEID = $request->input('sme_id');
            $response['sme_id'] = $SMEID;

            $all_so = \App\so::where('customer_number', '=', $SMEID)->get();//->where('deliverystatus', '=', '0')->groupBy('so_number')->get();

            $orders = array();
            foreach ($all_so as $so) {

                $dcs = dc::where('so_number', '=', $so->so_number)->where('is_tracked', '=', 3)->get();

                if ($dcs) {
                    foreach ($dcs as $dc)
                        $orders[] = $dc;
                }
            }

            if (!$orders) {

                $response['error'] = "1";
                $response['error_message'] = "No orders are on tracking for this SME_ID";
                return $response;

            } else {
                $response['error'] = "0";
                $response['error_message'] = "success";

            }


            $count_order = 0;
            foreach ($orders as $order) {
                $dcs = \App\dc::where('so_number', '=', $order->so_number)->where('is_delivered', '=', '0')->where('is_tracked', '=', 3)->get();


                if (!$dcs) {
                    return $response;
                }

                $response['orders'][$count_order]['order_number'] = $order->so_number;
                $count_invoice = 0;
                $dc = $order;
                {
                    $detailsRaw = \App\dc_details::where('dc_number', '=', $dc->dc_number)->get();
                    $details = array();
                    if (!empty($detailsRaw)) {
                        $counter = 0;
                        foreach ($detailsRaw as $detail) {
                            $details[$counter]['material'] = $detail->{'sku'};
                            $details[$counter]['quantity'] = $detail->{'sku_quantity'};
                            $details[$counter]['units'] = $detail->{'sku_units'};
                            ++$counter;
                        }
                    }


                    $response['orders'][$count_order]['invoices'][$count_invoice]['invoice_number'] = $dc->dc_number;
                    $response['orders'][$count_order]['invoices'][$count_invoice]['shipment_time']['date'] = dc_track::where('dc_number', '=', $dc->dc_number)->get()->first()->shipment_start_dt;
                    $response['orders'][$count_order]['invoices'][$count_invoice]['shipment_time']['timezone_type'] = "";
                    $response['orders'][$count_order]['invoices'][$count_invoice]['shipment_time']['timezone'] = "";
                    $response['orders'][$count_order]['invoices'][$count_invoice]['vehicle_number'] = $dc->truck_number;
                    $response['orders'][$count_order]['invoices'][$count_invoice]['driver_name'] = $dc->driver_id;
                    $response['orders'][$count_order]['invoices'][$count_invoice]['driver_number'] = $dc->driver_contact_number;
                    $response['orders'][$count_order]['invoices'][$count_invoice]['materials'] = $details;

                    $count = 0;
                    foreach ($response['orders'][$count_order]['invoices'][$count_invoice]['materials'] as $detail) {
                        $response['orders'][$count_order]['invoices'][$count_invoice]['materials'][$count]['units'] =  $detail['units'];
                        ++$count;
                    }
                    $device = device::where('dc_number', '=', $dc->dc_number)->get()->first();

                    $addresses = $this->getLocationWithAddress($device->device_id);

                    if(!$addresses['current_address'])
                    {
                        $response['orders'][$count_order]['invoices'][$count_invoice]['current_address'] = "Cannot be determined";
                    }else{
                        $response['orders'][$count_order]['invoices'][$count_invoice]['current_address'] = $addresses['current_address'];
                    }


                    $endLat = $addresses['endLat'];
                    $endLong = $addresses['endLong'];

                    $currLat = $addresses['currLat'];
                    $currLong = $addresses['currLong'];

                    $response['orders'][$count_order]['invoices'][$count_invoice]['estimated_schedule'] = $this->GetDrivingDistance($endLat, $currLat, $endLong, $currLong);
                    $response['orders'][$count_order]['invoices'][$count_invoice]['download_link'] = "";


                    ++$count_invoice;
                }
                ++$count_order;
            }


        } else {
            $response['error'] = "1";
            $response['error_message'] = "No order on tracking for this SME_ID";
        }

        return $response;

    }


    public function GetDrivingDistance($lat1, $lat2, $long1, $long2)
    {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat2 . "," . $long2 . "&destinations=" . $lat1 . "," . $long1 . "&mode=driving&language=pl-PL";

        if ($lat1 == 0 || $lat2 == 0 || $long1 == 0 || $long2 == 0) {


            $dist = 0;
            $time = 0;
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            $response_a = json_decode($response, true);

            $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
            $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

            $dist = str_replace(",", ".", $dist);
            $dist = str_replace("km", "kms", $dist);

            $time = str_replace("godz.", "hours", $time);

        }


        return array('distance' => $dist, 'time' => $time);
    }


    public function  getOrderLocation(Request $request)
    {
        $response = array();

        if ($request->input('invoice_number')) {

            $inv = $request->input('invoice_number');


            $device = \App\device::where('dc_number', '=', $inv)->get()->first();


            if (!$device) {
                $response['error'] = "1";
                $response['error_message'] = "please enter valid invoice number";
                return $response;
            }
            $device = $device->device_id;
            $response['error'] = "0";
            $response['error_message'] = "0";

            $locations = $this->getLocationWithAddress($device);

            $response['start_lat'] = $locations['startLat'];
            $response['start_long'] = $locations['startLong'];
            $response['current_lat'] = $locations['currLat'];

            $response['current_long'] = $locations['currLong'];
            $response['end_lat'] = $locations['endLat'];
            $response['end_long'] = $locations['endLong'];

            $response['start_address'] = $locations['start_address'];
            $response['current_address'] = $locations['current_address'];
            $response['end_address'] = $locations['end_address'];

            return $response;


        } else {
            $response['error'] = "1";
            $response['error_message'] = "please enter valid invoice number";
            return $response;
        }
    }

    public function runnerLocationSink(Request $request)
    {
        $response = array();
        $count = "0";

        try {
            $entries = $request->all();


            foreach ($entries['Data'] as $data) {
                $runner_id = $data['runner_id'];
                $current_lat = $data['current_lat'];
                $current_long = $data['current_long'];
                $timestamp = $data['timestamp'];

                $runner_sink = new \App\runner_sink();

                $runner_sink->runner_id = $runner_id;
                $runner_sink->current_lat = $current_lat;
                $runner_sink->current_long = $current_long;
                $runner_sink->timestamp = $timestamp;

                $runner_sink->save();
                ++$count;
            }

            $response["Message"] = "Success";
            $response["ErrorCode"] = 0;
            $response["TotalRecords"] = 0;
            $cc['object_type_id'] = 0;
            $cc['posted_count'] = $count;
            $response["Data"] = $cc;


        } catch (Exception $e) {

            $response["Message"] = "Something wrong has Happened at server!! please report...";
            $response["ErrorCode"] = 1001;
            $response["TotalRecords"] = 0;
            $cc['object_type_id'] = 0;
            $response["Data"] = $cc;

        }

        return $response;

    }
}
