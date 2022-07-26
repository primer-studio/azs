<?php

namespace App\Http\Controllers;

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
        return view('dashboard.main')->nest('content', 'dashboard.home');
    }

    public function notifications()
    {
        $profile = ProfileHelper::getCurrentProfile();
        return view('dashboard.main')->nest('content', 'dashboard.notifications.list', compact('profile'));
    }
}
