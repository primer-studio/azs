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
use Mockery\Exception;


class NextPay extends GatewayAbstract implements GatewayInterface
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
        Log::info("NextPay class init request started invoice: " . $this->invoice->id);
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

        Log::info("NextPay class init request body data (sent to NextPay) invoice: " . $this->invoice->id . " body: " . json_encode($data));

        try {
            // star to pay using NextPay api
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://nextpay.org/nx/gateway/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'api_key=' . $this->gateway->data->token . '&amount=' . $data['amount'] . '&order_id=' . $this->invoice->id . '&payer_name=' . $data['payerName'] . '&customer_phone=' . $data['payerIdentity'] . '&callback_uri='.$data['returnUrl'],

                // to debug ipg curl call
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $tid = json_decode($response)->trans_id;
            Log::info("NextPay class init request invoice: " . $this->invoice->id . " nextpay_trans_id:" . $tid . " ipg_init_refid received: " . $this->_createPayCode);
            return $tid;

        } catch (Exception $exception) {
            // TODO[back-end]: fix label
            $this->throwException($exception->getMessage());
        }
    }

    public function goToWebGate($tid = 'notSet')
    {
        if ($tid == 'notSet') {
            return new Exception('NextPay (goToWebGate) trans_id is null or not set. $tid value is ['.$tid.']');
        }
        // set session to track the first page which will be loaded after this step
        $session_value = $this->_createPayCode;
        $session_value .= "____" . (!empty($this->invoice->id) ? $this->invoice->id : "");
        $session_value .= "____" . (!empty($tid) ? "tid: $tid" : "");
        session()->put("redirected_to_ipg", $session_value);
        Log::info("NextPay class redirecting tracking session set session_value is $session_value , createPayCode : " . $this->_createPayCode . ", invoice: " . (!empty($this->invoice->id) ? $this->invoice->id : ""));

        Log::info("NextPay class redirecting (goToWebGate) , createPayCode : " . $this->_createPayCode . ", invoice: " . (!empty($this->invoice->id) ? $this->invoice->id : ""));
//        return redirect()->to('https://api.payping.ir/v2/pay/gotoipg/' . $this->_createPayCode);
        return redirect()->to("https://nextpay.org/nx/gateway/payment/$tid");
    }

    /**
     * @inheritDoc
     */
    public function callback()
    {
        Log::info("NextPay class callback, invoice: " . (!empty($this->invoice->id) ? $this->invoice->id : "") . " request: " . (!empty(json_encode($this->request->input())) ? json_encode($this->request->input()) : ""));

        $validator = Validator::make($this->request->all(), [
            'trans_id' => 'required',
            'order_id' => 'required',
            'amount' => 'required',
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
            'refid' => $this->request->input('trans_id')
        ]);

        return $this->verifyTransaction($this->request->input('trans_id'), $this->request->input('amount'));
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
    public function verifyTransaction($trans_id = null, $amount = mill)
    {
        Log::info("NextPay verifyTransaction invoice " . (!empty($this->invoice->id) ? $this->invoice->id : ""));

        try {
            // Here the code for successful request
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://nextpay.org/nx/gateway/verify',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'api_key=' . $this->gateway->data->token .'&amount=' . $amount . '&trans_id=' . $trans_id,

                // to debug ipg curl call
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $status_code = json_decode($response)->code;
            $encoded_response = $response;

            if ($status_code != 0) {
                // update invoice status
                $this->updateInvoice([
                    'status' => GeneralConstants::TRANSACTION_VERIFY_DATA_NOT_CORRECT
                ]);
                $log_message = "verify status code is not 0 (transaction did not verified ) status code is: " . $status_code . " encoded_response: " . $encoded_response;
                // TODO[back-end]: fix label
                $this->throwException($log_message, __("callback data is not correct"), null, true);
            }
            // if we are here it means that every thing is ok!
            // lets save data in database
            $this->updateInvoice([
                'status' => GeneralConstants::TRANSACTION_VERIFIED,
                'payment_code' => "pending",
            ]);
            Log::info("NextPay verifyTransaction invoice " . (!empty($this->invoice->id) ? $this->invoice->id : "") . " verified");

            return true;

        } catch (Exception $exception) {
            Log::info("NextPay verifyTransaction invoice " . (!empty($this->invoice->id) ? $this->invoice->id : "") . " CurlException");
            // update invoice status
            $this->updateInvoice([
                'status' => GeneralConstants::TRANSACTION_VERIFY_DATA_NOT_CORRECT
            ]);
            // TODO[back-end]: fix label
            $this->throwException("wrong data from gateway to verify transaction", __("general.wrong_data_from_gateway_to_verify_transaction"), $exception, true);
        } catch (\Exception $exception) {
            Log::info("NextPay verifyTransaction invoice " . (!empty($this->invoice->id) ? $this->invoice->id : "") . " Exception");
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


