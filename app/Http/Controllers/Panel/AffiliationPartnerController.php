<?php

namespace App\Http\Controllers\Panel;

use App\Constants\GeneralConstants;
use App\Events\Affiliation_partnerStoredEvent;
use App\Http\Controllers\Controller;
use App\AffiliationPartner;
use App\Rules\ValidMobileNumber;
use App\Rules\ValidUsername;
use Facades\App\Libraries\UserHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Facades\App\Libraries\AffiliationPartnerHelper;

class AffiliationPartnerController extends Controller
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
        return view('panel.main')->nest('content', 'panel.affiliation-partners.set');
    }

    public function edit($id)
    {
        $affiliation_partner = AffiliationPartner::findOrFail($id);
        $affiliation_invoice_summary = AffiliationPartnerHelper::getSinglePartnersAffiliationInvoiceSummary($id);
        return view('panel.main')->nest('content', 'panel.affiliation-partners.set', compact('affiliation_partner', 'affiliation_invoice_summary'));
    }

    public function index(Request $request)
    {
        UserHelper::sanitizeMobileNumber($request);
        $query = AffiliationPartner::orderBy('created_at', 'DESC');
        $search_items = collect($request->only([
            'name',
            'mobile_number',
            'username',
            'card_number',
            'status'
        ]))->reject(function ($item) {
            return empty($item);
        })->toArray();

        $search_array = [];

        if (!empty($search_items['name'])) {
            $search_array[] = ['name', 'like', "%" . convertArabicStringToPersian($search_items['name']) . "%"];
        }
        if (!empty($search_items['username'])) {
            $search_array[] = ['username', 'like', "%" . $search_items['username'] . "%"];
        }
        if (!empty($search_items['mobile_number'])) {
            $search_array[] = ['mobile_number', 'like', "%" . $search_items['mobile_number'] . "%"];
        }
        if (!empty($search_items['card_number'])) {
            $search_array[] = ['card_number', 'like', "%" . $search_items['card_number'] . "%"];
        }

        if (!empty($search_items['status'])) {
            $search_array[] = ['status', $search_items['status']];
        }

        if (!empty($search_array)) {
            $query = $query->where($search_array);
        }
        $affiliation_partners = $query->paginate(10)->appends($search_items);
        $affiliation_invoice_summary = AffiliationPartnerHelper::getMultiPartnersAffiliationInvoiceSummary($affiliation_partners->pluck('id'));
        return view('panel.main')->nest('content', 'panel.affiliation-partners.list', compact('affiliation_partners', 'affiliation_invoice_summary'));
    }

    public function update($affiliation_partner_id, Request $request)
    {
        $affiliation_partner = AffiliationPartner::findOrFail($affiliation_partner_id);
        UserHelper::sanitizeMobileNumber($request);
        // TODO[back-end]: validate fields, this is temporary
        $rules = $this->rules;
        if ($request->has('mobile_number') && !empty($request->input('mobile_number')) && $request->input('mobile_number') != $affiliation_partner->mobile_number) {
            $rules['mobile_number'][] = 'unique:affiliation_partners';
        }
        if ($request->has('username') && $request->input('username') != $affiliation_partner->username) {
            $rules['username'][] = 'unique:affiliation_partners';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only($this->saveRequestInputs);
        if (empty($data['mobile_number'])) {
            $data['mobile_number'] = null;
        }
        $affiliation_partner->update($data);
//        event(new Affiliation_partnerStoredEvent($affiliation_partner));
        return setSuccessfulResponse(route('panel.affiliation-partners.edit', ['affiliation_partner' => $affiliation_partner->id]));
    }

    public function store(Request $request)
    {
        UserHelper::sanitizeMobileNumber($request);
        // TODO[back-end]: validate fields, this is temporary
        $rules = $this->rules;
        $rules['name'][] = "required";
        if (!empty($request->input('mobile_number'))) {
            $rules['mobile_number'][] = 'unique:affiliation_partners';
        }
        $rules['username'][] = 'unique:affiliation_partners';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only($this->saveRequestInputs);
        if (empty($data['mobile_number'])) {
            $data['mobile_number'] = null;
        }
        $affiliation_partner = AffiliationPartner::create($data);
//        event(new Affiliation_partnerStoredEvent($affiliation_partner));
        return setSuccessfulResponse(route('panel.affiliation-partners.edit', ['affiliation_partner' => $affiliation_partner->id]));
    }
}
