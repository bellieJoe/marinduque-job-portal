<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedJobController extends Controller
{
    //setters
    public function addSavedJob($job_id){

        SavedJob::create([
            'user_id' => Auth::user()->user_id,
            'job_id' => $job_id
        ]);
    }



    //getters
    public function getSavedJobs(){

        $jobs = [];
        $saved =  SavedJob::where("user_id", Auth::user()->user_id)->orderBy('created_at', 'desc')->get();
        foreach($saved as $i){
            $job = Job::where("job_id", $i->job_id)->first();
            $job->saved_job_id = $i->saved_job_id;
            array_push($jobs, $job);
            
        }
        return $jobs;
    }


    public function deleteSavedJob($saved_job_id){
        return SavedJob::where([
            ['user_id',  Auth::user()->user_id ],
            ['saved_job_id', $saved_job_id]
        ])->delete();
    }

}
