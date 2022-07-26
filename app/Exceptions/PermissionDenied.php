<?php

namespace App\Exceptions;

use Exception;

class PermissionDenied extends Exception
{
    public function render()
    {
        return view('main')->nest('content', 'exceptions.permission-denied');
    }
}
