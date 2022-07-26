<?php

namespace App\Http\Controllers\Panel;

use App\Events\ContactUsRequestStoredEvent;
use App\ContactUsRequest;
use App\Http\Controllers\Controller;
use App\Rules\ValidMobileNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    public $saveRequestInputs = [
        'name',
        'mobile_number',
        'message',
        'response',
    ];

    public $rules = [];

    public function __construct()
    {
        $this->middleware("can:change_contact_us_request");
        $this->rules = [
            'name' => ['max:100'],
            'mobile_number' => [new ValidMobileNumber()],
            'message' => ['min:10', 'max:1000'],
            'response' => ['min:5', 'max:1000'],
        ];
    }

    public function edit($id)
    {
        $contact_us_request = ContactUsRequest::findOrFail($id);
        if (!$contact_us_request->seen) {
            // mark as seen
            $contact_us_request->update([
                'seen' => true
            ]);
        }
        return view('panel.main')->nest('content', 'panel.contact-us-requests.set', compact('contact_us_request'));
    }

    public function index()
    {
        $contact_us_requests = ContactUsRequest::orderBy('created_at', 'DESC')->paginate(10);
        return view('panel.main')->nest('content', 'panel.contact-us-requests.list', compact('contact_us_requests'));
    }

    public function update($contact_us_request_id, Request $request)
    {
        // TODO[back-end]: validate fields, this is temporary
        $rules = $this->rules;
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only($this->saveRequestInputs);
        $contact_us_request = ContactUsRequest::findOrFail($contact_us_request_id);
        $contact_us_request->update($data);
        // event(new ContactUsRequestStoredEvent($contact_us_request));
        return setSuccessfulResponse(route('panel.contact-us-requests.edit', ['contact_us_request' => $contact_us_request->id]));
    }
}
