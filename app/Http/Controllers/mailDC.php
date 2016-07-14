<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class mailDC extends Controller
{
    public function mailDC($dc_number){

        return $dc_number;

        $data = array('dc_number'=> $dc_number);

        $mailer = new Mail();

        Mail::send('newx.test',$data,function($message) use ($dc_number)
        {
            $fileName = str_replace('/', '_', $dc_number ) . ".pdf";
            $message->to('harsh.khatri@power2sme.com')
                ->subject('DC Attached')
                ->attach("/Users/harsh/projects/orderFulfillmentSystem/trackingsystem/public/storage/" . $fileName); }
        );

    }
}
