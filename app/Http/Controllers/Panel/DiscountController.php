<?php

namespace App\Http\Controllers\Panel;

use App\Constants\GeneralConstants;
use App\Discount;
use App\Events\VerifiedInvoiceEvent;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceItem;
use Facades\App\Libraries\InvoiceHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
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
//        $this->middleware('can:change_invoice');
    }

    public function create(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('panel.main')->nest('content', 'panel.discounts.add');
        } elseif ($request->isMethod('POST')) {
            $request->validate([
                'title' => 'required|string|min:1',
                'type' => 'required|string',
                'hash' =>  'required|string|min:3',
                'amount' =>  'required|numeric',
            ]);
            $is_active = ($request->has('is_active')) ? 1 : 0;
            $is_otu = ($request->has('is_otu')) ? 1 : 0;
            $discount = new Discount();
            $discount->title = $request['title'];
            $discount->type = $request['type'];
            $discount->hash = $request['hash'];
            $discount->amount = $request['amount'];
            $discount->is_active = $is_active;
            $discount->is_otu = $is_otu;
            $discount->options = '{}';
            $discount->save();

            return redirect()->route('panel.discounts.edit', $discount->id);
        } else {
            return abort(403, 'Method not allowed');
        }
    }
    public function edit(Request $request, $id)
    {
        if ($request->isMethod('GET')) {
            $discount = Discount::findOrFail($id);
            return view('panel.main')->nest('content', 'panel.discounts.edit', compact('discount'));
        } elseif ($request->isMethod('POST')) {
            $request->validate([
                'title' => 'required|string|min:1',
                'type' => 'required|string',
                'hash' =>  'required|string|min:3',
                'amount' =>  'required|numeric',
            ]);
            $is_active = ($request->has('is_active')) ? 1 : 0;
            $is_otu = ($request->has('is_otu')) ? 1 : 0;
            $discount = Discount::findOrFail($id)->update([
               'title' => $request['title'],
               'type' => $request['type'],
               'hash' => $request['hash'],
               'amount' => $request['amount'],
               'is_active' => $is_active,
               'is_otu' => $is_otu,

            ]);

            return redirect()->route('panel.discounts.edit', $id);
        } else {
            return abort(403, 'Method not allowed');
        }
    }

    public function index()
    {
        $discounts = Discount::latest()->paginate(10);
        return view('panel.main')->nest('content', 'panel.discounts.list', compact('discounts'));
    }

    public function update($invoice_id, Request $request)
    {
//        // TODO[back-end]: validate fields, this is temporary
//        $rules = $this->rules;
//        $invoice = Invoice::findOrFail($invoice_id);
//        if ($invoice->status == GeneralConstants::TRANSACTION_VERIFIED && $request->has('status')) {
//            return setErrorResponse(__('validation.custom.verified_transaction_can_not_be_changed'));
//        }
//
//        $validator = Validator::make($request->all(), $rules);
//        if ($validator->fails()) {
//            return setErrorResponse($validator->messages());
//        }
//        $data = $request->only($this->saveRequestInputs);
//        $invoice_status_before_update = $invoice->status;
//        $is_paid = (isset($data['status']) && $data['status'] == GeneralConstants::TRANSACTION_VERIFIED && $invoice_status_before_update != GeneralConstants::TRANSACTION_VERIFIED);
//
//        // set paid at
//        if ($is_paid) {
//            $data['paid_at'] = now();
//        }
//
//        $invoice->update($data);
//        // check if the invoice's is changing and the new status is 'verified' fire an event to update cache
//        if ($is_paid) {
//            // remember that invoice status will be checked in VerifiedInvoiceListener and it should be verified to set orders and etc ...
//            event(new VerifiedInvoiceEvent($invoice));
//        }
//        return setSuccessfulResponse(route('panel.invoices.edit', ['invoice' => $invoice->id]));
    }

    public function recheckInvoiceItem($invoice_item_id, Request $request)
    {
//        $invoice_item = InvoiceItem::findOrFail($invoice_item_id);
//        $diet = $invoice_item->diet;
//        $profile = $invoice_item->invoice->profile;
//        return InvoiceHelper::setInvoiceItemOrder($invoice_item, $profile, $diet, false);
    }
}
