<?php

namespace App\Notifications;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Seeker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobApplicationResponseNotification extends Notification
{
    use Queueable;

    public $jobApplication;
    public $seeker;
    public $job;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(JobApplication $jobApplication, $seeker, $job)
    {
        //
        $this->jobApplication = $jobApplication;
        $this->seeker = $seeker;
        $this->job = $job;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Good Day '.$this->seeker->firstname.'!')
                    ->line('We would like to inform you that your job application from '.$this->job->job_title.' has been '.$this->jobApplication->application_status.' by the employer.')
                    ->line(
                        $this->jobApplication->application_status == 'approved' 
                        ? 'Please expect an email from your employer for the next steps to your employment.'
                        : 'Wish you luck next time.'
                    )
                    ->action('View', url('/seeker/home'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
            'title' => 'Application Status',
            'message' => 'One of your application has been updated.',
            'action' => url('/seeker/home?toggle=applications')
        ];
    }

    public function toBroadcast(){
        return [
            //
            'title' => 'Application Status',
            'message' => 'One of your application has been updated.',
            'action' => url('/seeker/home?toggle=applications')
        ];
    }
}
