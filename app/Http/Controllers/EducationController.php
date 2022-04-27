<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Seeker;
use App\Rules\EducationYear;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    //
    public function addEducation(Request $request){

        $request->validate([
            'education_level' => 'required',
            'school_name' => 'required',
            'school_address' => 'required',
            'course' => 'required_if:education_level,tertiary education,master\'s degree,doctorate degree',
            'year_graduated' => ['required', 'min:4', 'max:4'],
        ]);

        $education_levels = Education::where([
            'user_id' => Auth::user()->user_id,
        ])
        ->whereIn('education_level', ['primary education', 'secondary education'])
        ->pluck('education_level')->toArray();

        if(!in_array($request->education_level, $education_levels)){
            Education::create([
                'user_id' => Auth::user()->user_id,
                'education_level' => $request->input('education_level'),
                'school_name' => $request->input('school_name'),
                'school_address' => $request->input('school_address'),
                'course' => $request->input('course'),
                'year_graduated' => $request->input('year_graduated'),
            ]);
        } else{
            return json_encode([
                'educationLevelError' => "Already have ".$request->education_level." Level"
            ]);
        }
        
    }

    public function updateEducation(Request $request, $id){
        $request->validate([
            'education_level' => 'required',
            'school_name' => 'required',
            'school_address' => 'required',
            'course' => 'required_if:education_level,tertiary education,master\'s degree,doctorate degree',
            'year_graduated' => ['required', 'min:4', 'max:4'],
        ]);

        Education::where('education_id', $id)->update([
            'education_level' => $request->input('education_level'),
            'school_name' => $request->input('school_name'),
            'school_address' => $request->input('school_address'),
            'course' => $request->input('course'),
            'year_graduated' => $request->input('year_graduated'),
        ]);
    }

    public function deleteEducation($id){
        Education::where('education_id', $id)->delete();
    }

    public function getEducation($id){
        return Education::where('education_id', $id)->first();
    }

}
