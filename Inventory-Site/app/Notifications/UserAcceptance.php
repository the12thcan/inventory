<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserAcceptance extends Notification
{
    use Queueable;

    protected $userName;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($userName)
    {
        $this->userName = $userName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->subject('Account rejected')
                    ->greeting('Howdy '.$this->userName) //add user name
                    ->level('info')
                    ->line('Your account has been rejected by the administrator.')
                    ->line('If you believe this to be a mistake please give us a call');
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
        ];
    }
}
