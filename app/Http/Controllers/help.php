<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class help extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function askForm()
    {
        return view ('help.askForm');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function question()
    {
        $emp_ID = Session::get('vt_user');
        $question = Input::get('question');
        $help = new \App\help();
        $help->question = $question;
        $help->vtiger_id = $emp_ID;
        $help->save();
        $notifier = new notifications();
        return $notifier->helpNotification($emp_ID, $question);
    }
}
