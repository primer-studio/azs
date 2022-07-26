<?php

namespace App\Http\Controllers\Panel;

use App\CartItem;
use App\Constants\GeneralConstants;
use App\Diet;
use App\Http\Controllers\Controller;
use App\Jobs\SendCartSmsReminder;
use Facades\App\Libraries\InvoiceHelper;
use App\Profile;
use Facades\App\Libraries\CartHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware(['can:see_profiles_data'])->only('index');
        $this->middleware(['can:change_profiles_data'])->except('index');
        $this->middleware('can:change_invoice')->only('createInvoiceByCart');
    }

    public function index()
    {
        $cart_items = CartItem::with(['profile.user', 'diet'])->orderBy('updated_at', 'DESC')->paginate(10);
        return view('panel.main')->nest('content', 'panel.cart-items.list', compact('cart_items'));
    }

    public function sendReminderSms($cart_item_id, Request $request)
    {
        $cart_item = CartItem::with('profile.user')->findOrFail($cart_item_id);
        $profile = $cart_item->profile;
        if (empty($profile)) {
            return setErrorResponse(__('general.not_found'));
        }
        $user = $profile->user;
        if (empty($user)) {
            return setErrorResponse(__('general.not_found'));
        }

        if (empty($user->mobile_number)) {
            return setErrorResponse(__('general.mobile_number_is_empty'));
        }

        if (empty($user->mobile_number_verified_at)) {
            return setErrorResponse(__('general.mobile_number_is_not_verified'));
        }
        SendCartSmsReminder::dispatch($user->mobile_number, $profile, true);
        return setSuccessfulResponse('', false, __('general.sms_sent'));
    }

    public function addDietToCart($profile_id, Request $request)
    {
        $profile = Profile::findOrFail($profile_id);
        $validator = Validator::make($request->all(), [
            'diet_id' => 'required',
            'period' => 'required',
        ]);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $diet = Diet::findOrFail($request->input('diet_id'));
        $period = $request->input('period');
        $step_number = 1;
        // put data in cart
        CartHelper::attachDietToProfile($diet->id, $period, $step_number, false, $profile->id, route('dashboard.diets.show-step', ['slug' => $diet->slug, "period" => $period, 'step_number' => $step_number], false));
        return setSuccessfulResponse('reload');
    }


    /**
     * remove by cart item id
     * @param $profile_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeDietFromCart($profile_id, Request $request)
    {
        $profile = Profile::findOrFail($profile_id);
        $validator = Validator::make($request->all(), [
            'cart_item_id' => 'required',
        ]);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        // remove diet from session
        CartHelper::removeDietFromProfile($request->input(['cart_item_id']), $profile->id);
        return setSuccessfulResponse('reload');
    }

    public function createInvoiceByCart($profile_id, Request $request)
    {
        $profile = Profile::findOrFail($profile_id);
        $invoice = InvoiceHelper::createInvoiceByCart($profile, GeneralConstants::PAYMENT_WAY_MANUAL_BY_ADMIN);
        return setSuccessfulResponse(route('panel.invoices.edit', ['invoice' => $invoice->id]));
    }

}
