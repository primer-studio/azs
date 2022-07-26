@extends('dashboard.layouts.app')

@section('body')
    @php
        if (empty($session_mobile_number)) {
            $session_mobile_number = \Session::pull(\App\Constants\GeneralConstants::VERIFICATION_CODE_GENERATED_FOR_MOBILE_NUMBER_SESSION_KEY);
        }
    @endphp

    <div class="signin">
        <div class="contentsignin">
            <div class="boxsignin">
                <header>
                    ورود به پنل کاربری
                </header>
                {{--  if code generated -- start --}}
                @if (!empty($session_mobile_number))
                    {{-- login by verification code -- start --}}
                    <form method="POST" class="verification-code-login" action="{{ route('verification-code-login') }}">
                        @csrf
                        <label class="valuableInput d-flex align-items-center lblnumber w-100 mb-2">
                            <input type="tel" placeholder="شماره همراه"
                                   class="number azshanbeInput fix-input-h py-none" readonly name="mobile_number" value="{{ $session_mobile_number }}" required="">
                            <span class="fix-input-h py-none">
                                    +98
                                </span>
                        </label>
                        <div class="box-input mb-6">
                            <label class="valuableInput d-flex align-items-center w-100 mb-2">
                                <input type="number" placeholder="کد تایید خود را وارد کنید"
                                       class="input azshanbeInput fix-input-h py-none" name="verification_code" value="" required="">
                            </label>
                        </div>
                        <div class="send-again align-items-center flex-wrap justify-content-between mb-6 d-flex w-100">
                            <div class="send-again-counter-and-progress-container d-flex align-items-center w-100 justify-content-between">
                                <progress class="progress-send-again d-flex d-none" max="60" value="59"></progress>
                                <span
                                    class="send-again-counter custom-color-gray font-size-14 mr-2 d-flex d-none">00:00</span>
                            </div>
                            <span class="send-again-btn d-flex align-items-center custom-color-gray font-size-14 cursor-pointer">
                                <span class="icon icon-repeat ml-1"></span>
                                درخواست ارسال مجدد
                            </span>
                            <a href="{{ route('verification-code-login') }}">ویرایش شماره</a>
                        </div>

                        <button type="submit" class="register-btn cursor-pointer">
                            ورود
                        </button>
                    </form>
                    {{-- login by verification code -- end --}}
                @endif

                {{-- get verification code (login) -- start --}}
                <form method="POST" id="set-verification-code" class="set-verification-code @if (!empty($session_mobile_number)) d-none @endif" action="{{ route('set-verification-code') }}">
                    @csrf
                    @isset($mtp)
                        <input name="mtp" value="{{ $mtp }}" type="hidden">
                    @endisset
                    <div class="box-input mb-6">
                        <label class="valuableInput d-flex align-items-center lblnumber w-100 mb-2">
                            <input type="tel" placeholder="شماره همراه"
                                   class="number azshanbeInput fix-input-h py-none" name="mobile_number"
                                   @if (!empty($session_mobile_number)) value="{{ $session_mobile_number }}" @else value="{{ old('mobile_number') }}" @endif  required="">
                            <span class="fix-input-h py-none">
                                    +98
                                </span>
                        </label>
                    </div>
                    <button type="submit" class="register-btn cursor-pointer">
                        ورود
                    </button>
                </form>
                {{-- get verification code (login) -- end --}}
                <footer>
                    اگر هنوز ثبت نام نکرده‌اید <a href="{{ route('home') }}" title="اینجا کلیک کنید">اینجا کلیک کنید</a>
                </footer>
            </div>
        </div>
    </div>
@endsection

@pushonce('styles:/dashboard-assets/css/login.css')
<link rel="stylesheet" href="{{  asset('/dashboard-assets/css/login.css') }}">
@endpushonce

@pushonce('scripts:/dashboard-assets/js/login.js')
<script src="{{  asset('/dashboard-assets/js/login.js') }}"></script>
@endpushonce
