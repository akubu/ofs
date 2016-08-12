<?php

namespace App\Http\Controllers\Reports;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class reports extends Controller
{
    public function dc()
    {
        $date = Carbon::now();
        $date = $date->subDay(100);
        if(Input::get('start'))
        {
        $startDate = Input::get('start');
        $lastDate = Input::get('end');
        $dataRaw = DB::table('dc')
            ->select(DB::raw('count(*) as count'), DB::raw('DATE(created_at) as date'))
            ->whereDate('created_at', '>', $startDate)
            ->whereDate('created_at', '<', $lastDate)
            ->groupBy('date')->get();

        }
        else
        {
            $dataRaw=DB::table('dc')
                ->select(DB::raw('count(*) as count'),DB::raw('DATE(created_at) as date'))
                ->whereDate('created_at','>',$date)
                ->groupBy('date')->get();
        }
        $data = array();
        $ii = 0;
        foreach ($dataRaw as $rawData) {
            $data['date'][$ii] = $rawData->date;
            $data['count'][$ii] = $rawData->count;
            $ii += 1;
        }
        return view('reports.dc', compact('data'));
    }

    public function so()
    {
        $date=Carbon::now();
        $date=$date->subDay(100);
        if(Input::get('start'))
        {
            $startDate = Input::get('start');
            $lastDate = Input::get('end');

            $dataRaw=DB::table('dc')
                ->select(DB::raw('count(DISTINCT so_number) as count'),DB::raw('DATE(updated_at) as date'))
                ->whereDate('created_at','>',$startDate)
                ->whereDate('created_at','<',$lastDate)
                ->groupBy('date')->get();

        }
        else
        {
            $dataRaw=DB::table('dc')
                ->select(DB::raw('count(DISTINCT so_number) as count'),DB::raw('DATE(updated_at) as date'))
                ->whereDate('created_at','>',$date)
                ->groupBy('date')->get();
        }
        
        $data = array();
        $ii =0;
        foreach ( $dataRaw as $rawData)
        {
            $data['date'][$ii] =  $rawData->date;
            $data['count'][$ii] =  $rawData->count;
            $ii +=1;
        }
        return view('reports.so',compact('data'));
    }
    public function document()
    {
        $date=Carbon::now();
        $date=$date->subDay(100);
        if(Input::get('start'))
        {
            $startDate = Input::get('start');
            $lastDate = Input::get('end');
            $dataRaw=DB::table('documents')
                ->select(DB::raw('count(*) as count'),DB::raw('DATE(updated_at) as date'))
                ->whereDate('updated_at','>',$startDate)
                ->whereDate('updated_at','<',$lastDate)
                ->groupBy('date')->get();
            
        }
        else
        {
            $dataRaw=DB::table('documents')
                ->select(DB::raw('count(*) as count'),DB::raw('DATE(updated_at) as date'))
                ->whereDate('updated_at','>',$date)
                ->groupBy('date')->get();
            
        }

        $data = array();
        $ii =0;
        
        foreach ( $dataRaw as $rawData)
        {
            $data['date'][$ii] =  $rawData->date;
            $data['count'][$ii] =  $rawData->count;
            $ii +=1;
        }

        return view('reports.document',compact('data'));
    }
    
}