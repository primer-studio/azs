<?php


namespace App\Libraries\Payment;


use App\Exceptions\IPGStopException;
use App\Exceptions\StopException;
use Facades\App\Libraries\ProfileHelper;
use Facades\App\Libraries\SettingHelper;
use Facades\App\Libraries\InvoiceHelper;

abstract class GatewayAbstract
{
    public $initializedData = array(); // read getInitializedData() description
    public $gateway; // gateway data in database
    public $invoice;
    public $callbackData;
    public $profile;
    public $settings;
    public $request;
    public $discount_code;

    public function __construct($gateway_data, $invoice, $request)
    {
        $this->setGateway($gateway_data);
        $this->setInvoice($invoice);
        $this->request = $request;
        $this->profile = ProfileHelper::getCurrentProfile();
        $this->settings = SettingHelper::getSettings();
    }

    /**
     * @param $gateway_data
     */
    public function setGateway($gateway_data)
    {
        $this->gateway = $gateway_data;
    }

    /**
     * read getInitializedData() description
     * @param $invoice
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * update invoice and set it in $this->invoice
     * @param $data
     */
    public function updateInvoice($data)
    {
        $this->invoice = InvoiceHelper::updateInvoice($this->invoice->id, $data);
    }

    /**
     * some gateways generate data before going to web gate like: authority
     * this is up to each gateway's class to generate them and pass them by getInitData()
     * @return array
     */
    public function getInitData()
    {
        return $this->initializedData;
    }

    /**
     * @param $data
     */
    public function setCallbackData($data)
    {
        $this->callbackData = $data;
    }

    /**
     * @return mixed
     */
    public function getCallbackData()
    {
        return $this->callbackData;
    }

    public function throwException($log_message, $display_message, $exception = null, $report = false)
    {
        throw new IPGStopException($this->gateway->short_name, $this->invoice, $log_message, $display_message, $exception, $report);
    }
}
