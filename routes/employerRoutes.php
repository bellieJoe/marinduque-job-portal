<?php

use App\Http\Controllers\EmployerController;
use App\Http\Controllers\EmployerVerificationProofController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobMatchingController;
use App\Http\Controllers\PlacementReportController;
use App\Http\Controllers\SeekerController;
use App\Models\Employer;
use App\Models\Credential;
use App\Models\EmployerVerificationProof;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Seeker;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Google\Cloud\Talent\V4beta1\JobApplication as V4beta1JobApplication;
use Illuminate\Foundation\Console\JobMakeCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;


Route::prefix('employer')->group(function(){

    Route::get('', function(){
        return redirect('/employer/home');
    });
    
    /* 
    @method GET
    @desc Redirects to Employer Home View
    */
    Route::view('home', 'pages.employer_home')->middleware('role:employer', 'auth', 'employer-verified');

    Route::prefix('profile')->group(function(){
        
        Route::post('update-description', [EmployerController::class, 'updateDescription'])->middleware('role:employer', 'auth', 'employer-verified');

        Route::get('', function(){
            $employer = Employer::where('user_id', Auth::user()->user_id)->first();
            $address = $employer->address;
            return view('pages.employer_profile')->with([ 'employer' => $employer, 'address' => $address]);
        })->middleware('role:employer', 'auth', 'employer-verified'); 

        Route::get('upload-logo', function () {
            return view('pages.employer.upload-logo');
        });

        Route::post('upload-logo/upload', [EmployerController::class, 'uploadLogo']);

        Route::post('update', [EmployerController::class, 'updateProfile'])->middleware('role:employer', 'auth', 'employer-verified');

        Route::post('set-mission', [EmployerController::class, 'setMission'])->middleware('role:employer', 'auth', 'employer-verified');

        Route::post('set-vision', [EmployerController::class, 'setVision'])->middleware('role:employer', 'auth', 'employer-verified');
    });

    // posting job
    Route::prefix('post-job')->group(function(){
        Route::get('', function(){ return view('pages.employer.post-job'); })->middleware('role:employer', 'auth', 'employer-verified');

        Route::post('get-company-information', [EmployerController::class, 'getEmployer'])->middleware('role:employer', 'auth', 'employer-verified');

        Route::post('add-job', [JobController::class, 'addJob'])->middleware('role:employer', 'auth', 'employer-verified');
    });

    Route::prefix('job')->group(function(){
        /* 
        @method POST
        @desc Update the match preference
        @url /job/{job_id}/match_preference/update
        */
        Route::post('{job_id}/match_preferences/update', function ($job_id, Request $request) {

            $sum = $request->input('match_preferences')['educational_attainment'] +  $request->input('match_preferences')['skills'] +  $request->input('match_preferences')['yoe'];
            
            

            if($sum != 100){  
                return back()->withErrors([
                    "not_100" => "The Total of the criteria is not equal to 100."
                ]);
                // return $sum;
            }  
            
            Job::find($job_id)->update([
                'match_preferences' => json_encode($request->input('match_preferences'))
            ]);
            return back();
            
        })->middleware('role:employer', 'auth', 'employer-verified');

        /* 
        @method POST
        @desc Fetch the list of Jobs of an Employer
        */
        Route::post('get-job/{EmployerId}', [JobController::class, 'getJobByEmployerId'])->middleware('role:employer', 'auth', 'employer-verified');

        /* 
        @method GET
        @desc Redirects the Employer's Job View and fetch Job Data 
        @route /employer/job
        */
        Route::get('', function(Request $request){

            $jobs = null;

            if ($request->has('keyword')) {

                $searchResult = Job::search($request->input('keyword'))->get();
                
                
                $selected =  collect([...$searchResult])
                ->map(function ($item, $key) {
                    return $item->job_id;
                });

                $jobs = Job::where([
                    ['user_id', Auth::user()->user_id]
                ])
                ->whereIn('job_id', $selected);


            } else {
                $jobs = Job::where('user_id', Auth::user()->user_id);
            }
            

            $jobsList = $jobs->get();
            $jobCounts = [];
            $applicantCounts = [];

            

            // generate applicantCounts
            foreach ($jobs->get() as $job) {

                $applicantCounts[strval($job->job_id)] = [
                        'total' => JobApplication::where('job_id', $job->job_id)->count(),
                        'pending' => JobApplication::where([
                            ['job_id', $job->job_id],
                            ['application_status', 'pending'],
                        ])->count(),
                        'approved' => JobApplication::where([
                            ['job_id', $job->job_id],
                            ['application_status', 'approved'],
                        ])->count(),
                        'declined' => JobApplication::where([
                            ['job_id', $job->job_id],
                            ['application_status', 'declined'],
                        ])->count(),
                        'expired' => JobApplication::where([
                            ['job_id', $job->job_id],
                            ['application_status', 'expired'],
                        ])->count(),
                    ];
            }
            
            if(sizeof($jobsList) != 0){
                foreach($jobsList as $job){
                    array_push($jobCounts, JobApplication::where([
                        ['job_id', $job->job_id],
                        ['application_status', 'pending']
                    ])->count());
                }
                return view('pages.employer.job-list')->with([
                    'jobs' => $jobs->paginate(10),
                    'jobCounts' => $jobCounts,
                    'applicantCounts' => $applicantCounts
                ]);
            }else{
                return view('pages.employer.job-list')->with([
                    'jobs' => null,
                    'jobCounts' => null,
                    'applicantCounts' => $applicantCounts
                ]);
            }
            
        })->middleware('role:employer', 'auth', 'employer-verified');

        /* 
        @method POST
        @desc Updates Jobs Status if open or not
        */
        Route::post('update-job-status', [JobController::class, 'updateStatus'])->middleware('role:employer', 'auth', 'employer-verified');

        /*  
        @desc redirects to editing of job details
        @method GET
        @route /employer/job/edit-job/{job_id}
        */
        Route::get('edit-job/{id}', function ($id) {
            $job = Job::where([
                'user_id'=> Auth::user()->user_id,
                'job_id' => $id
                ])->first();
            return view('pages.employer.edit-job')->with([
                'job' => $job
            ]);
        })->middleware('role:employer', 'auth', 'employer-verified');

        Route::post('update-job/{id}', [JobController::class, 'updateJob'])->middleware('role:employer', 'auth', 'employer-verified');

        /*  
        @desc updates the status of a job if close or open
        @method POST
        @route /employer/job/update-status/{id}
        */
        Route::post('update-status/{id}', [JobController::class, 'updateStatus'])->middleware('role:employer', 'auth', 'employer-verified');

        /* 
        @method GET
        @desc Redirects to Job Manager and fetch the necessary data such as 
        job details, applicants
        */
        Route::get('{job_id}', function($job_id){

            $jobApplications = JobApplication::where('job_id', $job_id)->get();
            $completeJobApplications = [];
            $job = Job::find($job_id);

            if(sizeof($jobApplications) != 0){
                foreach($jobApplications as $i){
                    $seeker = Seeker::where('user_id', $i->applicant_id)->first();
                    $educRate  = $job->educational_attainment ?  number_format(JobMatchingController::rateEducation($job, $seeker) * (json_decode($job->match_preferences)->educational_attainment / 100), 2, "." , ",") : json_decode($job->match_preferences)->educational_attainment;
                    $skillRate = $job->generated_skills ? number_format(JobMatchingController::rateSkills($job, $seeker) * (json_decode($job->match_preferences)->skills / 100), 2, "." , ",") : json_decode($job->match_preferences)->skills;
                    $yoeRate = $job->experience ? number_format(JobMatchingController::rateYOE($job, $seeker) * (json_decode($job->match_preferences)->yoe / 100), 2, "." , ",") : json_decode($job->match_preferences)->yoe;
                    $i->match_rate = [
                        'educRate' => $educRate,
                        'skillRate' => $skillRate,
                        'yoeRate' => $yoeRate,
                        'total' => number_format( ($educRate + $skillRate + $yoeRate), 2, '.', ',' )
                    ];


                    $application = [];
                    $application['applicantInformation'] = Seeker::where('user_id', $i->applicant_id)->first();
                    // $application['eligibility'] = Credential::where([
                    //     "user_id" => $i->applicant_id,
                    //     "credential_type" => "eligibility"
                    // ])->get();
                    $application['applicationInformation'] = $i;
                    array_push($completeJobApplications, $application);
                }
            }else{
                $completeJobApplications = null;
            } 

            $job = [
                'jobDetails' => Job::where('job_id', $job_id)->first(),
                'jobApplications' => $completeJobApplications
            ];

            return view('pages.employer.job')->with([
                'job' => $job
            ]);
        })->middleware('role:employer', 'auth', 'employer-verified');

        /* 
        @method GET
        @desc redirects to the accepting of application page
        */
        Route::get('accept-application/{application_id}', function($application_id){
            $application = JobApplication::where('job_application_id', $application_id)->first();
            $job = Job::where('job_id', $application->job_id)->first();
            $employer = Auth::user();
            $applicant = Seeker::where('user_id', $application->applicant_id)->first();
            $applicant->email = User::where('user_id', $applicant->user_id)->first()->email;

            // checks the authorizaation of job application
            if($job->user_id === $employer->user_id && $application->application_status === 'pending'){
                return view('pages.employer.accept-application')->with([
                    'application' => [
                        'application' => $application,
                        'applicant' => $applicant
                    ],
                ]);
            }else{
                return view('errors.unauthorized');
            }
        })->middleware('role:employer', 'auth', 'employer-verified');

        /* 
        @method POST
        @desc updates the job hiraing status of a job
        @url /employer/job/{job_id}/status
        */
        Route::post('{job_id}/status', [JobController::class, 'toggleStatus'])->middleware('role:employer', 'auth', 'employer-verified');


        /* 
        @desc confirms the job application to accept 
        @method POST
        @url /employer/job/accept-application/{application_id}
        */
        Route::post('accept-application/{application_id}', [JobApplicationController::class, 'confirmApplication'])->middleware('role:employer', 'auth', 'employer-verified');
        
        /* 
        @desc decline job application
        @method POST
        @url /employer/job/decline-application/{application_id}
        */
        Route::post('decline-application/{application_id}', [JobApplicationController::class, 'declineApplication'])->middleware('role:employer', 'auth', 'employer-verified');

        /* 
        @desc set the days expire of a job
        @method PUT
        @url /employer/job/{job_id}/days-expire
        */
        Route::put('{job_id}/days-expire', [JobController::class, 'setDaysExpire']);

        /* 
        @desc delete a job
        @method delete
        @url /employer/job/{job_id}/delete
        */
        Route::delete('{job_id}/delete', [JobController::class, 'deleteJobById'])->middleware('role:employer', 'auth', 'employer-verified');

        /* 
        @desc generates suggested applicants
        @method get
        @route employer/job/{job_id}/generate_suggested_applicants
        */
        Route::get('{job_id}/generate_suggested_applicants', function($job_id){
            return JobMatchingController::genSuggestedCandidate($job_id);
        });

        /* 
        @desc send invitation email to the seeker
        @method post
        @url employer/job/sedInvitation
        */
        Route::post('sendInvitation', [JobController::class, "sendInvitation"]);

    });
    // end of job prefix

    Route::view('settings', 'pages.settings')->middleware('auth');

    Route::get('placement-report/{month}/{year}', [PlacementReportController::class, 'getEmployerPlacementReport'])->middleware('role:employer', 'auth', 'employer-verified');

    Route::post('hire/{job_application_id}', [JobApplicationController::class, 'hireJobApplication'])->middleware('role:employer', 'auth', 'employer-verified');

    Route::post('applications/decline-all', [JobApplicationController::class, 'declineAllByJobID']);

});
// end of employer prefix

/* 
@desc redirects the user to employer verification 
@method GET
@url /verify-employer
*/
Route::get('verify-employer', function(){
    $proofCount = EmployerVerificationProof::where([
        ['user_id', Auth::user()->user_id]
    ])->count();

    $proofs = $proofCount > 0 ? 
                EmployerVerificationProof::where([
                    ['user_id', Auth::user()->user_id]
                ])->get()
                : null;

    return view('pages.employer.employer-verification')->with([
        'submitted' => $proofCount > 0 ? true : false,
        'proofCount' => $proofCount,
        'proofs' => $proofs
    ]);
})->middleware('role:employer', 'auth');

/* 
@desc submits and proces the employers proof
@method GET
@url /verify-employer
*/
Route::post('verify-employer', [EmployerVerificationProofController::class, 'createEmployerVerificationProof']);

?>