<?php


namespace App\Libraries\Payment\Gateways;


use App\Constants\GeneralConstants;
use App\Discount;
use App\Exceptions\StopException;
use App\Invoice;
use App\Libraries\Payment\GatewayAbstract;
use App\Libraries\Payment\GatewayInterface;
use Facades\App\Libraries\ProfileHelper;
use Facades\App\Libraries\UserHelper;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;


class ZarinPal extends GatewayAbstract implements GatewayInterface
{
    protected $_guzzleClient;
    protected $_requestHeaders;
    protected $_createPayCode; // IPG passes this code while creating new payment
    protected $final_amounts;

    public function __construct($gateway_data, $invoice, $request)
    {
        parent::__construct($gateway_data, $invoice, $request);
        $this->final_amounts = [
            'tomans' => '',
            'rials' => ''
        ];
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
    public function init($dicount_code = null)
    {
        Log::info("ZarinPal class init request started invoice: " . $this->invoice->id);
        // NOTICE: gateway_id and invoice_id must NOT be overwrote
        $route_parameters = UserHelper::getLastQueryStringData();
        $route_parameters['gateway_id'] = encrypt($this->gateway->id);
        $route_parameters['invoice_id'] = encrypt($this->invoice->id);


        /**
         * check for active discount in cycle to reduce total price.
         */
        $user_has_active_discount = DB::table('user_discounts')->where([
            'profile_id' => ProfileHelper::getCurrentProfile()->id,
            'is_valid' => 1,
        ])->latest()->first();

        if (!is_null($user_has_active_discount)) {

            $discount_code = Discount::find($user_has_active_discount->discount_id);
            $total = $this->invoice->total_amount;

            if ($discount_code->is_active) {
                if ($discount_code->type == 'simple') {
                    $new_total = money($total - (float) $discount_code->amount, true);
                } elseif ($discount_code->type == 'percentage') {
                    $new_total = money($total - ($total * ($discount_code->amount/100)), true);
                } else {
                    $new_total = money($total, true);
                }
            }
            /**
             *  ----------> new total is in toman, dont change it to rials till you know what are you doing!
             * */
            // to remove ',' from price, like changing 22,000 to 22000
            $new_total = (integer) str_replace(',', null, $new_total);
            $invoice = Invoice::where('id', $this->invoice->id)->update([
                'discount_info' => json_encode([
                    'discount_code' => $discount_code->id,
                    'price_before_discount' => $total,
                    'price_after_discount' => $new_total,
                    'user_valid_discounts_destroyed' => true
                ])
            ]);
        }


        $return_url = route('dashboard.ipg-callback', $route_parameters);

        $this->final_amounts['rials'] = (isset($new_total)) ? $this->convertTomanToRial($new_total) :  $this->invoice->total_amount;
        $this->final_amounts['tomans'] = (isset($new_total)) ? $new_total : $this->convertRialToToman($this->invoice->total_amount);

        Cache::put("profile_".ProfileHelper::getCurrentProfile()->id."_last_amount_value", json_encode($this->final_amounts));

        $data = [
            "merchant_id" => $this->gateway->data->token,
            "amount" => (isset($new_total)) ? $this->convertTomanToRial($new_total) : $this->invoice->total_amount,
            "amount_tomans" => (isset($new_total)) ? $new_total : $this->convertRialToToman($this->invoice->total_amount),
            "callback_url" => $return_url,
            "description" => $this->settings->short_title . " | " . $this->profile->name,
            "meta_data" => json_encode(["mobile" => $this->profile->mobile_number, "email" => '']),
            // below settings not used in zarinpal gateway, but we will use them for logging.
            "returnUrl" => $return_url,
            "payerIdentity" => $this->profile->mobile_number,
            "payerName" => $this->profile->name,
            // TODO[back-end]: change the following label
            "clientRefId" => encrypt($this->invoice->id)
        ];

        Log::info("ZarinPal class init request body data (sent to ZarinPal) invoice: " . $this->invoice->id . " body: " . json_encode($data));

        try {
            // star to pay using NextPay api
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.zarinpal.com/pg/v4/payment/request.json',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'merchant_id=' . $this->gateway->data->token
                    . '&amount=' . $data['amount']
                    . '&callback_url=' . $data['returnUrl']
                    . '&description=' . $data['description']
                    . '&meta_data=' . $data['meta_data']
                    . '&order_id=' . $this->invoice->id
                    . '&payer_name=' . $data['payerName']
                    . '&customer_phone=' . $data['payerIdentity']
                ,

                // to debug ipg curl call
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $tid = (json_decode($response))->data->authority;
            Log::info("ZarinPal class init request invoice: " . $this->invoice->id . " zarinpal_trans_id:" . $tid . " ipg_init_response received: " . $response);
            return $tid;

        } catch (Exception $exception) {
            // TODO[back-end]: fix label
            $this->throwException($exception->getMessage());
        }
    }

    public function goToWebGate($tid = 'notSet')
    {
        if ($tid == 'notSet') {
            return new Exception('Zarinpal (goToWebGate) trans_id([\'data\'][\'authority\']) is null or not set. $tid value is [' . $tid . ']');
        }
        // set session to track the first page which will be loaded after this step
        $session_value = $this->_createPayCode;
        $session_value .= "____" . (!empty($this->invoice->id) ? $this->invoice->id : "");
        $session_value .= "____" . (!empty($tid) ? "tid: $tid" : "");
        session()->put("redirected_to_ipg", $session_value);
        Log::info("ZarinPal class redirecting tracking session set session_value is $session_value , createPayCode : " . $this->_createPayCode . ", invoice: " . (!empty($this->invoice->id) ? $this->invoice->id : ""));

        Log::info("ZarinPal class redirecting (goToWebGate) , createPayCode : " . $this->_createPayCode . ", invoice: " . (!empty($this->invoice->id) ? $this->invoice->id : ""));
//        return redirect()->to('https://api.payping.ir/v2/pay/gotoipg/' . $this->_createPayCode);
        return redirect()->to("https://www.zarinpal.com/pg/StartPay/$tid");
    }

    /**
     * @inheritDoc
     */
    public function callback()
    {
        Log::info("ZarinPal class callback, invoice: " . (!empty($this->invoice->id) ? $this->invoice->id : "") . " request: " . (!empty(json_encode($this->request->input())) ? json_encode($this->request->input()) : ""));

        $validator = Validator::make($this->request->all(), [
            'Authority' => 'required',
            'Status' => 'required',
        ]);
        if ($validator->fails()) {
            Log::info("ZarinPal class callback validator fails invoice: " . (!empty($this->invoice->id) ? $this->invoice->id : "") . "request: " . (!empty(json_encode($this->request->input())) ? json_encode($this->request->input()) : ""));

            // update invoice status
            $this->updateInvoice([
                'status' => GeneralConstants::TRANSACTION_CALLBACK_DATA_NOT_CORRECT
            ]);
            $add_discount = DB::table('user_discounts')->where([
                'profile_id' => ProfileHelper::getCurrentProfile()->id,
            ])->update([
                'is_valid' => 0
            ]);
            $log_message = "callback data is not correct: " . json_encode($validator->messages()) . " input: " . json_encode($this->request->all());
            // TODO[back-end]: fix label
            $this->throwException($log_message, __("callback data is not correct"), null, true);
        }
        // update invoice refid
        $this->updateInvoice([
            'refid' => $this->request->input('Authority')
        ]);

        return $this->verifyTransaction($this->request->input('Authority'), $this->invoice->total_amount);
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
    public function verifyTransaction($trans_id = null, $amount = null)
    {
        Log::info("ZarinPal verifyTransaction invoice " . (!empty($this->invoice->id) ? $this->invoice->id : ""));

        try {
            $vals = json_decode(Cache::pull("profile_".ProfileHelper::getCurrentProfile()->id."_last_amount_value"), true);
            // Here the code for successful request
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.zarinpal.com/pg/v4/payment/verify.json',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'merchant_id=' . $this->gateway->data->token
//                    . '&amount=' . intval($amount)
                    . '&amount=' . intval($vals['rials'])
                    . '&authority=' . $trans_id
            ,

                // to debug ipg curl call
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $status_code = (json_decode($response))->data->code;
            $encoded_response = $response;
            Log::emergency('ZarinPal Class Trying To get Code from [(json_decode($response))->data->code] returns error. to Debug, this is the pure encoded response: '.$encoded_response);

            if (!in_array($status_code, [100, 101], true)) {
                // update invoice status
                $this->updateInvoice([
                    'status' => GeneralConstants::TRANSACTION_VERIFY_DATA_NOT_CORRECT
                ]);
                $add_discount = DB::table('user_discounts')->where([
                    'profile_id' => ProfileHelper::getCurrentProfile()->id,
                ])->update([
                    'is_valid' => 0
                ]);
                $log_message = "verify status code is not 100/101 (transaction did not verified ) status code is: " . $status_code . " response is in next line... ";
                $log_message = "----> encoded_response: " . $encoded_response;
                // TODO[back-end]: fix label
                $this->throwException($log_message, __("callback data is not correct"), null, true);
            }
            // if we are here it means that every thing is ok!
            // lets save data in database
            $this->updateInvoice([
                'status' => GeneralConstants::TRANSACTION_VERIFIED,
                'payment_code' => "",
            ]);
            $add_discount = DB::table('user_discounts')->where([
                'profile_id' => ProfileHelper::getCurrentProfile()->id,
            ])->update([
                'is_valid' => 0
            ]);
            Log::info("ZarinPal verifyTransaction invoice " . (!empty($this->invoice->id) ? $this->invoice->id : "") . " verified");

            return true;

        } catch (Exception $exception) {
            Log::info("ZarinPal verifyTransaction invoice " . (!empty($this->invoice->id) ? $this->invoice->id : "") . " CurlException");
            // update invoice status
            $this->updateInvoice([
                'status' => GeneralConstants::TRANSACTION_VERIFY_DATA_NOT_CORRECT
            ]);
            $add_discount = DB::table('user_discounts')->where([
                'profile_id' => ProfileHelper::getCurrentProfile()->id,
            ])->update([
                'is_valid' => 0
            ]);
            // TODO[back-end]: fix label
            $this->throwException("wrong data from gateway to verify transaction", __("general.wrong_data_from_gateway_to_verify_transaction"), $exception, true);
        } catch (\Exception $exception) {
            Log::info("ZarinPal verifyTransaction invoice " . (!empty($this->invoice->id) ? $this->invoice->id : "") . " Exception");
            // update invoice status
            $this->updateInvoice([
                'status' => GeneralConstants::TRANSACTION_VERIFY_DATA_NOT_CORRECT
            ]);
            $add_discount = DB::table('user_discounts')->where([
                'profile_id' => ProfileHelper::getCurrentProfile()->id,
            ])->update([
                'is_valid' => 0
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


