<div class="paddingSpace contactSupport support-home">
    <div class="signInBox onWhiteBack">
        <div
            class="registerTitle font-size-18 boldFont organizer textInCenter standardBottomMargin">
           در خواست پشتیبانی
        </div>
        @UserAjaxForm(['form_id' => 'contact-us-request-form', 'is_update' => false ])@endUserAjaxForm
        <form class="" id="contact-us-request-form" method="post" action="{{ route('contact-us-requests.store') }}" >
            @csrf
            <input class="organizer input azshanbeInput" name="name" type="text"
                   placeholder="نام و نام خانوادگی">
            <div class="valuableInput relative organizer box-tel-input">
                <input class="input numberInput azshanbeInput mobile_number" name="mobile_number" type="text"
                       placeholder="شماره همراه">
                <span class="valueInInput">
                                <span class="separator"></span>
                                    +۹۸
                                </span>
            </div>
            <div class="textAreaInput relative organizer">
                                <textarea class="input numberInput azshanbeInput" name="message" type="text"
                                          placeholder="پیام شما"></textarea>
                {{-- <span class="remainCharacter">کاراکتر مانده 140</span> --}}
            </div>
            <button type="submit" class="redBackColor whiteColor organizer register cursor-pointer" onclick="gtag('event', 'ask-support-btn', {'event_category': 'forms', 'event_label': 'در خواست پشتیبانی ازشنبه', 'event_callback': function() {console.log('hit sent')}});">
                <span class="rightFloat font-size-14 boldFont">@lang('general.submit')</span>
                <span class="icon icon-forward font-size-18 leftFloat"></span>
            </button>
        </form>
    </div>


    <div class="pinkItem desktopVersion">
        <img src="img/bottomPinkSmallShape.svg">
    </div>
</div>
