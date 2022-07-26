<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Events\OfflinePaymentRegisteredEvent;
use App\Exceptions\StopException;
use App\Libraries\InvoiceHelper;
use App\Rules\ValidJalaliDate;
use Facades\App\Libraries\CartHelper;
use Facades\App\Libraries\DietHelper;
use Facades\App\Libraries\PaymentGatewayHelper;
use Facades\App\Libraries\ProfileHelper;
use App\OfflinePayment;
use Facades\App\Libraries\QuestionHelper;
use Facades\App\Libraries\SettingHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PaymentController extends Controller
{
    # =========================  offline payment - start ========================= #
    public function index()
    {
        $offline_payments = OfflinePayment::where([
            'profile_id' => ProfileHelper::getCurrentProfile()->id
        ])->orderBy('updated_at', 'DESC')->get();
        return view('dashboard.main')->nest('content', 'dashboard.payment.offline.list', compact('offline_payments'));
    }

    public function showRegisterOfflinePayment()
    {
        return view('dashboard.main')->nest('content', 'dashboard.payment.offline.register');
    }

    public function registerOfflinePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => "required|numeric|between:1,1000000000000",
            'payment_date' => ["required", "max:50", 'jdate'],
            'payment_type' => ["required", "max:50", 'in:' . implode(",", OfflinePayment::VALID_PAYMENT_TYPES)],
            'tracking_number' => "required|max:50",
            'card_number' => "required|max:50",
        ]);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only([
            'amount',
            'payment_date',
            'payment_type',
            'tracking_number',
            'card_number',
        ]);
        $data['profile_id'] = ProfileHelper::getCurrentProfile()->id;
        $data['payment_date'] = jdateToTimestamp($request->input('payment_date'));
        $offline_payment = OfflinePayment::create($data);
        event(new OfflinePaymentRegisteredEvent($offline_payment));
        return setSuccessfulResponse(route('dashboard.invoices.index'));
    }

    public function proformaInvoice($json = false)
    {
        $profile = ProfileHelper::getCurrentProfile();
        $payment_gateways = PaymentGatewayHelper::getAllPaymentGateways(true, true);
        // return $payment_gateways;
        $diets = PaymentGatewayHelper::getAvailableDietsToPayForCurrentProfile();

        $settings = SettingHelper::getSettings();
        $vat_percentage = $settings->vat_percentage;
        $total_diets_amount = 0;

        foreach ($diets as $diet) {
            /**
             * check if user_can_pay_without_answering_diet_required_questions settings is false
             * also there are pending_questions for the diet, redirect user to the diet's first page to answer the questions
             * while showing him thr proper message: you should enter answer these question: height, weigh. ...
             */
            $pending_questions = ProfileHelper::profileAnsweredDietRequiredQuestions($profile, $diet, $diet->selected_period->period);
            if (
                !$settings->user_can_pay_without_answering_diet_required_questions &&
                $pending_questions !== false && $pending_questions->count()
            ) {
                $questions_titles = $pending_questions->map(function ($question) {
                    return $question->title;
                })->implode(', ');
                flashError(__('general.required_question_must_be_answered_before_payment', ['diet_title' => $diet->title, 'questions_titles' => $questions_titles]));
                return redirect(route('dashboard.diets.show-step', ['slug' => $diet->slug, 'period' => $diet->selected_period->period, 'step_number' => 1]));
            }

            // update cart data
            CartHelper::attachDietToProfile($diet->id, $diet->selected_period->period, null, true, $profile->id, route('dashboard.proforma-invoice', [], false));
            $total_diets_amount += $diet->selected_period->price;
        }

        if (empty($total_diets_amount)) {
            // TODO[back-end]: fix label
            throw new StopException('invoice total amount is 0', __("general.invalid_invoice_total_amount"));
        }

        // $total_amount = $total_diets_amount + VAT
        $vat = ($vat_percentage / 100) * $total_diets_amount;
        $total_amount = $total_diets_amount + $vat;

        if ($json) {
            return (object) [
                'status' => 200,
                'total' => $total_amount = $total_diets_amount + $vat
            ];
        }

        return view('dashboard.main')->nest('content', 'dashboard.payment.proforma-invoice', compact('profile', 'diets', 'payment_gateways', 'total_diets_amount', 'vat', 'total_amount'));
    }

    public function InvoiceSetDiscount(Request $request)
    {
        $total = $this->proformaInvoice(true)->total;


        $discount_code = Discount::where('hash', $request['code'])->first();


        $user_used_otu_before = 0;
        if ($discount_code != null && $discount_code->is_otu) {
            $user_used_otu_before = DB::table('user_discounts')->where([
                'profile_id' => ProfileHelper::getCurrentProfile()->id,
                'discount_id' => $discount_code->id,
            ])->count();
        }

        if (!$discount_code || ($discount_code != false && !$discount_code->is_active) || $user_used_otu_before != 0 ) {
            return response([
                'user_used_once' => $user_used_otu_before,
                'status' => 400,
                'message' => 'کد موردنظر معتبر نیست.',
                'log' => 'otubeforeonce',
                'timestamp' => time(),
                'new_total' => money($total, true)
            ]);
        }

        if ($discount_code->is_active) {
            if ($discount_code->type == 'simple') {
//                die('simple');
                $new_total = money($total - (float) $discount_code->amount, true);
            } elseif ($discount_code->type == 'percentage') {
//                die('percentage');
                $new_total = money($total - ($total * ($discount_code->amount/100)), true);
            } else {
                $new_total = money($total, true);
            }
        }

        if ($discount_code->is_active) {
            $otu = DB::table('user_discounts')->insert([
                'invoice_id' => 0,
                'profile_id' => ProfileHelper::getCurrentProfile()->id,
                'discount_id' => $discount_code->id,
                'is_valid' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        /**
         * here we set a relation between user invoice and invoice discountes,
         * and in the payment gateway class we check for exiting discount to renew the total amount for gateway.
         */
        return response([
            'discount' => $discount_code,
            'status' => 200,
            'message' => 'با موفقیت اعمال گردید.',
            'timestamp' => time(),
            'new_total' => (isset($new_total)) ? $new_total : money($total, true)
        ]);

        /**
         *  1- making the discount codes model
         *  2- bind the users code use times to orders
         *  3- subtract price from total inside the ipg controller methods
         *  4- ready to rock and roll
         * */

    }


    public function payIPG(Request $request)
    {
        $request->validate([
            'payment_gateway' => 'required|numeric'
        ]);
        return PaymentGatewayHelper::payIPG($request->payment_gateway);
    }

    public function IPGCallback($encoded_gateway_id, $encoded_invoice_id, Request $request)
    {
        return PaymentGatewayHelper::IPGCallback($encoded_gateway_id, $encoded_invoice_id, $request);
    }

    public function payWithDietSlug($slug, $period, $step_number)
    {
        $diet = DietHelper::getDietBySlug($slug);
        // put data in cart
        CartHelper::attachDietToCurrentProfile($diet->id, $period, $step_number, true, route('dashboard.proforma-invoice', false));
        return redirect(route('dashboard.proforma-invoice'));
    }

    /**
     * remove by cart item id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeDietFromCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_item_id' => 'required',
        ]);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        // remove diet from session
        CartHelper::removeDietFromCurrentProfile($request->input(['cart_item_id']));
        return setSuccessfulResponse('reload');
    }

    /**
     * remove by diet id and period
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function proformaRemoveDietFromCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'diet_id' => 'required',
            'period' => 'required',
        ]);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        // remove diet from session
        $data = $request->only(['diet_id', 'period']);
        CartHelper::removeDietFromCurrentProfileByDetails($data['diet_id'], $data['period']);
        return setSuccessfulResponse('reload');
    }
    # =========================  offline payment -  end  ========================= #
}
