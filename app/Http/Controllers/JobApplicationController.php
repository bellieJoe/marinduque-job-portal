<?php

namespace App\Http\Controllers;

use App\Events\JobApplicationSubmitted;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Seeker;
use App\Models\User;
use App\Notifications\JobApplicationResponseNotification;
use App\Notifications\NewApplicationNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use stdClass;

class JobApplicationController extends Controller
{
    // setters
    public function addJobApplication(Request $request){
        $request->validate([
            'other_information' => "nullable|max:5000"
        ]);

        $jobDaysExpire = Job::where('job_id', $request->input('job_id'))->first()->days_expire;
        
        $jobApplication = JobApplication::create([
            'job_id' => $request->input('job_id'),
            'applicant_id' => $request->input('applicant_id'),
            'others' => $request->input('other_information'),
            'application_status' => 'pending',
            'expiry_date' => $jobDaysExpire != 0 ? Carbon::now()->addDays($jobDaysExpire) : null
        ]);


        JobApplicationSubmitted::dispatch($jobApplication);

        return redirect('/job-search-mdq/view/'.$request->input('job_id'));
        
    }

    public function hireJobApplication($job_application_id){

        $jobApplication = JobApplication::find($job_application_id)
        ->update([
            'date_hired' => Carbon::now()->format("Y-m-d"),
            'application_status' => 'hired'
        ]);

        return redirect()->back();

    }

    // getters
    public function getJobApplications(){
        $applications =  JobApplication::where('applicant_id', Auth::user()->user_id)->orderBy('created_at', "desc")->get();
        $jobApplications = [];

        foreach($applications as $i){
            $job = Job::where("job_id", $i->job_id)->first();
            if(!empty($job)){
                $toInsert = $i;
                $toInsert->job_title = $job->job_title;
                $toInsert->company_name = $job->company_name;
                $toInsert->date_applied = $i->created_at->format("F d, Y")." ".$i->created_at->format("h:m a");
    
                array_push($jobApplications, $toInsert);
            }
            
            
        }

        return $jobApplications;
    }

    public function getCompleteJobApplicationByJobId($job_id){

        $jobApplications = JobApplication::where('job_id', $job_id)->get();
        
        if(sizeof($jobApplications) != 0){
            $jobApplicationsComplete = [];
            foreach($jobApplications as $i){
                $applicationDetails = [];
                $applicationDetails['applicantInformation'] = Seeker::where('user_id', $i->applicant_id)->first();
                $applicationDetails['applicationInformation'] = $i;
                array_push($jobApplicationsComplete, $applicationDetails);
            }
            return $jobApplicationsComplete;
        }else{
            return null;
        } 

    }

    public function confirmApplication($application_id){

        $application = JobApplication::where('job_application_id', $application_id)->first();

        $application->update([
            'application_status' => 'approved'
        ]);
        
        // send notification to applicant
        $applicant = User::find($application->applicant_id);

        $seeker = Seeker::where('user_id', $applicant->user_id)->first();
        $job = Job::where('job_id', $application->job_id)->first();

        // $applicant->notify(new JobApplicationResponseNotification($application));
        $applicant->notify(new JobApplicationResponseNotification($application, $seeker, $job));

        // return $seeker.$job;
        return redirect("/employer/job/".$application->job_id);
    }

    public function declineApplication($application_id){
        $application = JobApplication::where('job_application_id', $application_id)->first();

        $application->update([
            'application_status' => 'declined'
        ]);
        
        // send notification to applicant
        $applicant = User::find($application->applicant_id);

        $seeker = Seeker::where('user_id', $applicant->user_id)->first();
        $job = Job::where('job_id', $application->job_id)->first();

        // $applicant->notify(new JobApplicationResponseNotification($application));
        $applicant->notify(new JobApplicationResponseNotification($application, $seeker, $job));

        return back();
    }

    public function declineAllByJobID(Request $req){
        $jobApplications = JobApplication::where([
            'job_id' => $req->job_id,
            'application_status' => 'pending'
        ]);

        $jobApplications->update([
            'application_status' => 'declined'
        ]);

        $jobApplications->each(function ($item, $key) {
            $applicant = User::find($item->applicant_id);
            $seeker = Seeker::where('user_id', $item->applicant_id)->first();
            $job = Job::where('job_id', $item->job_id)->first();
            $applicant->notify(new JobApplicationResponseNotification($item, $seeker, $job));
        });

        return redirect()->back();

    }

}
