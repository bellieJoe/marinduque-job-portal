<?php

namespace App\Notifications;

use App\Models\Job;
use App\Models\Seeker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use PhpParser\Node\Scalar\MagicConst\Line;

class InvitationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Seeker $seeker, Job $job, $note)
    {
        //
        $this->job = $job;
        $this->seeker = $seeker;
        $this->note = $note;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'broadcast', 'database'];
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
                    ->greeting("Good day ".$this->seeker->firstname."!")
                    ->line("We are please to announce to you that you have been sent a job invitation from ".$this->job->company_name)
                    ->line("Message from ".$this->job->company_name)
                    ->line($this->note)
                    ->action("View Job Posting", url("/job-search-mdq/view/".$this->job->job_id))
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
            'title' => "Job Invitation",
            'message' => $this->note,
            'action' => url("/job-search-mdq/view/".$this->job->job_id)
        ];
    }
}
