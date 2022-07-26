<?php


namespace App\Libraries;

use App\Events\PendingInvoiceItemEvent;
use App\Jobs\SendSmsJob;
use App\Libraries\Sms\Providers\SmsIR\SmsIRAdaptor;
use App\Libraries\Sms\SmsProviderAbstract;

class SmsHelper
{
    protected $provider;

    public function __construct()
    {
        // default sms provider
        $this->provider = new SmsIRAdaptor();
    }

    public function setProvider(SmsProviderAbstract $provider)
    {
        $this->provider = $provider;
        return $this;
    }


    public function sendVerificationCode($mobile, $code)
    {
        // just need to call send() method to send the sms
        SendSmsJob::dispatchNow($this->provider->sendVerificationCode($mobile, $code));
    }

    public function sendPendingInvoiceItem($mobile, $profile_name, $diet_title)
    {
        // just need to call send() method to send the sms
        SendSmsJob::dispatch($this->provider->sendPendingInvoiceItem($mobile, $profile_name, $diet_title));
    }

    public function sendOrderCreated($mobile, $profile_name, $diet_title)
    {
        // just need to call send() method to send the sms
        SendSmsJob::dispatch($this->provider->sendOrderCreated($mobile, $profile_name, $diet_title));
    }

    public function sendOrderCompleted($mobile, $profile_name, $diet_title)
    {
        // just need to call send() method to send the sms
        SendSmsJob::dispatch($this->provider->sendOrderCompleted($mobile, $profile_name, $diet_title));
    }

    public function sendOfflinePaymentVerified($mobile, $profile_name, $offline_payment_type)
    {
        // just need to call send() method to send the sms
        SendSmsJob::dispatch($this->provider->sendOfflinePaymentVerified($mobile, $profile_name, $offline_payment_type));
    }

    public function sendCartReminder($mobile, $profile_name)
    {
        // just need to call send() method to send the sms
        SendSmsJob::dispatch($this->provider->sendCartReminder($mobile, $profile_name));
    }
}
