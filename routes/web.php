<?php

use App\Http\Controllers\CredentialController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\SavedJobController;
use App\Http\Controllers\SeekerController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\verify_email;
use App\Models\Credential;
use App\Models\Education;
use App\Models\Employer;
use App\Models\Experience;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\SavedJob;
use App\Models\Seeker;
use App\Models\Skill;
use App\Notifications\SampleNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\Console\Output\ConsoleOutput;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/






//seeker
require('seekerRoutes.php');

//employer
require('employerRoutes.php');

// admin
require('adminRoutes.php');

// guest
require('guestRoutes.php');

// database routes
require('databaseRoutes.php');






// guest
Route::prefix('job-search')->group(function(){
    Route::get('', function () {
        return view('pages.guest.job-search')->with([
            'jobs'=> NULL,
            'job_inputs' => [
                'job_title' =>  NULL,
                'company_name' => NULL,
                'province' => NULL,
                'municipality' => NULL,
                'salary_max' => NULL,
                'salary_min' => NULL
            ],
        ]);
    });

    Route::get('search', [JobController::class, 'searchJobs']);

    Route::post('keyword-job-title', [JobController::class, 'getJobTitles']);

    Route::post('keyword-company-name', [JobController::class, 'getCompanyNames']);

});

Route::get('/', function(){ 

    $jobsFromMarinduque = Job::where([
        ['status', 'open'],
        ['company_address->province->name', 'MARINDUQUE']
    ])->take(12)->get();
    return view('pages.home')->with([
        'jobsFromMarinduque' => $jobsFromMarinduque
    ]); 
})->name('landing'); 

Route::view('error', 'errors.error');

Route::view('email', 'emails.verify_email')->middleware('role:employer', 'auth');


Route::get('/get-auth', function(){
    return Auth::user();
})->middleware('auth');

Route::view('/signup', 'pages.signup')->middleware('guest'); //ok

Route::post('/signin/try', [UserController::class, 'login'])->middleware('guest'); //ok

Route::get('/logout', [UserController::class, 'logout'] ); //ok

Route::post('/user/verify_email', [UserController::class, 'verify_email']); //ok

Route::get('email_verification/{email}', function($email){
    if(User::where('email', $email)->first()){
        return view('pages.email_verification')->with([
            'email' => $email
        ]);
    }else{
        return redirect('/');
    }
    
}); //ok

Route::get('/user/resend_code/{email}', function($email){  //ok
    $new_code = rand(100000, 999999);
    User::where('email', $email)->update(['verification_code'=> $new_code]);
    Mail::to($email)->send(new verify_email($new_code));
    return redirect('email_verification/'.$email);
})->middleware('guest');

Route::get('/signin', function(){ //ok
    return view('pages.signin');
})->name('signin')->middleware('guest');

Route::get('/emp_sup', function (){ return view('pages.employer_signup'); })->middleware('guest');

Route::post('/emp_sup/register', [EmployerController::class, 'register'])->middleware('guest');


//password reset link
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password-send', [UserController::class, 'resetPassword'])->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token, Request $request) {

    return view('auth.reset-password', ['token' => $token, 'email' => $request->input('email')]);
})->middleware('guest')->name('password.reset');

Route::post('/update-password', [UserController::class, 'updatePassword'])->middleware('guest')->name('password.update');

Route::get('/resume/{user_id}', function($user_id){
    $resumeData = [
        'userData' => Seeker::where('user_id', $user_id)->first(),
        'educationData' => Education::where('user_id', $user_id)->get(),
        'experienceData' => Experience::where('user_id', $user_id)->get(),
        'credentialData' => Credential::where('user_id', $user_id)->get(),
        'skillData' => Skill::where('user_id', $user_id)->get()
    ];
    $resumeData['userData']->email = User::where('user_id', $user_id)->get('email')->first()->email;
    return view('pages.resume')->with([
        'resumeData' => $resumeData
    ]);
})->middleware( 'auth');





// for testing purposes only

Route::get('/testing-2', function(){
    $sample = "okie";
    $user = User::where('email', 'jandusayjoe14@gmail.com')->first();
    Notification::send($user, new SampleNotification());
});
Route::get('/testing', function(){

    $user = User::find(1);
    $message = [
        'message' => 'SI Bellie Joe Jandusay ay pogi'
    ];

    $user->notify(new SampleNotification($message));
    return "Notified";
});


