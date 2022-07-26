<?php

namespace App\Http\Controllers;

use Facades\App\Libraries\ProfileHelper;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = ProfileHelper::getCurrentProfile()->orders()->with('invoiceItem')->paginate(10);
        return view('dashboard.main')->nest('content', 'dashboard.orders.list', compact('orders'));
    }

    public function show($order_id)
    {
        $order = ProfileHelper::getCurrentProfile()->orders()->findOrFail($order_id);
        return view('dashboard.main')->nest('content', 'dashboard.orders.show', compact('order'));
    }

    public function lastOrder()
    {
        $order = ProfileHelper::getCurrentProfile()->orders()->orderBy("created_at", 'DESC')->first();
        return view('dashboard.main')->nest('content', 'dashboard.orders.show', compact('order'));
    }
}
