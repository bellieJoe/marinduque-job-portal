<?php

use App\Http\Controllers\JobController;
use App\Models\Course;
use App\Models\Employer;
use App\Models\Job;
use App\Models\JobSpecialization;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/job-search-mdq')->group(function (){
    Route::get('', function(Request $request){

        $from = $request->has('from') ? $request->input('from') : null;
        $keyword = $request->has('keyword') ? $request->input('keyword') : null;
        $jobIds = null;
        $jobs = null;


        $employers = Employer::where([
            ['address->province->name', 'MARINDUQUE']
        ])
        ->inRandomOrder()
        ->take(10)->get();

     

        if($keyword){

            $jobIds = Job::search($request->input('keyword'))
            ->get()->map(function($item, $key){
                return $item->job_id;
            });

            $jobs = Job::where([
                ['status', 'open'],
                ['company_address->province->name', 'like', 'MARINDUQUE'],
                ['company_address->municipality->name', 'like', $from ? $from : '%'],
            ])
            ->whereIn('job_id', $jobIds)
            ->paginate(20);

        }else{

            $jobs = Job::where([
                ['status', 'open'],
                ['company_address->province->name', 'MARINDUQUE'],
                ['company_address->municipality->name', 'like',  $from ? $from : '%'],
            ])
            ->inRandomOrder()
            ->paginate(20);
            
        }

        
    
        return view('pages.guest.job-search-marinduque')->with([
            'jobs' => $jobs,
            'employers' => $employers
        ]);
    });

    Route::get('/view/{job_id}', [JobController::class, 'getJobFromMarinduque']);
});
// end of job-search-mdq prefix

Route::prefix('employers')->group(function (){
    /* 
    @method GET
    @desc redirects to view the jobs from specific employer
    @url /employers/{employer_id}/jobs
    */
    Route::get('{employer_id}/jobs', function($employer_id){

        $employer = Employer::where('user_id', $employer_id)->first();
        $jobs = Job::where([
            ['user_id', $employer_id],
            ['status', 'open']
        ])
        ->inRandomOrder()
        ->paginate(10);

        return view('pages.guest.employer-jobs')
                ->with([
                    'jobs' => $jobs,
                    'employer' => $employer
                ]);
    });

    /* 
    @method GET
    @desc redirects to list of employers
    @url /employers
    */
    Route::get('', function(Request $request){

        $from = $request->has('from') ? $request->input('from') : null;

        $page = $request->has('page') ? $request->has('page') : null;

        $employersTemp = $from ? Employer::where('address->province->name', 'MARINDUQUE')->get() : Employer::inRandomOrder()->get();

        $employers = $employersTemp
                        ->map(function($employer){
                            $employer->job_count = Job::where([
                                ['user_id', $employer->user_id],
                                ['status', 'open']
                            ])->count();

                            return $employer;

                        })->sortByDesc('job_count')
                        ->chunk(20);


        return view('pages.guest.employers')
                ->with([
                    'employers' => $page  ? $employers[$page--] : $employers[0],
                    'totalPage' => sizeof($employers)
                ]);

        // return sizeof($employers);
    });
});
// end of employers prefix


Route::prefix('job-search')->group(function (){
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

    Route::get('search', [JobController::class, 'searchJobMain']);

    // Route::post('keywords', [JobController::class, 'getJobTitles']);

    // Route::post('keyword-company-name', [JobController::class, 'getCompanyNames']);

});
// end of job-search prefix


/* 
@method get 
@desc fetch all job specializations
@route /job_specializations
*/
Route::get('job_specializations', function () {
    return JobSpecialization::all();
});

/* 
@method get
@desc fetch all courses
@route /courses
*/
Route::get("courses" , function () {
    return Course::all();
});



?>