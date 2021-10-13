<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    //
    public function addExperience(Request $request){
        $request->validate([
            'job_title' => 'required',
            // 'position' => 'required',
            'job_industry' => 'required',
            'company_name' => 'required',
            'job_description' => 'nullable',
            'date_started' => 'required|date',
            'date_ended' => 'required|date'
        ]);

        Experience::create([
            'user_id' => Auth::user()->user_id,
            'job_title' => $request->input('job_title'),
            'position' => 'wala daw to',
            'job_industry' => $request->input('job_industry'),
            'company_name' => $request->input('company_name'),
            'date_started' => $request->input('date_started'),
            'date_ended' => $request->input('date_ended'),
            'job_description' => $request->input('job_description'),
        ]);
    }

    public function getExperience($id){
        $experience = Experience::where('experience_id', $id)->first();
        return $experience;
    }

    public function updateExperience(Request $request, $id){
        $request->validate([
            'job_title' => 'required',
            // 'position' => 'required',
            'company_name' => 'required',
            'job_description' => 'nullable',
            'date_started' => 'required|date',
            'date_ended' => 'required|date'
        ]);

        Experience::where('experience_id', $id)
        ->update([
            'job_title' => $request->input('job_title'),
            'position' => 'wala daw to',
            'company_name' => $request->input('company_name'),
            'date_started' => $request->input('date_started'),
            'date_ended' => $request->input('date_ended'),
            'job_description' => $request->input('job_description'),
        ]);
    }

    public function deleteExperience($id){
        Experience::where('experience_id', $id)->delete();
    }
}
