<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $backpack;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($backpack)
    {
        $this->backpack = $backpack;
    }

    public function validateBackPack()
    {
        if ( is_null($this->backpack) || !isset($this->backpack['invoice_id']) || is_null($this->backpack['invoice_id']) ) {
            $log_message = "Class App\Mail\OrderCreated.php -> backpack 'invoice_id' is empty or not set. MAIL cannot send due to illegal data format.";
            Log::error($log_message);
            return false;
        }
        return true;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $backpack = $this->backpack;
        if ($this->validateBackPack()) {
            return $this->from(env('MAIL_FROM_ADDRESS'))
                ->view('mails.v2.orders.new', compact(['backpack']));
        }
    }
}
