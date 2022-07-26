<?php

namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

class PanelController extends Controller
{
    public function home()
    {
        return view("panel.home");
    }
}
