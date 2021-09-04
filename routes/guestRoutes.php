<?php

use App\Http\Controllers\JobController;
use App\Models\Job;
use Illuminate\Support\Facades\Route;

Route::prefix('/job-search-mdq')->group(function(){
    Route::get('', function(){
        $jobs = Job::where([
            ['status', 'open'],
            ['company_address->province->name', 'MARINDUQUE']
        ])->paginate(20);
    
        return view('pages.guest.job-search-marinduque')->with([
            'jobs' => $jobs
        ]);
    });

    Route::get('/view/{job_id}', [JobController::class, 'getJobFromMarinduque']);
});
// end of job-search-mdq prefix


?>