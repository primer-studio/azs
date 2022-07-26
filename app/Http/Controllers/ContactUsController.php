<?php

namespace App\Http\Controllers;

use App\ContactUsRequest;
use App\Rules\ValidMobileNumber;
use Facades\App\Libraries\UserHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    public function index()
    {
        return view('main')->nest('content', 'contact-us');
    }

    public function store(Request $request)
    {
        UserHelper::sanitizeMobileNumber($request);
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:100'],
            'mobile_number' => ['required', new ValidMobileNumber()],
            'message' => ['required', 'min:10', "max:2000"],
        ]);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $contact_use_request = ContactUsRequest::create($request->only([
            'name', 'mobile_number', 'message'
        ]));

        return setSuccessfulResponse('reload', true, __('general.contact_us_request_saved_message'));
    }
}
