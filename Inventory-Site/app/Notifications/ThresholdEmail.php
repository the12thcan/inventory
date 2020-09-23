<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ThresholdEmail extends Notification
{
    use Queueable;


    protected $itemName;
    protected $itemThreshold;
    protected $itemQuantity;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($itemName, $itemQuantity, $itemThreshold)
    {
        $this-> itemName = $itemName;
        $this-> itemThreshold = $itemThreshold;
        $this->itemQuantity = $itemQuantity;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Item below threshold') // it will use this class name if you don't specify
            ->greeting('Howdy') // example: Dear Sir, Hello Madam, etc ...
            ->level('info')// It is kind of email. Available options: info, success, error. Default: info
            ->line('The item '.$this->itemName.' is low on inventory.')
            ->line('Threshold: ' .$this->itemThreshold.' Quantity: '.$this->itemQuantity)
            ->action('Visit Dashboard', url('/dashboard'))
            ->salutation('Best regards');  // example: best regards, thanks, etc ...
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
