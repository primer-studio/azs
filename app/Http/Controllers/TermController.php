<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermController extends Controller
{
    public function index()
    {
        return view('main')->nest('content', 'terms');
    }
}
