<?php

namespace App\Mail;

use Facades\App\Libraries\SettingHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class verificationTest extends Mailable
{
    use Queueable, SerializesModels;
    private $mobile;
    private $code;

    /**
     * Create a new message instance.
     *
     * @param $mobile
     * @param $code
     */
    public function __construct($mobile, $code)
    {
        //
        $this->mobile = $mobile;
        $this->code = $code;
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
        return $this->view('mails.verificationTest')->from($settings->owner_email)
            ->with([
                'code' => $this->code,
                'mobile' => $this->mobile,
            ])
            ->subject("verification code $this->code")
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
