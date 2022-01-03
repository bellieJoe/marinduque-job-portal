<?php

use App\Events\JobApplicationSubmitted;
use App\Http\Controllers\CredentialController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobMatchingController;
use App\Http\Controllers\SavedJobController;
use App\Http\Controllers\SeekerController;
use App\Http\Controllers\SkillController;
use App\Models\Credential;
use App\Models\Education;
use App\Models\Employer;
use App\Models\Experience;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Seeker;
use App\Models\Skill;
use App\Models\User;
use App\Notifications\NewApplicationNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

Route::prefix('seeker')->group(function(){
    Route::view('job-match/results', 'pages.job_match_results')->middleware('role:seeker', 'auth');

    Route::view('job-match','pages.seeker_jobmatch')->middleware('role:seeker', 'auth');

    // register
    Route::post('register', [SeekerController::class, 'register'] )->middleware('guest'); //ok
    
    // profile
    Route::prefix('profile')->group(function(){
        Route::get('upload-image/{type}', [ImageController::class, 'viewImageUpload'])->middleware('role:seeker', 'auth');

        Route::post('upload-image/seeker-post', [ImageController::class, 'uploadPofileImageSeeker'])->middleware('role:seeker', 'auth');

        Route::get('{tab}', function($tab){
            $profile = Seeker::where('user_id', Auth::user()->user_id)->first();
            $education = Education::where('user_id', Auth::user()->user_id)->get();
            $experience = Experience::where('user_id', Auth::user()->user_id)->get();
            $skill = Skill::where('user_id', Auth::user()->user_id)->get();
            $credential = Credential::where('user_id', Auth::user()->user_id)->get();
            $education_level_count = [ 
                "primary_education" => 0,
                "secondary_education" => 0,
                "tertiary_education" => 0,
            ];
            foreach($education as $i){
                if($i->education_level == 'primary education'){
                    $education_level_count['primary_education']++;
                }
                elseif($i->education_level == 'secondary education'){
                    $education_level_count['secondary_education']++;
                }
                elseif($i->education_level == 'tertiary education' || $i->education_level == 'master\'s degree' || $i->education_level == 'doctorate degree'){
                    $education_level_count['tertiary_education']++;
                }
            }
            return view('pages.seeker_profile')->with([
                'education' => $education,
                'education_count' => $education_level_count,
                'experience' => $experience,
                'profile' => $profile,
                'skill' => $skill,
                'view' => $tab,
                'credential' => $credential
                ]);
        })->middleware('role:seeker', 'auth');

        // personal information
        Route::post('personal/update-profile', [SeekerController::class, 'updateProfile'])->middleware('role:seeker', 'auth');

        Route::get('personal/get-profile', [SeekerController::class, 'getProfile'])->middleware('role:seeker', 'auth');
        
        // education
        Route::post('add-education', [EducationController::class, 'addEducation'])->middleware('role:seeker', 'auth');

        Route::get('delete-education/{id}', [EducationController::class, 'deleteEducation'])->middleware('role:seeker', 'auth');

        Route::get('get-education/{id}', [EducationController::class, 'getEducation'])->middleware('role:seeker', 'auth');

        Route::post('update-education/{id}', [EducationController::class, 'updateEducation'])->middleware('role:seeker', 'auth');
        
        // experience
        Route::post('experience/add-experience', [ExperienceController::class, 'addExperience'])->middleware('role:seeker', 'auth');

        Route::get('experience/get-experience/{id}', [ExperienceController::class, 'getExperience'])->middleware('role:seeker', 'auth');

        Route::post('experience/update-experience/{id}', [ExperienceController::class, 'updateExperience'])->middleware('role:seeker', 'auth');

        Route::get('experience/delete-experience/{id}', [ExperienceController::class, 'deleteExperience'])->middleware('role:seeker', 'auth');
        
        // language
        Route::post('language/add-language', [SeekerController::class, 'addLanguage'])->middleware('role:seeker', 'auth');

        Route::post('language/get-language', [SeekerController::class, 'getLanguage'])->middleware('role:seeker', 'auth');

        Route::post('language/delete-language/{lang}', [SeekerController::class, 'deleteLanguage'])->middleware('role:seeker', 'auth');

        // skill
        Route::post('skill/get-skill/{id}', [SkillController::class, 'getSkill'])->middleware('role:seeker', 'auth');

        Route::post('skill/add-skill', [SkillController::class, 'addSkill'])->middleware('role:seeker', 'auth');

        Route::post('skill/update-skill/{id}', [SkillController::class, 'updateSkill'])->middleware('role:seeker', 'auth');

        Route::post('skill/delete-skill/{id}', [SkillController::class, 'deleteSkill'])->middleware('role:seeker', 'auth');

        //credentials
        Route::post('certificate/add-credential', [CredentialController::class, 'addCredential'])->middleware('role:seeker', 'auth');

        Route::post('certificate/get-credential/{id}', [CredentialController::class, 'getCredential'])->middleware('role:seeker', 'auth');

        Route::post('certificate/update-credential/{id}', [CredentialController::class, 'updateCredential'])->middleware('role:seeker', 'auth');

        Route::post('certificate/delete-credential/{id}', [CredentialController::class, 'deleteCredential'])->middleware('role:seeker', 'auth');

    });
    
    // home
    Route::get('', function(){
        return redirect('/seeker/home');
    });
    
    Route::prefix('home')->group(function(){

        Route::get('', function(){
            $seeker = Seeker::where('user_id', Auth::user()->user_id)->first();

            
            return view('pages.seeker_home')->with([
                'seeker' => $seeker
            ]);
        })->middleware('role:seeker', 'auth');

        Route::post('get-saved-jobs', [SavedJobController::class, 'getSavedJobs'])->middleware("role:seeker", "auth");

        Route::post('delete-saved-job/{saved_job_id}', [SavedJobController::class, 'deleteSavedJob'])->middleware("role:seeker", "auth");

        /* 
        @desc fetch the job suggestions preview data
        @method GET
        @url /home/get-job-suggestions-preview
        */
        Route::get('get-job-suggestions-preview', [JobController::class, 'generateJobSuggestionsPreview'])->middleware('auth', 'role:seeker');

        /* 
        @desc fetch the job suggestions full data and redirect to full view
        @method GET
        @url /home/job-suggestions-full
        */
        Route::get('job-suggestions-full', [JobController::class, 'generateJobSuggestionsFull'])->middleware('auth', 'role:seeker');

    });
    // end of home prefix

    Route::get('job/{job_id}', function($job_id){
        $job = Job::where('job_id', $job_id)->first();
        $job_application = JobApplication::where([
            'applicant_id' => Auth::user()->user_id,
            'job_id' => $job_id,
        ])
        ->orderBy('updated_at', 'desc')
        ->first();

        if($job_application){
            return view('pages.seeker.view-job')->with([
                'job' => $job,
                'job_application' => $job_application
            ]);
        }else{
            return view('pages.seeker.view-job')->with([
                'job' => $job,
                'job_application' => null
            ]);
        }
        
    })->middleware("role:seeker", "auth");

    Route::get('apply-job/{job_id}', function($job_id){
        $job = Job::where('job_id', $job_id)->first();
        $job_application = JobApplication::where([
            ['applicant_id' , Auth::user()->user_id],
            ['job_id' , $job_id],
            ['application_status' , 'pending']
        ])
        ->orWhere([
            ['applicant_id' , Auth::user()->user_id],
            ['job_id' , $job_id],
            ['application_status' , 'approved']
        ])
        ->orderBy('updated_at', 'desc')
        ->first();

        

        if(!$job_application){
            return view('pages.seeker.apply-job')->with([
                'job' => $job
            ]);
        }else{
            return redirect()->back();
        }

    })->middleware("role:seeker", "auth");

    Route::post('add-job-application', [JobApplicationController::class, "addJobApplication"])->middleware("role:seeker", "auth");

    Route::post('get-job-applications', [JobApplicationController::class, "getJobApplications"])->middleware("role:seeker", "auth");

    //job search
    Route::prefix('job-search')->group(function(){
        Route::post('save-job/{job_id}', [SavedJobController::class, 'addSavedJob'])->middleware('auth', 'role:seeker');
    });


    /* 
    @desc settings of seeker
    @method GET
    @url /seeker/settings
    */
    Route::get('settings', function(){

        return view('pages..settings');
        
    })->middleware('auth');

});

?>