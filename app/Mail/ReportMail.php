<?php

namespace App\Mail;

use Facades\App\Libraries\SettingHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $message;
    public $exceptionMessage;
    public $code;
    public $logId;
    public $requestUri;


    /**
     * Create a new message instance.
     *
     * @param string $message
     * @param string $exception_message
     * @param string $log_id
     * @param string $request_uri
     */
    public function __construct($message = '', $exception_message = '', $log_id = '', $request_uri = '')
    {
        $this->message = $message;
        $this->logId = $log_id;
        $this->requestUri = $request_uri;
        $this->exceptionMessage = $exception_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $sd =             [
            'log_id' => $this->logId,
            'report_message' => $this->message,
            'exception_message' => $this->exceptionMessage,
            'request_uri' => $this->requestUri,
        ];

        $settings = SettingHelper::getSettings();
        $cc = !empty($settings->email_cc) ? explode(',', $settings->email_cc) : '';
        $bcc = !empty($settings->email_bcc) ? explode(',', $settings->email_bcc) : '';
        $mail = $this->view('mails.report')->with(
            $sd
        )->from($settings->owner_email)
            ->subject("Problem Report")
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
