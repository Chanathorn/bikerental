<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Charts;
use DB;
use App\Bikereturn;


class ChartAllReturnController extends Controller
{
    public function index()
    {   
        $data =  date('Y');
        $users = Bikereturn::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"), $data)->get();
        //dd($users);
          $chart = Charts::database($users, 'bar', 'highcharts')
            ->title("จำนวนการคืนต่อเดือน")
            ->elementLabel("ผู้ใช้ทั้งหมด")
            ->dimensions(1000, 500)
            ->responsive(true)
            ->groupByMonth($data,true)
            ->labels(['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม']);     
        return view('chart.chartallreturn', compact('chart'));
    }
}
