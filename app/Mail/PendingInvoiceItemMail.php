<?php

namespace App\Mail;

use Facades\App\Libraries\SettingHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendingInvoiceItemMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $invoiceItem;

    /**
     * Create a new message instance.
     *
     * @param $invoiceItem
     */
    public function __construct($invoiceItem)
    {
        $this->invoiceItem = $invoiceItem;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // TODO[fix-label]:  fix label/message
        $settings = SettingHelper::getSettings();
        $cc = !empty($settings->email_cc) ? explode(',', $settings->email_cc) : '';
        $bcc = !empty($settings->email_bcc) ? explode(',', $settings->email_bcc) : '';
        return $this->view('mails.pending-invoice-item')->from($settings->owner_email)
            ->with(['invoice_item' => $this->invoiceItem])
            ->subject("Pending Invoice Item")
            ->to($settings->owner_email);
        if (!empty($cc)) {
            $mail = $mail->cc($cc);
        }
        if (!empty($bcc)) {
            $mail = $mail->bcc($bcc);
        }
        return $mail;
    }
}
