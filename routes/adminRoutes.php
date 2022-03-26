<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobSpecializationController;
use App\Http\Controllers\PlacementReportController;
use App\Http\Controllers\SeekerController;
use App\Http\Controllers\UserController;
use App\Models\Course;
use App\Models\JobSpecialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function(){

    /* 
    @method GET
    @desc landing page of the admin
    @url /admin
    */
    Route::get('', function(){
        return redirect("/admin/employers");
    })->middleware('role:admin', 'auth');


    Route::prefix('employers')->group(function(){
        /* 
        @method GET
        @desc employers list
        @url /admin/employers
        */
        Route::get('', [EmployerController::class, 'getEmployers'])->middleware('role:admin', 'auth');

        /* 
        @method GET
        @desc activate or deactivate an account
        @url /admin/employers/{ status }/{ employer_id }
        */
        Route::get('{status}/{user_id}', [UserController::class, 'setStatus'])->middleware('role:admin', 'auth');

        /* 
        @method GET
        @desc redirects to page that contains unverified employers
        @url /admin/employer/unverified
        */
        Route::get('unverified', [AdminController::class , 'unverifiedEmployers'])->middleware("role:admin", "auth");

        

    });
    // end of "employers" prefix

    
    /* 
    @method GET
    @desc redirects to the list of proofs sent by the employer
    @url /admin/employer/{employer_id}
    */
    Route::get('proof/{employer_id}', [AdminController::class , 'viewProofs'])->middleware('role:admin', 'auth');

    /* 
    @method GET
    @desc verifies the employer
    @url /admin/employer/{employer_id}/verify
    */
    Route::post('proof/{employer_id}/verify', [AdminController::class , 'verifyEmployer'])->middleware('role:admin', 'auth');

    Route::prefix('job-seekers')->group(function(){

         /* 
        @method GET
        @desc job seekers list
        @url /admin/job-seekers/
        */
        Route::get('', [SeekerController::class, 'getSeekers'])->middleware('role:admin', 'auth');

        /* 
        @method GET
        @desc activate or deactivate an account
        @url /admin/job-seekers/{ status }/{ employer_id }
        */
        Route::get('{status}/{user_id}', [UserController::class, 'setStatus'])->middleware('role:admin', 'auth');
        
    });
    // end of "job-seekers" prefix

    Route::prefix('jobs')->group(function(){

        // @method GET
        // @desc redirects to job list
        // @url /admin/jobs
        Route::get('', [JobController::class, 'getJobs'])->middleware('role:admin', 'auth');

        /* 
        @method GET
        @desc terminates a job
        @url /admin/job-seekers/{ status }/{ employer_id }
        */
        Route::get('{status}/{job_id}', [JobController::class, 'setStatus'])->middleware('role:admin', 'auth');

        /* 
        @method get
        @desc redirect to list oof job specializations
        @route admin/jobs/job_specialization
        */
        Route::get('job_specializations', function(){
            return view('pages.admin.job_specializations')
            ->with([
                'job_specializations' => JobSpecialization::all()
            ]);
        })->middleware('auth', "role:admin");

        
        /* 
        @method post
        @desc redirect to create new spec
        @route admin/jobs/job_specialization
        */
        Route::post('job_specializations', [JobSpecializationController::class, 'create'])->middleware('auth', "role:admin");

        /* 
        @method post
        @desc delete spec
        @route admin/jobs/job_specialization
        */
        Route::delete('job_specializations', [JobSpecializationController::class, 'deleteSpecialization'])->middleware('auth', "role:admin");

        /* 
        @method get
        @dedsc redirects to the admin course list
        @route admin/jobs/courses
        */
        Route::get("courses", function () {
             
            return view("pages.admin.courses")
            ->with([
                "courses" => Course::all()
            ]);

        })->middleware('auth', "role:admin");

        /* 
        @method post
        @dedsc add new course record
        @route admin/jobs/courses
        */
        Route::post("courses", [CourseController::class, "create"])->middleware("auth", "role:admin");

        /* 
        @method delete
        @dedsc deletes course
        @route admin/jobs/courses
        */
        Route::delete("courses", [CourseController::class, "delete"])->middleware("auth", "role:admin");

        
    });
    // end of jobs prefix


    /* 
    @method GET
    @desc redirects to addning of new admin account
    @url /admin/add-account 
    */
    Route::get('add-account', function(){
        return view('pages.admin.add-admin-account');
    })->middleware('role:admin', 'auth');

    /* 
    @method POST
    @desc redirects to registe new admin
    @url /admin/add-account
    */
    Route::post('add-account', [AdminController::class, 'registerAdmin'])->middleware('role:admin', 'auth');
    
    /* 
    @method GET
    @desc redirects to list of verificatin proofs of employer
    @url /admin/add-account
    */
    Route::get('verification-proof/{employer_id}', function($employer_id){

        return $employer_id;
        
    })->middleware('auth', 'role:admin');


    /* 
    admin reports
    */
    Route::prefix("reports")->group(function(){

        /* 
        @method GET
        @desc add lmi report
        @url /admin/reports/lmi-report
        */
        Route::view("lmi-report", 'pages.admin.lmi')->middleware("auth", "role:admin");

        /* 
        @method GET
        @desc add sprs report
        @url /admin/reports/sprs-report
        */
        Route::view("sprs-report", 'pages.admin.add-sprs')->middleware("auth", "role:admin");


        /* 
        @method GET
        @desc get placement reports
        @url /admin/reports/placement reports
        */
        Route::get('placement-report/{month}/{year}', [PlacementReportController::class, 'getAdminPlacementReport'])->middleware('auth','role:admin');

       
    });
    // end of reports prefix

    


});
// end of "admin" prefix

?>