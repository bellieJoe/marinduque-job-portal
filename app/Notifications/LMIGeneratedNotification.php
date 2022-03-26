<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LMIGeneratedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->month = Carbon::now()->format("m") > 1 ? Carbon::now()->format("m") - 1 : 12;
        $this->year = $this->month == 1 ? Carbon::now()->format("Y") - 1 : Carbon::now()->format("Y");
        $this->dt = Carbon::create($this->year, $this->month);
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
        // $dt = $this->da
        return (new MailMessage)
                    ->line($notifiable->email)
                    ->line('A new LMI report has been generated for the month of '.$this->dt->format('F').' '.$this->dt->format('Y'))
                    ->action('View', url('/admin/reports/lmi-report?month='.$this->month.'&year='.$this->year))
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
            'title' => 'New LMI Report',
            'message' => 'A new LMI report has been generated for the month of '.$this->dt->format('F').' '.$this->dt->format('Y'),
            'action' => url('/admin/reports/lmi-report?month='.$this->month.'&year='.$this->year)
        ];
    }
}
