<?php

namespace App\Http\Controllers;

use App\customer_contact_master;
use App\dc;
use App\so;
use App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class notifications extends Controller
{




    function sendNotification($datax)
    {
        $username = 'admin';
        $password = 'admin';
        $URL = 'http://103.25.172.110:8080/p2sapi/ws/v3/userlogin';

        $cookie_jar = tempnam('/tmp', 'cookie');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLINFO_HEADER_OUT, false);

        $data = array("userId" => "BI00407",
            "password" => "dintrin@v");
        $data_string = json_encode($data);

        if (strpos($data_string, 'success'))

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code

        $headers = curl_getinfo($ch, CURLINFO_HEADER_OUT);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);

        curl_close($ch);

        $url = "http://103.25.172.110:8080/openbd/mq/endpoint.cfc";

         $data = array("method" => "enqueue",
             "payload" => $datax['payload']
         );


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);

        if($result > 0)
        {
            return 1;
        }else{
            return 0;
        }

    }

    public function sendDcCreatedNotification($dc_number, $so_number)
    {
        $customer_number = \App\so::where('so_number', '=', $so_number)->get()->first();
        if(!$customer_number){
            $customer_number = 0;
            return 0;
        }else{
            $customer_number = $customer_number->customer_number;
        }
        $customer = customer_contact_master::where('customer_number', '=', $customer_number)->get()->first();

        $customer_email = $customer->customer_email;
        $customer_phone = $customer->customr_contact_number;

        $data = array("method" => "enqueue", "payload" => "<payload><object>order</object><event>dc registered</event><object_id></object_id><customer><email_id>" . "harsh.khatri@power2sme.com" . "</email_id><mobile_no>" . "9968898636" . "</mobile_no></customer><so_number>" . $so_number . "</so_number><dc_no>" . $dc_number . "</dc_no></payload>" );
            $status =  $this->sendNotification($data);
        if($status > 0)
        {


            return $status;
        }else{
            return 0;
        }

    }

    public function sendLoadingStartedNotification($dc_number)
    {
        $so_number = dc::where('dc_number','=',$dc_number)->get()->first()->so_number;
        $so = so::where('so_number', '=', $so_number)->get()->first();
        $customer_number = $so->customer_number;
        $customer_name = $so->bill_to_name;
        $customer = customer_contact_master::where('customer_number', '=', $customer_number)->get()->first();

        $customer_email = $customer->customer_email;
        $customer_phone = $customer->customr_contact_number;

        $data = array("method" => "enqueue", "payload" => "<payload><object>order</object><event>loading started</event><object_id></object_id><customer><email_id>" . "harsh.khatri@power2sme.com" . "</email_id><mobile_no>" . "9968898636" . "</mobile_no></customer><name>" . $customer_name . "</name><dc_no>" . $dc_number . "</dc_no></payload>") ;
            return $this->sendNotification($data);
    }

    public function sendDispatchNotification($dc_number)
    {

        $data = array("method" => "enqueue", "payload" => "<payload><object>order</object><event>dispatch</event><object_id></object_id><customer><email_id>" . "harsh.khatri@power2sme.com" . "</email_id><mobile_no>" . "9968898636" . "</mobile_no></customer><name>" . "harsh khatri" . "</name><dc_no>" . $dc_number . "</dc_no></payload>");
            return $this->sendNotification($data);
    }

    public function sendDeliveredNotification($dc_number)
    {
        $so_number = dc::where('dc_number','=',$dc_number)->get()->first()->so_number;
        $so = so::where('so_number', '=', $so_number)->get()->first()->customer_number;
        $customer_number = $so->customer_number;
        $customer_name = $so->bill_to_name;
        $customer = customer_contact_master::where('customer_number', '=', $customer_number)->get()->first();

        $customer_email = $customer->customer_email;
        $customer_phone = $customer->customr_contact_number;

        $data = array("method" => "enqueue", "payload" => "<payload><object>order</object><event>delivery notification</event><object_id></object_id><customer><email_id>" . "harsh.khatri@power2sme.com" . "</email_id><mobile_no>" . "9968898636" . "</mobile_no></customer><name>" . $customer_name . "</name><invoice_no>" . $dc_number . "</invoice_no></payload>");
            return $this->sendNotification($data);
    }

    public function sendIncorrectAddress($so_number, $address)
    {

        $data = array("method" => "enqueue", "payload" => "<payload><object>order</object><event>error report</event><object_id></object_id><customer><email_id>" . "harsh.khatri@power2sme.com" . "</email_id><mobile_no>" . "9968898636" . "</mobile_no></customer><so_number>" . $so_number . "</so_number><address>" . $address . "</address></payload>" );
          return  $this->sendNotification($data);
    }

    public function reportNotification($values){

        $response = array();
        $data = array("method" => "enqueue", "payload" => "<payload><object>order</object><event>daily report</event><object_id></object_id><customer><email_id>" . "harsh.khatri@power2sme.com" . "</email_id><mobile_no>" . "9968898636" . "</mobile_no></customer><dispatch_pending_today_count>" . $values['dispatch_pending_today_count'] . "</dispatch_pending_today_count><delivery_pending_today_count>" . $values['delivery_pending_today_count'] . "</delivery_pending_today_count><late_delivery_count>" . $values['late_delivery_count'] . "</late_delivery_count><late_dispatch_count>".$values['late_dispatch_count']."</late_dispatch_count></payload>" );

        $response['payload'] = $data;
        $response['status'] = $this->sendNotification($data);


        return  $response;

    }

}
