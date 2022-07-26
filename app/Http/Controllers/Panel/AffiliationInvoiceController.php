<?php

namespace App\Http\Controllers\Panel;

use App\AffiliationInvoice;
use App\Constants\GeneralConstants;
use App\Http\Controllers\Controller;
use App\Rules\ValidMobileNumber;
use App\Rules\ValidUsername;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AffiliationInvoiceController extends Controller
{
    public $saveRequestInputs = [
        'name',
        'mobile_number',
        'username',
        'commission_rate',
        'card_number',
        'description',
        'status',
    ];

    public $rules = [];

    public function __construct()
    {
        $this->middleware('can:change_affiliation_partner');
        $this->rules = [
            'name' => ['string', 'max:255'],
            'mobile_number' => [new ValidMobileNumber()],
            'username' => [new ValidUsername()],
            'commission_rate' => ['numeric', 'min:0', 'max:100'],
        ];
    }

    public function create()
    {
        return view('panel.main')->nest('content', 'panel.affiliation-invoices.set');
    }

    public function edit($id)
    {
        $affiliation_invoice = AffiliationInvoice::with('affiliationPartner', 'invoice', 'profile')->findOrFail($id);
        return view('panel.main')->nest('content', 'panel.affiliation-invoices.set', compact('affiliation_invoice'));
    }

    public function index(Request $request)
    {
        $query = AffiliationInvoice::with(['affiliationPartner', 'invoice', 'profile'])->orderBy('created_at', 'DESC');
        # =========================  check for search - start ========================= #
        if ($request->has('affiliation_partner_id')) {
            $query = $query->where('affiliation_partner_id', $request->input('affiliation_partner_id'));
        }
        # =========================  check for search -  end  ========================= #

        $affiliation_invoices = $query->paginate(10);
        $affiliation_invoices->appends($request->input());
        return view('panel.main')->nest('content', 'panel.affiliation-invoices.list', compact('affiliation_invoices'));
    }

    public function update($affiliation_invoice_id, Request $request)
    {
        $available_statuses = [
            GeneralConstants::AFFILIATION_INVOICE_STATUS_CHECKOUT,
            GeneralConstants::AFFILIATION_INVOICE_STATUS_CREATED,
        ];
        $validator = Validator::make($request->all(), [
            'status' => 'in:' . implode(',', $available_statuses)
        ]);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only(['status']);
        $affiliation_invoice = AffiliationInvoice::findOrFail($affiliation_invoice_id);
        $affiliation_invoice->update($data);
//        event(new affiliation_invoiceStoredEvent($affiliation_invoice));
        return setSuccessfulResponse(route('panel.affiliation-invoices.edit', ['affiliation_invoice' => $affiliation_invoice->id]));
    }

    public function store(Request $request)
    {
        // TODO[back-end]: validate fields, this is temporary
        $rules = $this->rules;
        $rules['name'][] = "required";
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only($this->saveRequestInputs);
        $affiliation_invoice = AffiliationInvoice::create($data);
//        event(new affiliation_invoiceStoredEvent($affiliation_invoice));
        return setSuccessfulResponse(route('panel.affiliation-invoices.edit', ['affiliation_invoice' => $affiliation_invoice->id]));
    }
}
