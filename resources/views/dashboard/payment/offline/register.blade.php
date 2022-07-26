<div>
    @UserAjaxForm(['form_id' => 'register-offline-payment', 'is_update' => false ])@endUserAjaxForm
    <form method="post" id="register-offline-payment" action="{{ route('dashboard.offline-payment.store') }}">
        @csrf

        {{-- <div class="d-flex flex-wrap inputContainer">
            <label class="organizer">@lang('validation.attributes.amount')</label>
            <div class="organizer box-input">
                <input name="amount" type="number" step="0.01" class="input azshanbeInput">
            </div>
        </div> --}}

        <div class="form-group d-flex flex-wrap inputContainer">
            <label for="payment_date organizer w-100 mb-0">@lang('validation.attributes.payment_date')</label>
            @UserPersianDatepicker([
            "name" => 'payment_date',
            "class" => 'form-control',
            "id" => 'payment_date',
            ])
            @endPersianDatepicker
        </div>

        {{-- <div class="d-flex flex-wrap inputContainer">
            <label class="organizer">@lang('validation.attributes.payment_type')</label>
            <div class="box-input custom-select">
                <select name="payment_type"  id="payment_type">
                    <option value="{{ \App\Constants\GeneralConstants::OFFLINE_PAYMENT_TYPE_CARD_TO_CARD }}">@lang('general.card_to_card')</option>
                    <option value="{{ \App\Constants\GeneralConstants::OFFLINE_PAYMENT_TYPE_DEPOSIT_BY_BANK_RECEIPT }}">@lang('general.deposit_by_bank_receipt')</option>
                </select>
            </div>
        </div> --}}

        <div class="d-flex flex-wrap inputContainer">
            <label class="organizer">@lang('validation.attributes.tracking_number')</label>
            <div class="organizer box-input">
                <input name="tracking_number" type="text" class="input azshanbeInput">
            </div>
        </div>

        <div class="d-flex flex-wrap inputContainer">
            <label class="organizer">@lang('validation.attributes.card_number')</label>
            <div class="organizer box-input">
                <input name="card_number" type="text" class="input azshanbeInput">
            </div>
        </div>

        <button type="submit" class="submit-button greenBackColor whiteColor organizer register">
            <span class="rightFloat font-size-14 boldFont">درج اطلاعات</span>
        </button>
    </form>
</div>
