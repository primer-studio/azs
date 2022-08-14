<?php

namespace App\Http\Controllers\ThirdParty;

use App\Http\Controllers\Controller;
use App\Jobs\ThirdParty\SendSmsJob;
use Illuminate\Http\Request;
use Cryptommer\Smsir\Smsir;
use Mockery\Exception;

class SmsController extends Controller
{
    protected $api_key;
    protected $line_number;
    protected $adapter;

    public function __construct()
    {
        $this->api_key = env('SMSIR_API_KEY');
        $this->line_number = env('SMSIR_LINE_NUMBER');
        $this->adapter = new Smsir($this->line_number, $this->api_key);
    }

    public function GenerateOTP()
    {
        return substr(str_shuffle('0123456789'.time()), 6, 5);
    }

    public function SendVerificationCode($mobile_number, $code)
    {
        SendSmsJob::dispatchNow('VerficationCode', [
            'mobile_number' => $mobile_number,
            'content' => $code
        ]);
    }

    public function SendDietReadySMS($mobile_number, $name)
    {
        SendSmsJob::dispatchNow('PlainSMS', [
            'mobile_number' => $mobile_number,
            'content' => $name
        ]);
    }
}
