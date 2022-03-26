<?php

namespace App\Http\Controllers;

use App\Models\JobSpecialization;
use Illuminate\Http\Request;

class JobSpecializationController extends Controller
{


    public function create(Request $request)
    {
        $request->validate([
            'specialization' => 'required'
        ]);

        JobSpecialization::create([
            'specialization' => $request->input('specialization')
        ]);

        return back()->with([
            'message' => 'Specialization successfully added'
        ]);
    }




    public function deleteSpecialization(Request $request)
    {
        //
        JobSpecialization::where('job_specialization_id', $request->input("id"))->delete();

        return back();
    }
}
