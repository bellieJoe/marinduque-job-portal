<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function create (Request $request) {
        Course::create([
            "course" => $request->input("course"),
            "course_type" => $request->input("course_type")
        ]);

        return back()
        ->with([
            "message" => "Course successfully added."
        ]);
    }

    public function delete (Request $request) {
        Course::find($request->input("course_id"))->delete();

        return back()->with([
            "message" => "Course deleted."
        ]);
    }

    public static function getAll(){
        return Course::all();
    }

}
