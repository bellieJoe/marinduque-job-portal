<?php

namespace App\Events;

use App\Models\JobApplication;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class JobApplicationSubmitted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $jobApplication;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(JobApplication $jobApplication)
    {
        //
        $this->jobApplication = $jobApplication;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('App.Models.User.1');
        return new Channel('notification');
    }
}
