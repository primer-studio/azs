<div class="kt-portlet">
    <div class="kt-portlet__body">
        @AjaxForm(['form_id' => 'contact-us-request-form', 'is_update' => isset($contact_us_request) ])@endAjaxForm

        <form action="{{ isset($contact_us_request) ? route('panel.contact-us-requests.update', ['contact_us_request' => $contact_us_request->id]) : route('panel.contact_us_requests.store') }}"
              id="contact-us-request-form" method="post">
            @csrf

            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>@lang('validation.attributes.name')</label>
                        <input name="title" type="text" readonly class="form-control" @isset($contact_us_request->name) value="{{ $contact_us_request->name }}" @endisset>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>@lang('validation.attributes.mobile_number')</label>
                        <input name="unit" type="text" readonly class="form-control" @isset($contact_us_request->mobile_number) value="{{ $contact_us_request->mobile_number }}" @endisset>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>@lang('validation.attributes.date')</label>
                        <input  type="text" readonly class="form-control dir-ltr" @isset($contact_us_request->created_at) value="{{ jdateComplete($contact_us_request->created_at) }}" @endisset>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>@lang('validation.attributes.message')</label>
                        <textarea name="message" readonly  class="form-control" >@isset($contact_us_request->message){{ $contact_us_request->message }}@endisset</textarea>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>@lang('validation.attributes.response')</label>
                        <textarea name="response"  class="form-control" >@isset($contact_us_request->response){{ $contact_us_request->response }}@endisset</textarea>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button class="submit-button btn btn-success" type="submit">@lang('general.submit') <i class="la la-floppy-o p-0"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>


