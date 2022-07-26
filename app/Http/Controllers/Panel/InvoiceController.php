<?php

namespace App\Http\Controllers\Panel;

use App\Constants\GeneralConstants;
use App\Events\VerifiedInvoiceEvent;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceItem;
use Facades\App\Libraries\InvoiceHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public $saveRequestInputs = [
        'title',
        'description',
        'status',
        'sort',
    ];

    public $rules = [
        'title' => 'string|max:255',
    ];

    public function __construct()
    {
        $this->middleware('can:change_invoice');
    }

    public function edit($id)
    {
        $invoice = Invoice::with(['profile.user', 'invoiceItems.order', 'offlinePayment', 'paymentGateway'])->findOrFail($id);
        return view('panel.main')->nest('content', 'panel.invoices.set', compact('invoice'));
    }

    public function index()
    {
        $invoices = Invoice::with('profile')->orderBy('created_at', 'DESC')->paginate(10);
        return view('panel.main')->nest('content', 'panel.invoices.list', compact('invoices'));
    }

    public function update($invoice_id, Request $request)
    {
        // TODO[back-end]: validate fields, this is temporary
        $rules = $this->rules;
        $invoice = Invoice::findOrFail($invoice_id);
        if ($invoice->status == GeneralConstants::TRANSACTION_VERIFIED && $request->has('status')) {
            return setErrorResponse(__('validation.custom.verified_transaction_can_not_be_changed'));
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only($this->saveRequestInputs);
        $invoice_status_before_update = $invoice->status;
        $is_paid = (isset($data['status']) && $data['status'] == GeneralConstants::TRANSACTION_VERIFIED && $invoice_status_before_update != GeneralConstants::TRANSACTION_VERIFIED);

        // set paid at
        if ($is_paid) {
            $data['paid_at'] = now();
        }

        $invoice->update($data);
        // check if the invoice's is changing and the new status is 'verified' fire an event to update cache
        if ($is_paid) {
            // remember that invoice status will be checked in VerifiedInvoiceListener and it should be verified to set orders and etc ...
            event(new VerifiedInvoiceEvent($invoice));
        }
        return setSuccessfulResponse(route('panel.invoices.edit', ['invoice' => $invoice->id]));
    }

    public function recheckInvoiceItem($invoice_item_id, Request $request)
    {
        $invoice_item = InvoiceItem::findOrFail($invoice_item_id);
        $diet = $invoice_item->diet;
        $profile = $invoice_item->invoice->profile;
        return InvoiceHelper::setInvoiceItemOrder($invoice_item, $profile, $diet, false);
    }
}
