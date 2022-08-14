<?php

namespace App\Jobs\ThirdParty;

use Cryptommer\Smsir\Smsir;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $api_key;
    protected $line_number;
    protected $adapter;

    private $type;
    private $backpack;
    private $error;
    private $error_string;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $backpack)
    {
        $this->api_key = env('SMSIR_SMS_API_KEY');
        $this->line_number = env('SMSIR_SMS_LINE_NUMBER');
        $this->adapter = new Smsir($this->line_number, $this->api_key);

        $this->error = null;
        $this->error_string = null;
        $this->type = $type;
        $this->backpack = $backpack;
        $this->ValidateBackPack();
    }

    public function ValidateBackPack()
    {
        $data = $this->backpack;
        if (!isset($data['mobile_number'])) {
            $this->error[] = 'mobile_number not passed.';
        }
        if (!isset($data['content'])) {
            $this->error[] = 'content not passed.';
        }
        if (is_null($this->error)) {
            return true;
        } else {
            foreach ($this->error as $item) {
                $this->error_string .= "[ $item ] ";
            }
            return false;
        }
    }

    public function SendVerificationCode()
    {
        $mobile_number = $this->backpack['mobile_number'];
        $code = $this->backpack['content'];

        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.sms.ir/v1/send/verify',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '
                {
                "mobile": "' . $mobile_number . '",
                "templateId": 446681,
                "parameters": [
                {
                "name": "CODE",
                "value": "' . $code . '"
                }
                ]
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Accept: text/plain',
                    'x-api-key: ' . $this->api_key
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            if (empty($response)) {
                Log::critical("Sending OTP verfication to $mobile_number failed due error | error -> RESPONSE is empty, look like the provider [sms.ir] is not accessible.");
            } else {
                Log::info("Sending OTP verfication to $mobile_number | response -> $response");
            }

        } catch (Exception $e) {
            Log::critical("Sending OTP verfication to $mobile_number failed due error | error -> " . $e->getMessage());
        }
    }

    public function SendDietReadySMS()
    {
        $mobile_number = $this->backpack['mobile_number'];
        $content = $this->backpack['content'];
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.sms.ir/v1/send/bulk',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '
                {
                    "lineNumber": 30007732002704,
                    "messageText": "' . "$content عزیز، رژیم شما آماده و از طریق پنل کاربری قابل مشاهده است." . '",
                    "mobiles": [
                        "' . $mobile_number . '"
                    ],
                    "sendDateTime": null
                }',
                CURLOPT_HTTPHEADER => array(
                    'X-API-KEY: ' . $this->api_key,
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            if (empty($response)) {
                Log::critical("Sending Diet Ready to $mobile_number failed due error | error -> RESPONSE is empty, look like the provider [sms.ir] is not accessible.");
            } else {
                Log::info("Sending Diet Ready to $mobile_number | response -> $response");
            }

        } catch (Exception $e) {
            Log::critical("Sending Diet Ready to $mobile_number failed due error | error -> " . $e->getMessage());
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->ValidateBackPack()) {
            Log::critical('backpack content has some problems | ' . $this->error_string);
            return;
        }

        if ($this->type == 'VerficationCode') {
            $this->SendVerificationCode();
        } elseif ($this->type == 'PlainSMS') {
            $this->SendDietReadySMS();
        } else {
            return 'not supported';
        }
    }
}
