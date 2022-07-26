<?php

namespace App\Mail;

use Facades\App\Libraries\SettingHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StopExceptionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $message;
    public $code;
    public $logId;
    public $requestUri;
    public $messageToDisplay;


    /**
     * Create a new message instance.
     *
     * @param string $message
     * @param string $code
     * @param string $log_id
     * @param string $request_uri
     * @param string $message_to_display
     */
    public function __construct($message = '', $code = '', $log_id = '', $request_uri = '', $message_to_display = '')
    {
        $this->message = $message;
        $this->code = $code;
        $this->logId = $log_id;
        $this->requestUri = $request_uri;
        $this->messageToDisplay = $message_to_display;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $settings = SettingHelper::getSettings();
        $cc = !empty($settings->email_cc) ? explode(',', $settings->email_cc) : '';
        $bcc = !empty($settings->email_bcc) ? explode(',', $settings->email_bcc) : '';
        $mail = $this->view('mails.stop-exception')->with(
            [
                'log_id' => $this->logId,
                'exception_message' => $this->message,
                'message_to_display' => $this->messageToDisplay,
                'code' => $this->code,
                'request_uri' => $this->requestUri,
            ]
        )->from($settings->owner_email)
        ->subject("IPG exception")
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
