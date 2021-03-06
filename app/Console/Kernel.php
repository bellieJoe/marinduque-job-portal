<?php

namespace App\Console;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\LmiReport;
use App\Models\Seeker;
use App\Models\User;
use App\Models\SPRS;
use App\Notifications\LMIGeneratedNotification;
use App\Notifications\SampleNotification;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

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
            $jobs = Job::withTrashed()->whereMonth('date_posted', $month)->whereYear('date_posted', $year);
            $applications = JobApplication::withTrashed()->whereMonth('created_at', $month)
            ->whereYear('created_at', $year);
            $applicationIds = $applications->pluck('applicant_id');
            $referredSeekers = Seeker::whereIn('user_id', $applicationIds);
            $hiredSeekers = Seeker::whereIn('user_id', JobApplication::withTrashed()->whereMonth('created_at', $month)->where(['application_status' => 'hired'])->pluck('applicant_id'));
            $applicants_placed_private = (function($month, $year){
                $count =  0;

                $applications = JobApplication::withTrashed()->whereMonth('updated_at', $month)
                ->whereYear('updated_at', $year)->get();

                foreach($applications as $application){
                    if( $application->application_status == 'hired' && Job::where(['job_id' => $application->job_id])->withTrashed()->first()->isGovernment == 0 ){
                        $count++;
                    }
                }

                return $count;
            })($month, $year);

            $applicants_placed_government = (function($month, $year){
                $count =  0;
                $applications = JobApplication::withTrashed()->whereMonth('updated_at', $month)
                ->whereYear('updated_at', $year)->get();
                
                foreach($applications as $application){
                    if( $application->application_status == 'hired' && Job::where(['job_id' => $application->job_id])->withTrashed()->first()->isGovernment == 1 ){
                        $count++;
                    }
                }

                return $count;
            })($month, $year);

            LmiReport::create([
                'jobs_solicited_total' => $jobs->count(),
                "jobs_solicited_local" => Job::withTrashed()->whereMonth('date_posted', $month)->whereYear('date_posted', $year)->where('isLocal', 1)->count(),
                "jobs_solicited_overseas" => Job::withTrashed()->whereMonth('date_posted', $month)->whereYear('date_posted', $year)->where('isLocal', 0)->count(),
                "applicants_referred_total" => JobApplication::whereMonth('created_at', $month)->count(),
                "applicants_referred_male" => $referredSeekers->where(['gender' => 'male'])->count(),
                "applicants_referred_female" => $referredSeekers->where(['gender' => 'female'])->count(),
                "applicants_placed_total" => JobApplication::whereMonth('updated_at', $month)->where(['application_status' => 'hired'])->count(),
                "applicants_placed_male" => Seeker::whereIn('user_id', JobApplication::whereMonth('updated_at', $month)->where(['application_status' => 'hired'])->pluck('applicant_id'))->where(['gender' => 'male'])->count(),
                "applicants_placed_female" => Seeker::whereIn('user_id', JobApplication::whereMonth('updated_at', $month)->where(['application_status' => 'hired'])->pluck('applicant_id'))->where(['gender' => 'female'])->count(),
                "year" => $year,
                "month" => $month
            ]);

            SPRS::create([
                'vacancies_solicited' => $jobs->count(),
                'applicants_registered' => User::where([
                    'role' => 'seeker'
                ])->whereMonth('created_at', $month)->whereYear('created_at', $year)->count(),
                'applicants_placed_private' => $applicants_placed_private,
                'applicants_placed_government' => $applicants_placed_government
            ]);

            // send notification to admins
            $admins = User::where([
                'role' => 'admin',
                // 'admin_role' => 'master'
            ])->get();
        
            foreach ($admins as $admin) {
                $admin->notify(new LMIGeneratedNotification());
            }
            
        })
        ->monthly();
        // ->everyMinute();
        
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
