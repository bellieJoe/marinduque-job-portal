<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    //
    public function addEducation(Request $request){
        $request->validate([
            'education_level' => 'required',
            'school_name' => 'required',
            'school_address' => 'required',
            'course' => 'required_if:education_level,tertiary education',
            'year_graduated' => 'required|min:4|max:4',
        ]);

        Education::create([
            'user_id' => Auth::user()->user_id,
            'education_level' => $request->input('education_level'),
            'school_name' => $request->input('school_name'),
            'school_address' => $request->input('school_address'),
            'course' => $request->input('course'),
            'year_graduated' => $request->input('year_graduated'),
        ]);
    }

    public function updateEducation(Request $request, $id){
        $request->validate([
            'education_level' => 'required',
            'school_name' => 'required',
            'school_address' => 'required',
            'course' => 'required_if:education_level,tertiary education',
            'year_graduated' => 'required|min:4|max:4',
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
