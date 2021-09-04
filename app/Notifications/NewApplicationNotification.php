<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($job, $applicant)
    {
        //
        $this->job = $job;
        $this->applicant = $applicant;
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
        $applicantName = $this->applicant->firstname.' '.$this->applicant->lastname;
        return (new MailMessage)
                    ->greeting('Good News!')
                    ->line('You Job Posting titled '.$this->job->job_title.' has new Application from '.$applicantName.'.')
                    ->action('View', url('/employer/job/'.$this->job->job_id));
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
            'title' => 'New Job Application',
            'message' => 'Your job posting titled '.$this->job->job_title.' has new application.',
            'action' => url('/employer/job/'.$this->job->job_id)
        ];
    }

}
