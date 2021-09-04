<?php

namespace App\Listeners;

use App\Models\Job;
use App\Models\Seeker;
use App\Models\User;
use App\Notifications\NewApplicationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class SendNewApplicationNotification
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
        // send notification to the employer
        $job = Job::where('job_id', $event->jobApplication->job_id)->first();
        $employer = User::where('user_id', $job->user_id)->first();
        $applicant = Seeker::where('user_id', Auth::user()->user_id)->first();
        $employer->notify(new NewApplicationNotification($job, $applicant));

    }
}
