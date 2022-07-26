<div class="kt-portlet">
    <div class="kt-portlet__body">
        @AjaxForm(['form_id' => 'settings-form', 'is_update' => isset($settings) ])@endAjaxForm
        <form method="post" action="{{ route('panel.settings.save') }}" id="settings-form">
            @csrf
            <div class="form-group">
                site_title: <input name="site_title" type="text" class="form-control" value="{{ $settings->site_title }}" >
            </div>
            <div class="form-group">
                site_short_title: <input name="site_short_title" type="text" class="form-control" value="{{ $settings->site_short_title }}" >
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input name="register_temp_user" type="checkbox" class="form-check-input" id="register_temp_user" @if( !empty($settings->register_temp_user)) checked @endif>
                    <label class="form-check-label" for="register_temp_user">register temp user</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input name="user_can_skip_profile_questions" type="checkbox" class="form-check-input" id="user_can_skip_profile_questions" @if( !empty($settings->user_can_skip_profile_questions)) checked @endif>
                    <label class="form-check-label" for="user_can_skip_profile_questions">user can skip profile questions</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input name="user_must_pay_without_answering_diet_required_questions" type="checkbox" class="form-check-input" id="user_must_pay_without_answering_diet_required_questions" @if( !empty($settings->user_must_pay_without_answering_diet_required_questions)) checked @endif>
                    <label class="form-check-label" for="user_must_pay_without_answering_diet_required_questions">user must pay without answering diet required questions</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input name="user_can_pay_without_answering_diet_required_questions" type="checkbox" class="form-check-input" id="user_can_pay_without_answering_diet_required_questions" @if( !empty($settings->user_can_pay_without_answering_diet_required_questions)) checked @endif>
                    <label class="form-check-label" for="user_can_pay_without_answering_diet_required_questions">user can pay without answering diet required questions</label>
                </div>
            </div>
            <div class="form-group">
                vat percentage: <input name="vat_percentage" type="text" class="form-control" value="{{ $settings->vat_percentage }}" >
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input name="vat_visibility_is_invoice" type="checkbox" class="form-check-input" id="vat_visibility_is_invoice" @if( !empty($settings->vat_visibility_is_invoice)) checked @endif>
                    <label class="form-check-label" for="vat_visibility_is_invoice">vat visibility is invoice</label>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-success" type="submit">submit</button>
            </div>
        </form>
    </div>
</div>
