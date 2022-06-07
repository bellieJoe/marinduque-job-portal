<?php

namespace App\Http\Controllers;

use App\Models\LmiReport;
use Illuminate\Http\Request;

class LmiReportController extends Controller
{
    //
    public function getLMI(Request $req){
        $lmi = LmiReport::where([
            'year' => $req->year,
            'month' => $req->month
        ])->first();

        return view('pages.admin.lmi')->with([
            'lmi' => $lmi
        ]);
    }

    public static function getLMIPerYear($year){
        $LMI = [];
        for($i = 1; $i <= 12; $i++){
            array_push($LMI, LmiReport::where([
                'month' => $i,
                'year' => $year
            ])->first());
        }

        return $LMI;
    }
}
