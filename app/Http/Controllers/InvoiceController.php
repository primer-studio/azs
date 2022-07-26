<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceItem;
use Facades\App\Libraries\ProfileHelper;
use Facades\App\Libraries\InvoiceHelper;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = ProfileHelper::getCurrentProfile()->invoices()->orderBy('created_at', 'DESC')->paginate(10);
        return view('dashboard.main')->nest('content', 'dashboard.invoices.list', compact('invoices'));
    }

    public function show($invoice_id)
    {
        $invoice = ProfileHelper::getCurrentProfile()->invoices()->with(['profile.user', 'invoiceItems.order', 'offlinePayment', 'paymentGateway'])->findOrFail($invoice_id);
        return view('dashboard.main')->nest('content', 'dashboard.invoices.show', compact('invoice'));
    }

    public function recheckInvoiceItem($invoice_item_id, Request $request)
    {
        $invoice_item = InvoiceItem::findOrFail($invoice_item_id);
        $diet = $invoice_item->diet;
        $profile = $invoice_item->invoice->profile;
        return InvoiceHelper::setInvoiceItemOrder($invoice_item, $profile, $diet, false, true);
    }
}
