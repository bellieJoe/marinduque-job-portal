<?php

namespace App\Console;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\LmiReport;
use App\Models\User;
use App\Notifications\SampleNotification;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        // expiration of job applications
        $schedule->call(function(){
            $jobApplications = JobApplication::where([
                ['application_status', 'pending'],
            ])
            ->whereNotNull('expiry_date')
            ->get();

            foreach($jobApplications as $item){
                if (Carbon::now()->greaterThan($item->expiry_date)) {
                    JobApplication::where([
                        ['job_application_id', $item->job_application_id]
                    ])
                    ->update([
                        'application_status' => 'expired'
                    ]);
                }
            }
        })->everyMinute();

        // generate monthly reports
        $schedule->call(function () {
            $month = Carbon::now()->format("m") > 1 ? Carbon::now()->format("m") - 1 : 12;
            $year = $month == 1 ? Carbon::now()->format("Y") - 1 : Carbon::now()->format("Y");
            $jobs = Job::whereMonth('date_posted', $month)
            ->whereYear('date_posted', $year);
            $applications = JobApplication::whereMonth('createed_at', $month)
            ->whereYear('created_at', $year);

            LmiReport::create([
                'jobs_solicited_total' => $jobs->count(),
       
                "jobs_solicited_local" => $jobs->where('isLocal', 1)->count(),
                "jobs_solicited_overseas" => $jobs->where('isLocal', 0)->count(),
                "applicants_referred_total" => $applications->count(),
                "applicants_referred_male" => '',
                "applicants_referred_female" => '',
                "applicants_placed_total" => '',
                "applicants_placed_male" => '',
                "applicants_placed_female" => '',
                "year" => '',
                "month" => ''
            ]);

            
        })->monthly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
