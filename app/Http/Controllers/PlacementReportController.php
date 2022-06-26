<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Seeker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlacementReportController extends Controller
{
    
    public function getEmployerPlacementReport($month, $year){

        $placementReport = $this->getPlacementReport($month, $year, Auth::user()->user_id);

        return view('pages.employer.placement-report')->with([
            'placementReportData' => $placementReport,
            'year' => $year,
            'month' => $month
        ]);

    }

    public function getAdminPlacementReport($month, $year){

        $placementReport = $this->getPlacementReport($month, $year);

        return view('pages.employer.placement-report')->with([
            'placementReportData' => $placementReport,
            'year' => $year,
            'month' => $month
        ]);

    }

    public function getPlacementReport($month, $year, $employer_id = null){

        // returns array of placement report

        // if($month == null){
        //     $month = Carbon::now()->format('m');
        // }
        // if($year == null){
        //     $year = Carbon::now()->format('Y');
        // }

        if($employer_id){
            $job_ids = Job::withTrashed()->where([
                ['user_id', $employer_id]
            ])->pluck('job_id')->toArray();
            
            $jobPlacements = JobApplication::withTrashed()->whereIn('job_id', $job_ids)
            ->whereMonth('date_hired', $month)
            ->whereYear('date_hired', $year)
            ->where('application_status', 'hired')
            ->get()
            ->map(function ($item, $key) {
                $seeker = Seeker::where('user_id', $item->applicant_id)->first();
                $job = Job::withTrashed()->where('job_id', $item->job_id)->first();
                $item->fullname = $seeker->firstname." ".$seeker->middlename." ".$seeker->lastname;
                $item->reffered_job = $job->job_title;
                $item->company_name = $job->company_name;
                $item->contact_number = $seeker->contact_number ? $seeker->contact_number : "N/A";
                return $item;
            });
            return $jobPlacements ;

        }else{
            
            $jobPlacements = JobApplication::withTrashed()->whereMonth('date_hired', $month)
            ->whereYear('date_hired', $year)
            ->where('application_status', 'hired')
            ->get()
            ->map(function ($item, $key) {
                $seeker = Seeker::where('user_id', $item->applicant_id)->first();
                $job = Job::withTrashed()->where('job_id', $item->job_id)->first();
                
                $item->fullname = $seeker->firstname." ".$seeker->middlename." ".$seeker->lastname;
                $item->reffered_job = $job->job_title;
                $item->company_name = $job->company_name;
                $item->contact_number = $seeker->contact_number ? $seeker->contact_number : "N/A";
                return $item;
            });
            
            return $jobPlacements ;

        }

        
       

    }

}
