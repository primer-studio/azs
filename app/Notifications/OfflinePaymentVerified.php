<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfflinePaymentVerified extends Notification
{
    use Queueable;
    private $offline_payment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($offline_payment)
    {
        //
        $this->offline_payment = $offline_payment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
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
        $invoice = $this->offline_payment->invoice;
        return [
            'offline_payment_id' => $this->offline_payment->id,
            'invoice_id' => $invoice->id,
        ];
    }
}
