<?php

use App\Http\Controllers\EmployerController;
use App\Http\Controllers\EmsiAPIController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobMatchingController;
use App\Http\Controllers\PlacementReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LmiReportController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\verify_email;
use App\Models\Credential;
use App\Models\Education;
use App\Models\EmployerVerificationProof;
use App\Models\Experience;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\LmiReport;
use App\Models\Seeker;
use App\Models\Skill;
use App\Notifications\LMIGeneratedNotification;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use NlpTools\Tokenizers\WhitespaceAndPunctuationTokenizer;
use NlpTools\Utils\StopWords;
use phpDocumentor\Reflection\Types\Boolean;

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


Route::get('/testing', function () {
    echo json_encode(LmiReportController::getLMIPerYear(2022));
});



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

/* 
@desc landing page of the website
@url /
@method GET
*/
Route::get('/', function () {
    $jobsFromMarinduque = Job::where([
        ['status', 'open'],
        ['company_address->province->name', 'MARINDUQUE']
    ])->take(12)->get();

    return view('pages.home')->with([
        'jobsFromMarinduque' => $jobsFromMarinduque
    ]);
})->name('landing');

/* 
@desc error page
@method GET
@url /error
*/
Route::view('error', 'errors.error');

/* 
@desc view veridy email page
@method GET
@url /email
*/
Route::view('email', 'emails.verify_email')->middleware('role:employer', 'auth');

/* 
@desc I dont know why this is in here but it just returns the authenticated user
@method GET
@url /get-auth
*/
Route::get('/get-auth', function () {
    return Auth::user();
})->middleware('auth');

/* 
@desc redirects to sign up page
@method GET
@url /signup
*/
Route::view('/signup', 'pages.signup')->middleware('guest'); 


/* 
@desc attemps to sign in the given credential
@method POST
@url /signin/try
*/
Route::post('/signin/try', [UserController::class, 'login'])->middleware('guest'); 

/* 
@desc logout the authenticated user
@method GET
@url /logout
*/
Route::get('/logout', [UserController::class, 'logout']); 

/* 
@desc verify the email
@method POST
@url /user/verif_email
*/
Route::post('/user/verify_email', [UserController::class, 'verify_email']); 

/* 
@desc redirects to email verification
@methofd GET
@url /email_verification/{email}
*/
Route::get('email_verification/{email}', function ($email) {
    if (User::where('email', $email)->first()) {
        return view('pages.email_verification')->with([
            'email' => $email
        ]);
    } else {
        return redirect('/');
    }
}); 

Route::get('/user/resend_code/{email}', function ($email) {  
    $new_code = rand(100000, 999999);
    User::where('email', $email)->update(['verification_code' => $new_code]);
    Mail::to($email)->send(new verify_email($new_code));
    return redirect('email_verification/' . $email);
})->middleware('guest');


/* 
@desc redirects sign in page
@methofd GET
@url /signin
*/
Route::get('/signin', function () { 
    return view('pages.signin');
})->name('signin')->middleware('guest');

Route::get('/emp_sup', function () {
    return view('pages.employer_signup');
})->middleware('guest');

Route::post('/emp_sup/register', [EmployerController::class, 'register'])->middleware('guest');


//password reset link
Route::get('/forgot-password', function () {

    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password-send', [UserController::class, 'resetPassword'])->name('password.email');

Route::get('/reset-password/{token}', function ($token, Request $request) {

    return view('auth.reset-password', ['token' => $token, 'email' => $request->input('email')]);
})->name('password.reset');

Route::post('/update-password', [UserController::class, 'updatePassword'])->middleware('guest')->name('password.update');

Route::get('/resume/{user_id}', function ($user_id) {
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
})->middleware('auth');


/* 
@desc to print something
@method post
@url /print
*/
Route::post('/print', function (Request $request) {

    if ($request->has('printable')) {

        return $request->input('printable');
        // return view('pages.print')->with([
        //     'printable' => '<div>'.$request->input('printable').'</div>' 
        // ]);

    } else {

        return back();
    }
});



/* 
@desc view proofs
@url /proof
@method GET
*/
Route::get('proof/{proofID}', function($proofID){
    $proof = EmployerVerificationProof::find($proofID);

    return view("pages.proof-view")->with([
        'proof' => $proof
    ]);

})->middleware('auth');





