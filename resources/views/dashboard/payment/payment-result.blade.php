@extends('dashboard.layouts.app')

@section('body')
<div class="voucherContainer container">

    <div class="smallPaddingSpace organizer relative">

        <div class="paymentBack mobileVersion">
            <img src="img/voucherBack.svg">
        </div>

        <div class="voucherFix">
            <div class="voucherDesktopWhiteBox">
                <div class="paymentTitle organizer textInCenter voucher">
                    <img src="img/clap.svg">
                    <h2 class="font-size-24 boldFont greenColor">پرداخت موفق</h2>
                    <div class="voucherDescription font-size-14 lightFont">
                        پرداخت مبلغ {{ number_format( (int) $invoice->total_amount ) }} &#xFDFC; از طریق درگاه پرداخت {{ $invoice->paymentGateway->title }} با موفقیت انجام شد.
                    </div>
{{--                    <div class="paymentCode font-size-18 boldFont">--}}
{{--                        <p>کد پرداخت</p>--}}
{{--                        <div class="codeBox">{{ $invoice->payment_code }}</div>--}}
{{--                    </div>
--}}
                    <style>
                        #nextpay {margin:auto}
                        #nextpay img {width: 80px;}
                    </style>
                    <div id="nextpay">
                        <img src="https://nextpay.org/nx/assets/media/logos/logo-letter-9.png" alt="">
                    </div>

                    <div class="paymentCode font-size-18 boldFont">
                        <p>کد رهگیری</p>
                        <div class="codeBox">{{ $invoice->refid }}</div>
                    </div>
                </div>

                <div class="voucherActions textInCenter organizer">
                    <div class="paymentButton whiteColor  greenBackColor">
                        <span class="middleContext">
                            <a href="{{ route('dashboard.home') }}">خانه</a>
                        </span>
                        <span class="icon icon-home middleContext"></span>
                    </div>
                    <div class="paymentButton whiteColor blueBack">
                        <a href="https://wa.me/989981150317" target="_blank"></a>
                        <span class="middleContext">پیام به کارشناس</span>
                        <span class="icon icon-chat middleContext"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
