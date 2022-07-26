<?php


namespace App\Libraries\Payment;


use App\Constants\GeneralConstants;
use App\Exceptions\IPGStopException;
use App\Exceptions\StopException;
use App\Invoice;
use Facades\App\Libraries\InvoiceHelper;
use App\Libraries\Payment\Gateways\PayPing;
use App\Libraries\Payment\Gateways\NextPay;
use App\PaymentGateway;
use Illuminate\Support\Facades\Log;

class Payment
{
    protected $_gatewayData;
    public $gateway;
    public $request;

    /**
     * Payment constructor.
     * Payment constructor.
     * if $invoice_id is null it means you are creating new payment
     * if $invoice_id is NOT null it means it is payment callback
     * @param $gateway_id
     * @param null $invoice_id
     * @param null $request
     * @throws IPGStopException
     * @throws StopException
     */
    public function __construct($gateway_id, $invoice_id = null, $request = null)
    {
        $this->request = $request;
        $this->_gatewayData = PaymentGateway::findOrFail($gateway_id);
        if ($this->_gatewayData->status !== 'active') {
            throw new StopException("Payment class gateway is not active : {$this->_gatewayData->short_name} - {$this->_gatewayData->status}, invoice: $invoice_id", __('gateway not found'));
        }
        if (empty($invoice_id)) {
            // create new invoice (this method will throw exception if there is no diet to pay)
            $invoice = InvoiceHelper::createInvoiceByCartForCurrentProfile(GeneralConstants::PAYMENT_WAY_IPG, $this->_gatewayData->id);
        } else {
            $invoice = Invoice::find($invoice_id);
            if (empty($invoice)) {
                // TODO[back-end]: fix label
                throw new StopException("Payment class invoice not found: $invoice_id", __('invoice not found, transaction failed'));
            }
        }

        switch ($this->_gatewayData->short_name) {
            case "PayPing" :
                $this->gateway = new PayPing($this->_gatewayData, $invoice, $this->request);
                break;
            case "NextPay" :
                $this->gateway = new NextPay($this->_gatewayData, $invoice, $this->request);
                break;
            default:
                // TODO[back-end]: fix label
                throw new StopException("Payment class gateway not found: {$this->_gatewayData->short_name} invoice: $invoice_id", __('gateway not found'));
        }

        // check invoice is not already verified
        if ($invoice->status == GeneralConstants::TRANSACTION_VERIFIED) {
            // TODO[back-end]: fix label
            $this->gateway->throwException('Payment class transaction is already verified, invoice: $invoice_id', 'transaction is already verified');
        }
    }

    public function init()
    {
        return $this->gateway->init();
    }

    public function goToWebGate($tid = 'notSet')
    {
        // update invoice status
        InvoiceHelper::updateInvoice($this->getInvoice()->id, [
            'status' => GeneralConstants::TRANSACTION_WEB_GATE
        ]);
        return $this->gateway->goToWebGate($tid);
    }

    public function callback()
    {
        Log::info("Payment class callback invoice: " . (!empty($this->gateway->invoice->id) ? $this->gateway->invoice->id : ""));
        // update invoice status
        InvoiceHelper::updateInvoice($this->gateway->invoice->id, [
            'status' => GeneralConstants::TRANSACTION_CALLBACK
        ]);
        return $this->gateway->callback();
    }

    public function getInvoice()
    {
        return $this->gateway->invoice;
    }
}
