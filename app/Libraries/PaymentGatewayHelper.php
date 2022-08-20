<?php


namespace App\Libraries;


use App\Constants\GeneralConstants;
use App\Diet;
use App\Jobs\AdminNewOrderJob;
use App\PaymentGateway;
use Facades\App\Libraries\DietHelper;
use Facades\App\Libraries\ProfileHelper;
use Illuminate\Http\Request;
use Facades\App\Libraries\CartHelper;
use Illuminate\Support\Facades\Log;

class PaymentGatewayHelper
{
    /**
     * @return array
     */
    public function getAvailableDietsToPayForCurrentProfile()
    {
        $profile = ProfileHelper::getCurrentProfile();
        return $this->getAvailableDietsToPay($profile->id);
    }

    /**
     * get the diets which exist in session and have their selected period is active
     * @param $profile_id
     * @return array
     */
    public function getAvailableDietsToPay($profile_id)
    {
        $cart_items = CartHelper::getCartItems($profile_id);
        // diets which exist in session and have their selected period is active
        $available_diets = [];
        foreach ($cart_items as $cart_item) {
            // check if selected period in session exists in diet and it is active
            if (!empty($cart_item->diet->selected_period) &&
                $cart_item->diet->status == 'active' &&
                $cart_item->diet->selected_period->status == 'active' &&
                $cart_item->diet->selected_period->price > 0
            ) {
                $available_diets[] = $cart_item->diet;
            }
        }
        return collect($available_diets);
    }

    public function getAllPaymentGateways($just_active = true, $filter_data = false)
    {
        $payment_gateway = PaymentGateway::orderBy('sort', 'DESC');
        if ($just_active) {
            $payment_gateway->where(['status' => 'active']);
        }

        if ($filter_data) {
            // filter data to protect sensitive data (token, username, ...) and do not pass them to view
            $payment_gateway->select([
                'id',
                'title',
                'description',
                'status',
                'image',
                'sort',
            ]);
        }
        return $payment_gateway->get();
    }

    public function payIPG($gateway_id)
    {
        $payment = new Payment\Payment($gateway_id);
        $tid = $payment->init();

        return $payment->goToWebGate($tid);
    }

    public function IPGCallback($encoded_gateway_id, $encoded_invoice_id, Request $request)
    {
        $gateway_id = decrypt($encoded_gateway_id);
        $invoice_id = decrypt($encoded_invoice_id);
        Log::info("online payment IPGCallback before new Payment\Payment invoice_id: " . $invoice_id . " request: " . json_encode($request->input()));
        $payment = new Payment\Payment($gateway_id, $invoice_id, $request);
        Log::info("online payment IPGCallback before new Payment\Payment invoice_id: " . $invoice_id);

        $payment->callback();
        $invoice = $payment->getInvoice();
        if ($invoice->statue == GeneralConstants::TRANSACTION_VERIFIED) {
            // if transaction is verified, lets reset cart
            DietHelper::resetSessionDiets();
        }
//        return $invoice;
        $backpack = [
            'is_test' => true,
            'invoice_id' => $invoice->id
        ];
        AdminNewOrderJob::dispatchNow($backpack);
        return view('dashboard.payment.payment-result')->with(compact('invoice'));
    }
}
