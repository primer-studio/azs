<?php


namespace App\Libraries\Payment\Gateways;


use App\Constants\GeneralConstants;
use App\Exceptions\StopException;
use App\Libraries\Payment\GatewayAbstract;
use App\Libraries\Payment\GatewayInterface;
use Facades\App\Libraries\UserHelper;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class PayPing extends GatewayAbstract implements GatewayInterface
{
    protected $_guzzleClient;
    protected $_requestHeaders;
    protected $_createPayCode; // IPG passes this code while creating new payment

    public function __construct($gateway_data, $invoice, $request)
    {
        parent::__construct($gateway_data, $invoice, $request);

        $this->_guzzleClient = new \GuzzleHttp\Client();
        if (empty($this->gateway->data->token)) {
            // TODO[back-end]: fix label
            $this->throwException("token is not set in gateway data", __("gateway data is not complete"));
        }
        $this->_requestHeaders = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$this->gateway->data->token}",
        ];
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        Log::info("PayPing class init request started invoice: " . $this->invoice->id);
        // NOTICE: gateway_id and invoice_id must NOT be overwrote
        $route_parameters = UserHelper::getLastQueryStringData();
        $route_parameters['gateway_id'] = encrypt($this->gateway->id);
        $route_parameters['invoice_id'] = encrypt($this->invoice->id);
        $return_url = route('dashboard.ipg-callback', $route_parameters);
        $data = [
            "amount" => $this->convertRialToToman($this->invoice->total_amount),
            "returnUrl" => $return_url,
            "payerIdentity" => $this->profile->mobile_number,
            "payerName" => $this->profile->name,
            // TODO[back-end]: change the following label
            "description" => $this->settings->short_title,
            "clientRefId" => encrypt($this->invoice->id)
        ];

        Log::info("PayPing class init request body data (sent to PayPing) invoice: " . $this->invoice->id . " body: " . json_encode($data));

        try {
            // Here the code for successful request
            $response = $this->_guzzleClient->request('POST', 'https://api.payping.ir/v2/pay',
                [
                    'body' => json_encode($data),
                    'headers' => $this->_requestHeaders,
                    'http_errors' => true
                ]);
            $encoded_response = $response->getBody()->getContents();
            $decoded_data = json_decode($encoded_response);
            if (empty($decoded_data->code)) {
                // TODO[back-end]: fix label
                $this->throwException("didn't pass code to create payment (init)", __("general.wrong_data_from_gateway"), null, true);
            }
            $this->_createPayCode = $decoded_data->code;
            Log::info("PayPing class init request invoice: " . $this->invoice->id . " ipg_init_refid received: " . $this->_createPayCode);
            $this->updateInvoice([
                'ipg_init_refid' => $this->_createPayCode
            ]);
            return true;

        } catch (GuzzleException $exception) {
            // TODO[back-end]: fix label
            $this->throwException("wrong data error", __("general.wrong_data_from_gateway"), $exception, true);
        } catch (\Exception $exception) {
            // TODO[back-end]: fix label
            $this->throwException(" get code error", __("general.wrong_data_from_gateway"), $exception, true);
        }
    }

    public function goToWebGate()
    {
        // set session to track the first page which will be loaded after this step
        $session_value = $this->_createPayCode;
        $session_value .= "____" . (!empty($this->invoice->id) ? $this->invoice->id : "");
        session()->put("redirected_to_ipg", $session_value);
        Log::info("PayPing class redirecting tracking session set session_value is $session_value , createPayCode : " . $this->_createPayCode . ", invoice: " . (!empty($this->invoice->id) ? $this->invoice->id : ""));

        Log::info("PayPing class redirecting (goToWebGate) , createPayCode : " . $this->_createPayCode . ", invoice: " . (!empty($this->invoice->id) ? $this->invoice->id : ""));
        return redirect()->to('https://api.payping.ir/v2/pay/gotoipg/' . $this->_createPayCode);
    }

    /**
     * @inheritDoc
     */
    public function callback()
    {
        Log::info("PayPing class callback, invoice: " . (!empty($this->invoice->id) ? $this->invoice->id : "") . " request: " . (!empty(json_encode($this->request->input())) ? json_encode($this->request->input()) : ""));

        $validator = Validator::make($this->request->all(), [
            'refid' => 'required',
            'clientrefid' => 'required',
        ]);
        if ($validator->fails()) {
            Log::info("PayPing class callback validator fails invoice: " . (!empty($this->invoice->id) ? $this->invoice->id : "") . "request: " . (!empty(json_encode($this->request->input())) ? json_encode($this->request->input()) : ""));

            // update invoice status
            $this->updateInvoice([
                'status' => GeneralConstants::TRANSACTION_CALLBACK_DATA_NOT_CORRECT
            ]);
            $log_message = "callback data is not correct: " . json_encode($validator->messages()) . " input: " . json_encode($this->request->all());
            // TODO[back-end]: fix label
            $this->throwException($log_message, __("callback data is not correct"), null, true);
        }
        // update invoice refid
        $this->updateInvoice([
            'refid' => $this->request->input('refid')
        ]);

        return $this->verifyTransaction();
    }

    /**
     * @inheritDoc
     */
    public function checkPay()
    {
        // TODO: Implement checkPay() method.
    }

    /**
     * @inheritDoc
     */
    public function verifyTransaction()
    {
        Log::info("PayPing verifyTransaction invoice " . (!empty($this->invoice->id) ? $this->invoice->id : ""));
        $data = [
            'amount' => $this->convertRialToToman($this->invoice->total_amount),
            'refId' => $this->request->input('refid')
        ];

        try {
            // Here the code for successful request
            $response = $this->_guzzleClient->request('POST', 'https://api.payping.ir/v2/pay/verify',
                [
                    'body' => json_encode($data),
                    'headers' => $this->_requestHeaders,
                    'http_errors' => true
                ]);

            $status_code = $response->getStatusCode();
            $encoded_response = $response->getBody()->getContents();

            Log::info("PayPing verifyTransaction invoice " . (!empty($this->invoice->id) ? $this->invoice->id : "") . " status_code: " . $status_code);

            // based on PayPing's docs $status_code == 200 means that the transaction verified successfully
            if ($status_code != 200) {
                // update invoice status
                $this->updateInvoice([
                    'status' => GeneralConstants::TRANSACTION_VERIFY_DATA_NOT_CORRECT
                ]);
                $log_message = "verify status code is not 200 (transaction did not verified ) status code is: " . $status_code . " encoded_response: " . $encoded_response;
                // TODO[back-end]: fix label
                $this->throwException($log_message, __("callback data is not correct"), null, true);
            }
            // if we are here it means that every thing is ok!
            // lets save data in database
            $this->updateInvoice([
                'status' => GeneralConstants::TRANSACTION_VERIFIED,
                'payment_code' => "pending",
            ]);
            Log::info("PayPing verifyTransaction invoice " . (!empty($this->invoice->id) ? $this->invoice->id : "") . " verified");

            return true;

        } catch (GuzzleException $exception) {
            Log::info("PayPing verifyTransaction invoice " . (!empty($this->invoice->id) ? $this->invoice->id : "") . " GuzzleException");
            // update invoice status
            $this->updateInvoice([
                'status' => GeneralConstants::TRANSACTION_VERIFY_DATA_NOT_CORRECT
            ]);
            // TODO[back-end]: fix label
            $this->throwException("wrong data from gateway to verify transaction", __("general.wrong_data_from_gateway_to_verify_transaction"), $exception, true);
        } catch (\Exception $exception) {
            Log::info("PayPing verifyTransaction invoice " . (!empty($this->invoice->id) ? $this->invoice->id : "") . " Exception");
            // update invoice status
            $this->updateInvoice([
                'status' => GeneralConstants::TRANSACTION_VERIFY_DATA_NOT_CORRECT
            ]);
            $this->throwException("verifyTransaction error: {$exception->getMessage()}", __("general.wrong_data_from_gateway_to_verify_transaction"), null, true);
        }
    }

    /**
     * @inheritDoc
     */
    public function reverseTransaction()
    {
        // TODO: Implement reverseTransaction() method.
    }

    public function convertRialToToman($rial_amount)
    {
        return intval($rial_amount) / 10;
    }

    public function convertTomanToRial($toman_amount)
    {
        return intval($toman_amount) * 10;
    }
}


