<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewVerificationProofNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($verificationProof, $employer)
    {
        //
        $this->verificationProof = $verificationProof;
        $this->employer = $employer;

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
                    ->success()
                    ->subject('New Verification Request')
                    ->greeting('Hello Admin')
                    ->line($this->employer->company_name.' submitted a new verification proof for their account.')
                    ->action('View Documents', url('/admin/verication-proof/'.$this->employer->user_id))
                    ->line('Thank you and Good Day!');
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
            'title' => 'Verification Proof',
            'message' => $this->employer->company_name.' submitted a new verification proof for their account.',
            'action' => url('/admin/verification-proof/'.$this->employer->user_id)
        ];
    }
}
