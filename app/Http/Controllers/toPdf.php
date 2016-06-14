<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use mikehaertl\wkhtmlto\Pdf;

class toPdf extends Controller
{

    public function toPdf($dc_number)
    {

        echo "here";

        $dc_file = str_replace('/', '_', $dc_number);

// Create a new Pdf object with some global PDF options
        $pdf = new Pdf(array(
            'no-outline',         // Make Chrome not complain
            'margin-top'    => 0,
            'margin-right'  => 0,
            'margin-bottom' => 0,
            'margin-left'   => 0,


        ));

// Add a page. To override above page defaults, you could add
// another $options array as second argument.
        $pdf->addPage('http://localhost:1234/dc/print132DC?dc_number=DC/1516/02084/1&print=2');

        $pdf->saveAs('../../../public/storage/test.pdf');
    }


}
