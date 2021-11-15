<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    //


    public function getSkill($id){
        return Skill::where('skill_id', $id)->get()->first();
    }

    public function addSkill(Request $request){
        $request->validate([
            'skill' => 'required'
        ]);

        Skill::create([
            'user_id' => Auth::user()->user_id,
            'skill_description' => $request->input('skill'),
            'generated_skills' => json_encode(EmsiAPIController::extractSkills($request->input('skill')))
        ]);
    
    }

    public function updateSkill($id, Request $request){
        $request->validate([
            'skill' => 'required'
        ]);

        Skill::where(['skill_id'=> $id, 'user_id' => Auth::user()->user_id])
        ->update([
            'skill_description' => $request->input('skill'),
            'generated_skills' => json_encode(EmsiAPIController::extractSkills($request->input('skill')))
        ]);
    }

    public function deleteSkill($id){
        Skill::where(['user_id' => Auth::user()->user_id, 'skill_id' => $id])->delete();
    }
}
