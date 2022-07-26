<?php


namespace App\Libraries;


use App\Constants\GeneralConstants;
use App\Events\InvoiceStoredEvent;
use App\Events\OrderCreatedEvent;
use App\Events\PendingInvoiceItemEvent;
use App\Events\VerifiedInvoiceEvent;
use App\Exceptions\StopException;
use App\Invoice;
use App\InvoiceItem;
use App\Order;
use Carbon\Carbon;
use Facades\App\Libraries\PaymentGatewayHelper;
use Facades\App\Libraries\SettingHelper;
use Facades\App\Libraries\ProfileHelper;
use Facades\App\Libraries\QuestionHelper;


class InvoiceHelper
{
    public function createInvoiceByCartForCurrentProfile($payment_way = null, $ipg_gateway_id = null, $offline_payment_id = null)
    {
        $profile = ProfileHelper::getCurrentProfile();
        if (empty($profile)) {
            throw new StopException('getCurrentProfile is empty', __("getCurrentProfile is empty"));
        }
        return $this->createInvoiceByCart($profile, $payment_way, $ipg_gateway_id, $offline_payment_id);
    }

    public function createInvoiceByCart($profile, $payment_way = null, $ipg_gateway_id = null, $offline_payment_id = null)
    {
        $diets = PaymentGatewayHelper::getAvailableDietsToPay($profile->id);
        if ($diets->count() < 1) {
            // TODO[back-end]: fix label
            throw new StopException('there is no diet in cart (session)', __("there is no diet to create new invoice"));
        }
        return $this->createInvoice($profile, $diets, $payment_way, $ipg_gateway_id, $offline_payment_id);
    }

    public function createInvoice($profile, $diets, $payment_way = null, $ipg_gateway_id = null, $offline_payment_id = null)
    {
        $settings = SettingHelper::getSettings();
        $vat_percentage = $settings->vat_percentage;

        if ($vat_percentage < 0) {
            // TODO[back-end]: fix label
            throw new StopException('vat_percentage is negative', __("general.there_was_a_problem"));
        }


        $total_diets_amount = 0;
        foreach ($diets as $diet) {
            $total_diets_amount += $diet->selected_period->price;
        }


        if (empty($total_diets_amount)) {
            // TODO[back-end]: fix label
            throw new StopException('invoice total amount is 0', __("general.invalid_invoice_total_amount"));
        }

        // $total_amount = $total_diets_amount + VAT
        $total_amount = $total_diets_amount + (($vat_percentage / 100) * $total_diets_amount);

        $invoice = Invoice::create([
            'profile_id' => $profile->id,
            'total_amount' => $total_amount,
            'total_amount_without_vat' => $total_diets_amount,
            'status' => GeneralConstants::TRANSACTION_STARTED,
            'vat' => $vat_percentage,
            'payment_way' => $payment_way,
            'ipg_gateway_id' => $ipg_gateway_id,
            'offline_payment_id' => $offline_payment_id,
        ]);

        // insert invoice items
        $invoice_items = [];
        $now = new \DateTime();
        foreach ($diets as $diet) {
            $invoice_items[] = [
                'invoice_id' => $invoice->id,
                'price' => $diet->selected_period->price,
                'diet_period' => $diet->selected_period->period,
                'diet_id' => $diet->id,
                'quantity' => 1,
                'diet_registered_data' => json_encode(
                    $diet->only(['id', 'title', 'duration_in_day', 'status', 'periods', 'selected_period', 'created_at', 'updated_at'])
                ),
                'created_at' => $now,
                'updated_at' => $now
            ];
        }

        InvoiceItem::insert($invoice_items);
        // save this action's log for the profile
        $profile_log_data = $invoice;
        $profile_log_data['invoice_items'] = $invoice_items;
        event(new InvoiceStoredEvent($invoice, $profile->id, 'array', $profile_log_data));
        return $invoice;
    }

    public function updateInvoice($invoice_id, array $data)
    {
        $invoice = Invoice::find($invoice_id);
        $invoice_status_before_update = $invoice->status;

        $is_paid = (isset($data['status']) && $data['status'] == GeneralConstants::TRANSACTION_VERIFIED && $invoice_status_before_update != GeneralConstants::TRANSACTION_VERIFIED);

        // set paid at
        if ($is_paid) {
            $data['paid_at'] = now();
        }

        $invoice->update($data);
        // check if the invoice's is changing and the new status is 'verified' fire an event to update cache
        if ($is_paid) {
            event(new VerifiedInvoiceEvent($invoice));
        }
        if (empty($invoice)) {
            throw new StopException("the invoice not found: $invoice_id", "the invoice not found");
        }
        return $invoice;
    }

    public function updateInvoiceItem($invoice_item_id, $data)
    {
        $update_array = [];
        foreach ($data as $key => $value) {
            if (($key == 'pending_questions')) {
                foreach ($value as $pending_question_key => $pending_question_value) {
                    $update_array["pending_questions->$pending_question_value"] = time();
                }
            } else {
                $update_array[$key] = $value;
            }
        }
        $invoice_item = InvoiceItem::findOrFail($invoice_item_id);
        $invoice_item->update($update_array);
        return $invoice_item;
    }

    /**
     * this method checks for pending questions (and it will fire event(new PendingInvoiceItemEvent($invoice_item)) if you set $fire_pending_invoice_item_event true and there is any pending question)
     * and if everything is ok, it will set order for the invoice item then fire event(new OrderCreatedEvent($order))
     * @param $invoice_item
     * @param $profile
     * @param $diet
     * @param bool $fire_pending_invoice_item_event
     * @param bool $is_dashboard
     * @return \Illuminate\Http\JsonResponse
     */
    public function setInvoiceItemOrder($invoice_item, $profile, $diet, $fire_pending_invoice_item_event = true, $is_dashboard = false)
    {
        $invoice = $invoice_item->invoice;
        // check invoice is paid?
        if ($invoice->status != GeneralConstants::TRANSACTION_VERIFIED) {
            return setErrorResponse(__('invoice.invoice_is_not_paid'));
        }
        $pending_questions = ProfileHelper::profileAnsweredDietRequiredQuestions($profile, $diet, $invoice_item->diet_period);
        if ($pending_questions !== false && $pending_questions->count()) {
            $invoice_item->update(
                [
                    "pending_questions" => json_encode($pending_questions->pluck("short_name"))
                ]
            );

            if ($fire_pending_invoice_item_event) {
                // fire event to send notifications and etc
                event(new PendingInvoiceItemEvent($invoice_item));
            }
            return setErrorResponse($this->translateInvoiceItemStatus($invoice_item));
        }

        // clear invoice item's pending_questions if it is not empty
        if (!empty($invoice_item->pending_questions)) {
            $invoice_item->update(
                [
                    "pending_questions" => null
                ]
            );
        }

        // check if order was registered before?
        $check = Order::where([
            'profile_id' => $profile->id,
            'invoice_item_id' => $invoice_item->id,
        ])->exists();

        if ($check) {
            return setErrorResponse(__('invoice.order_as_been_registered_before'));
        }

        $order = $invoice_item->order()->create(
            [
                'profile_id' => $profile->id,
                'duration_in_day' => $invoice_item->diet_registered_data->selected_period->duration_in_day,
            ]
        );

        // fire event to send notifications and etc
        event(new OrderCreatedEvent($order));
        $redirect_url = $is_dashboard ? route('dashboard.invoices.show', ['invoice' => $invoice_item->invoice_id]) : route('panel.invoices.edit', ['invoice' => $invoice_item->invoice_id]);
        return setSuccessfulResponse($redirect_url);
    }

    /**
     * this method passes the user friendly invoice item's status
     * @param $invoice_item
     * @param string $delimiter
     * @return array|string|null
     */
    public function translateInvoiceItemStatus($invoice_item, $delimiter = "، ")
    {
        if (empty($invoice_item->pending_questions)) {
            return __('general.ready_to_be_registered');
        } else {
            $questions = QuestionHelper::getQuestionsByShortName(collect($invoice_item->pending_questions));
            $questions_titles = $questions->implode('title', $delimiter);
            return __('invoice.invoice_item_pending_profile_information',
                [
                    'pending_questions' => $questions_titles
                ]);
        }
    }

    /**
     * this method passes the user friendly invoice status
     * @param $invoice_status
     * @return array|string|null
     */
    public function translateInvoiceStatus($invoice_status)
    {
        switch ($invoice_status) {
            case GeneralConstants::TRANSACTION_STARTED :
                $translated = __('invoice.TRANSACTION_STARTED');
                break;
            case GeneralConstants::TRANSACTION_WEB_GATE :
                $translated = __('invoice.TRANSACTION_WEB_GATE');
                break;
            case GeneralConstants::TRANSACTION_CALLBACK :
                $translated = __('invoice.TRANSACTION_CALLBACK');
                break;
            case GeneralConstants::TRANSACTION_VERIFIED :
                $translated = __('invoice.TRANSACTION_VERIFIED');
                break;
            case GeneralConstants::TRANSACTION_AMOUNT_MISMATCH_ON_VERIFY :
                $translated = __('invoice.TRANSACTION_AMOUNT_MISMATCH_ON_VERIFY');
                break;
            case GeneralConstants::TRANSACTION_VERIFY_DATA_NOT_CORRECT :
                $translated = __('invoice.TRANSACTION_VERIFY_DATA_NOT_CORRECT');
                break;

            case GeneralConstants::TRANSACTION_CALLBACK_DATA_NOT_CORRECT :
                $translated = __('invoice.TRANSACTION_CALLBACK_DATA_NOT_CORRECT');
                break;
            default:
                $translated = __('invoice.TRANSACTION_CALLBACK_DATA_NOT_CORRECT');
        }
        return $translated;
    }

    /**
     *  this method passes the user friendly offline payment's status
     * @param $offline_payment
     * @return array|string|null
     */
    public function trnaslateOfflinePaymentStatus($offline_payment)
    {
        switch ($offline_payment->payment_type) {
            case GeneralConstants::OFFLINE_PAYMENT_TYPE_CARD_TO_CARD:
                return __('general.card_to_card');
                break;
            case GeneralConstants::OFFLINE_PAYMENT_TYPE_DEPOSIT_BY_BANK_RECEIPT:
                return __('general.deposit_by_bank_receipt');
                break;
            default:
                return $offline_payment->payment_type;
        }
    }


    public function translatePaymentWay($payment_way)
    {
        $translated = $payment_way;
        if ($payment_way == 'ipg') {
            $translated = __('invoice.ipg');
        }
        if ($payment_way == 'offline') {
            $translated = __('invoice.offline');
        }
        if ($payment_way == 'manual_by_admin') {
            $translated = __('invoice.manual_by_admin');
        }
        return $translated;
    }
}
