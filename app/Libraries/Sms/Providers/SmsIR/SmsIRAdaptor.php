<?php


namespace App\Libraries\Sms\Providers\SmsIR;

use App\Libraries\Sms\SmsProviderAbstract;

class SmsIRAdaptor extends SmsProviderAbstract
{
    private $SMS_API_KEY;
    private $SMS_SECRET_KEY;
    private $UltraFastSend;
    private $data;

    public function __construct()
    {
        // your sms.ir panel configuration
        $this->SMS_API_KEY = env('SMSIR_SMS_API_KEY');
        $this->SMS_SECRET_KEY = env('SMSIR_SMS_SECRET_KEY');
        $this->UltraFastSend = new UltraFastSend($this->SMS_API_KEY, $this->SMS_SECRET_KEY);
    }

    public function sendVerificationCode($mobile, $code)
    {
        // message data
        $this->data = array(
            "ParameterArray" => array(
                array(
                    "Parameter" => "VerificationCode",
                    "ParameterValue" => $code
                ),
            ),
            "Mobile" => $mobile,
            "TemplateId" => "26630"
        );
        return $this;
    }

    public function sendPendingInvoiceItem($mobile, $profile_name, $diet_title)
    {
        // message data
        $this->data = array(
            "ParameterArray" => array(
                array(
                    "Parameter" => "profileName",
                    "ParameterValue" => $profile_name
                ),
                array(
                    "Parameter" => "dietTitle",
                    "ParameterValue" => $diet_title
                ),
            ),
            "Mobile" => $mobile,
            "TemplateId" => "26818"
        );
        return $this;
    }

    public function sendOrderCreated($mobile, $profile_name, $diet_title)
    {
        // message data
        $this->data = array(
            "ParameterArray" => array(
                array(
                    "Parameter" => "profileName",
                    "ParameterValue" => $profile_name
                ),
                array(
                    "Parameter" => "dietTitle",
                    "ParameterValue" => $diet_title
                ),
            ),
            "Mobile" => $mobile,
            "TemplateId" => "26816"
        );
        return $this;
    }

    public function sendOrderCompleted($mobile, $profile_name, $diet_title)
    {
        // message data
        $this->data = array(
            "ParameterArray" => array(
                array(
                    "Parameter" => "profileName",
                    "ParameterValue" => $profile_name
                ),
                array(
                    "Parameter" => "dietTitle",
                    "ParameterValue" => $diet_title
                ),
            ),
            "Mobile" => $mobile,
            "TemplateId" => "29599"
        );
        return $this;
    }

    public function sendOfflinePaymentVerified($mobile, $profile_name, $offline_payment_type)
    {
        // message data
        $this->data = array(
            "ParameterArray" => array(
                array(
                    "Parameter" => "profileName",
                    "ParameterValue" => $profile_name
                ),
                array(
                    "Parameter" => "OfflinePaymentType",
                    "ParameterValue" => $offline_payment_type
                ),
            ),
            "Mobile" => $mobile,
            "TemplateId" => "26844"
        );
        return $this;
    }

    public function sendCartReminder($mobile, $profile_name)
    {
        // message data
        $this->data = array(
            "ParameterArray" => array(
                array(
                    "Parameter" => "profileName",
                    "ParameterValue" => $profile_name
                ),
            ),
            "Mobile" => $mobile,
            "TemplateId" => "29600"
        );
        return $this;
    }

    public function send()
    {
        try {
            $UltraFastSend = $this->UltraFastSend->UltraFastSend($this->data);
            if ($UltraFastSend === false) {
                $this->reportMessageDidNotSend($this->data);
            }
        } catch (\Exeption $exception) {
            $this->report($exception);
        }
    }
}
