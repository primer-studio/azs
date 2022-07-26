<?php


namespace App\Libraries;


use App\CartItem;
use App\Events\CartItemStoredEvent;
use App\Events\CartItemUpdatedEvent;
use Facades\App\Libraries\ProfileHelper;

class CartHelper
{

    public function attachDietToCurrentProfile($diet_id, $period, $step_number = null, $is_proforma_invoice = false, $last_activity_url = null)
    {
        $profile = ProfileHelper::getCurrentProfile();
        return $this->attachDietToProfile($diet_id, $period, $step_number = null, $is_proforma_invoice = false, $profile->id, $last_activity_url = null);
    }

    public function attachDietToProfile($diet_id, $period, $step_number = null, $is_proforma_invoice = false, $profile_id, $last_activity_url = null)
    {
        $profile_log_data = [
            'diet_id' => $diet_id,
            'period' => $period,
            'step_number' => $step_number,
            'is_proforma_invoice' => $is_proforma_invoice,
            'last_activity_url' => $last_activity_url
        ];

        $cart_item = CartItem::where([
            'profile_id' => $profile_id,
            'diet_id' => $diet_id,
            'period' => $period,
        ])->first();

        $data = [
            'profile_id' => $profile_id,
            'diet_id' => $diet_id,
            'period' => $period,
            'step_number' => $step_number,
            'is_proforma_invoice' => $is_proforma_invoice,
            'last_activity_url' => $last_activity_url,
        ];
        if (empty($cart_item)) {
            $cart_item = CartItem::create($data);
            // save this action's log for the profile
            event(new CartItemStoredEvent($cart_item, $profile_id, 'array', $profile_log_data));
        } else {
            $cart_item->update($data);
            // save this action's log for the profile
            event(new CartItemUpdatedEvent($cart_item, $profile_id, 'array', $profile_log_data));
        }

        return $cart_item;
    }

    /**
     * remove by cart item id
     * @param $cart_item_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeDietFromCurrentProfile($cart_item_id)
    {
        $profile = ProfileHelper::getCurrentProfile();
        return $this->removeDietFromProfile($cart_item_id, $profile->id);
    }

    /**
     * remove by cart item id
     * @param $cart_item_id
     * @param $profile_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeDietFromProfile($cart_item_id, $profile_id)
    {
        $cart_item = CartItem::where(
            [
                'id' => $cart_item_id,
                'profile_id' => $profile_id
            ]
        )->first();
        if (empty($cart_item)) {
            return setErrorResponse(__('general.not_found'));
        }
        $cart_item->delete();
        return setSuccessfulResponse('reload', true);
    }

    /**
     * remove by diet_id and period (the combination of diet_id, period, profile_id is unique in database)
     * @param $diet_id
     * @param $period
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeDietFromCurrentProfileByDetails($diet_id, $period)
    {
        $profile = ProfileHelper::getCurrentProfile();
        return $this->removeDietByDetails($diet_id, $period, $profile->id);
    }

    /**
     * remove by diet_id and period (the combination of diet_id, period, profile_id is unique in database)
     * @param $diet_id
     * @param $period
     * @param $profile_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeDietByDetails($diet_id, $period, $profile_id)
    {
        $cart_item = CartItem::where(
            [
                'diet_id' => $diet_id,
                'period' => $period,
                'profile_id' => $profile_id
            ]
        )->first();
        if (empty($cart_item)) {
            return setErrorResponse(__('general.not_found'));
        }
        $cart_item->delete();
        return setSuccessfulResponse('reload', true);
    }

    public function getCurrentProfileCartItems()
    {
        $profile = ProfileHelper::getCurrentProfile();
        return $this->getCartItems($profile->id);
    }

    public function getCartItems($profile_id)
    {
        return CartItem::with('diet')->where([
            "profile_id" => $profile_id
        ])->orderBy('created_at', 'DESC')->get()->map(function ($item) {
            $item->diet->selected_period = $item->diet->periods[$item->period];
            return $item;
        });
    }

}
