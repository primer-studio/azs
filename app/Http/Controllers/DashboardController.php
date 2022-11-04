<?php

namespace App\Http\Controllers;

use App\Diet;
use App\Libraries\UserHelper;
use Facades\App\Libraries\ProfileHelper;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders = ProfileHelper::getCurrentProfile()->orders()->latest()->with('invoiceItem')->paginate(3);
        return view('dashboard.main')->nest('content', 'dashboard.home', compact('orders'));
    }

    public function notifications()
    {
        $profile = ProfileHelper::getCurrentProfile();
        return view('dashboard.main')->nest('content', 'dashboard.notifications.list', compact('profile'));
    }

    public function assets()
    {

    }
}
