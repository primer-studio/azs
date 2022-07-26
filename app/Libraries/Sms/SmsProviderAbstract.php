<?php


namespace App\Libraries\Sms;


abstract class SmsProviderAbstract
{
    public abstract function sendVerificationCode($mobile, $code);

    public function report($exception)
    {
        hiReport("error while sending sms" , $exception);
    }

    public function reportMessageDidNotSend($data)
    {
        hiReport("SMS didn't send " . json_encode($data));
    }

    public abstract function send();
}
