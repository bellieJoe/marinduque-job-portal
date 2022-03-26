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
}
