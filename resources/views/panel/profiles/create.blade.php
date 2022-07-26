<div class="kt-portlet">
    <div class="kt-portlet__body">

        @AjaxForm(['form_id' => 'profile-form', 'is_update' => false ])@endAjaxForm

        <form action="{{  route('panel.profiles.store') }}"
              id="profile-form" method="post">
            @csrf

            <div class="form-group">
                <label for="name">@lang('validation.attributes.mobile')</label>
                <input type="text" name="mobile_number" class="form-control">
            </div>

            <div class="form-group">
                <label for="name">@lang('validation.attributes.name')</label>
                <input name="name" type="text" class="form-control" id="name">
            </div>

            <div class="form-group">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button class="submit-button btn btn-success" type="submit">@lang('general.submit') <i
                            class="la la-floppy-o p-0"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
