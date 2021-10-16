<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    //
    public function addExperience(Request $request){
        $request->validate([
            'job_title' => 'required',
            'job_industry' => 'required',
            'company_name' => 'required',
            'job_description' => 'nullable|max:3000',
            'date_started' => 'required|date|before_or_equal:'.Carbon::now().'|before:'.$request->input('date_ended'),
            'date_ended' => 'required|date|before_or_equal:'.Carbon::now(),
            'salary' => 'required|numeric|gte:12034',
            'salary_grade' => 'required',
            'status_of_appointment' => 'required|max:20',
            'govnt_service' => 'required'
        ]);

        Experience::create([
            'user_id' => Auth::user()->user_id,
            'job_title' => $request->input('job_title'),
            'job_industry' => $request->input('job_industry'),
            'company_name' => $request->input('company_name'),
            'date_started' => $request->input('date_started'),
            'date_ended' => $request->input('date_ended'),
            'job_description' => $request->input('job_description'),
            'salary' => floatval($request->input('salary')),
            'salary_grade' => $request->input('salary_grade'),
            'status_of_appointment' => $request->input('status_of_appointment'),
            'govnt_service' => $request->input('govnt_service') ? 1 : 0
        ]);
    }

    public function getExperience($id){
        $experience = Experience::where('experience_id', $id)->first();
        return $experience;
    }

    public function updateExperience(Request $request, $id){
        $request->validate([
            'job_title' => 'required',
            'job_industry' => 'required',
            'company_name' => 'required',
            'job_description' => 'nullable|max:3000',
            'date_started' => 'required|date|before_or_equal:'.Carbon::now().'|before:'.$request->input('date_ended'),
            'date_ended' => 'required|date|before_or_equal:'.Carbon::now(),
            'salary' => 'required|numeric|gte:12034',
            'salary_grade' => 'required',
            'status_of_appointment' => 'required|max:20',
            'govnt_service' => 'required'
        ]);

        Experience::where('experience_id', $id)
        ->update([
            'job_title' => $request->input('job_title'),
            'company_name' => $request->input('company_name'),
            'date_started' => $request->input('date_started'),
            'date_ended' => $request->input('date_ended'),
            'job_description' => $request->input('job_description'),
            'salary' => floatval($request->input('salary')),
            'salary_grade' => $request->input('salary_grade'),
            'status_of_appointment' => $request->input('status_of_appointment'),
            'govnt_service' => $request->input('govnt_service')
        ]);
    }

    public function deleteExperience($id){
        Experience::where('experience_id', $id)->delete();
    }
}
