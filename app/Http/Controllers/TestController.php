<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ThirdParty\SmsController;
use App\Invoice;
use App\Jobs\AdminNewOrderJob;
use App\Libraries\UserHelper;
use App\Mail\OrderCreated;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function GenerateOTP()
    {
        return substr(str_shuffle('0123456789'.time()), 6, 5);
    }

    public function test()
    {
//        $adapter = new SmsController();
//        $adapter->SendVerificationCode('09128026221', $this->GenerateOTP());
//        $user = User::where('mobile_number', Auth::user()->mobile_number)
//            ->first()
//            ->profiles
//            ->whereNotNull('name')
//            ->first();
//        return is_null($user) ? "کاربر" : $user->name;




        $invoice = Invoice::findOrFail(4650);
        $backpack = [
            'is_test' => true,
            'invoice_id' => $invoice->id
        ];
////        return (new OrderCreated($backpack))->render();
//        Mail::to('arbazargani1998@gmail.com')->send(new OrderCreated($backpack));

        AdminNewOrderJob::dispatchNow($backpack);
    }
}
