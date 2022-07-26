<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PendingInvoiceItem extends Notification
{
    use Queueable;
    private $invoiceItem;

    /**
     * Create a new notification instance.
     *
     * @param $invoiceItem
     */
    public function __construct($invoiceItem)
    {
        $this->invoiceItem = $invoiceItem;
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
        return [
            'invoice_id' => $this->invoiceItem->invoice->id,
            'invoice_item_id' => $this->invoiceItem->id,
            'diet_title' => $this->invoiceItem->diet_registered_data->title,
            'selected_period' => $this->invoiceItem->diet_registered_data->selected_period,
        ];

    }
}
