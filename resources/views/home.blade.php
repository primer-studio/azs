@extends('dashboard.layouts.app')

{{--begin::scripts--}}
@push('scripts')
<script>
    var code_generated = "{{ __('auth.code_generated') }}";
</script>
@endpush

@pushonce('scripts:/dashboard-assets/js/home.js')
    <script src="{{  asset('/dashboard-assets/js/home.js?v=1.01') }}"></script>
@endpushonce
{{--end::scripts--}}

@section('body')
<div class="container main-container">

    {{-- Header --}}
            <!--begin::Header-->
            @include('header')
            <!--end::Header-->
    {{-- Header --}}

    <div class="paddingSpace organizer relative desktopFullScreen">
        <div class="meterItem desktopMode">
            <img class="mobileVersion" src="img/meter.png">
            <img class="desktopVersion dsm-none" src="img/meter_desktop.png">
        </div>
        <div class="kiwiItem">
            <img class="greenLeftWave" src="img/greenLeftWave.svg">
            <img class="kiwiImage" src="img/kiwi.svg">
        </div>
        <div class="pomegranateItem">
            <img class="rightRedWave" src="img/rightRedWave.svg">
            <img class="pomegranateImage" src="img/Pomegranate.svg">
        </div>

        <div class="orangeItem">
            <img src="img/orange.svg">
        </div>

        <div class="plateItem desktopVersion dsm-none">
            <img src="img/plate.png">
        </div>
        <div class="flexContainer">
            <div class="mediumSizeHandler">
                <div class="alignItem d-flex flex-wrap">
                    <div class="rightContent order-2">
                        <div class="mainTitle greenColor organizer">
                            <h1 class="boldFont font-size-36 font-size-74-desktop redColor"> از شنبه </h1>
                            <h2 class="font-size-16 boldFont font-size-32-desktop redColor">
                                کلینیک تخصصی رژیم درمانی 
                            </h2>
                            <span class="titleLine rightFloat inlineView redBackColor"></span>
                        </div>
                        <div class="titleDescription font-size-14 lightFont organizer font-size-16-desktop">
                            ازشنبه یه پلتفرم دریافت رژیم غذایی آنلاین هست اینجا همه چیزهایی که برای یک رژیم لاغری موثر نیاز دارین در اختیارتون قرار داده میشه. دستورالعملی 21 روزه مطابق با سلیقه
                            غذایی شما رو به آرزوتون می رسونه. با ثبت نام توی سایت و وارد کردن اطلاعات فیزیکی بدن‌تون میتونید برنامه
                            غذایی منحصر به فرد خودتون رو از متخصصین تغذیه ما دریافت کنید. از شنبه رژیمی را براتون طراحی می کنه که با ذائقه غذایی
                            تون سازگار باشه!!
                        </div>
                    </div>

                    <div class="signInBox pos-relative responsive-m-t order-1" id="SignInBox">
                        <div class="show-register-box registerTitle font-size-18 title-auth-home signin-btn-home boldFont cursor-pointer">
                            ثبت نام
                        </div>
                        {{-- <div class="show-set-verification-code loginTitle  font-size-18 boldFont login-btn login-btn-home cursor-pointer">
                                ورود
                            </div> --}}
                        <div class="font-size-14 lightFont startDiet sub-title-auth-home d-flex flex-wrap pos-relative">
                            <p class="w-100 box-1 font-size-14">
                                برای دریافت رژیم شروع کنید
                            </p>
                            <p class="w-100 box-2 font-size-14">
                                لطفا شماره خود را وارد کنید
                            </p>
                        </div>


                        {{-- register -- start --}}
                        <form method="POST" class="register-form homePageRegister" action="{{ route('set-verification-code') }}">
                            @csrf

                            <div class="valuableInput relative organizer box-input">
                                <div class="valuableInput relative organizer box-tel-input">
                                    <input type="tel" placeholder="شماره همراه" class="mobile_number input numberInput azshanbeInput custom-color-gray " name="mobile_number" value="" required autocomplete="mobile_number" autofocus>
                                    <span class="valueInInput">
                                        <span class="separator"></span>
                                        +۹۸
                                    </span>
                                </div>
                            </div>


                            <div class="box-input w-100">
                                <input type="text" class=" organizer input azshanbeInput custom-color-gray" name="name" value="" placeholder="نام و نام خانوادگی" required autocomplete="name" autofocus>
                                @isset($mtp)
                                <input name="mtp" value="{{ $mtp }}" type="hidden">
                                @endisset
                                <input name="register" value="1" type="hidden">
                            </div>


                            <div class="d-flex align-items-center justify-content-between box-btn-reg-header w-100">
                                <button type="submit" class="submit-button redBackColor whiteColor organizer register register-btn cursor-pointer">
                                    <span class="submit-button-title rightFloat font-size-14 boldFont" data-title="شروع ثبت نام">شروع ثبت نام</span>
                                    <span class="icon icon-forward font-size-18 leftFloat"></span>
                                </button>

                            </div>
                        </form>
                        {{-- register -- end --}}

                        {{-- get verification code (login) -- start --}}
                        <form method="POST" class="set-verification-code d-none" action="{{ route('set-verification-code') }}">
                            @csrf
                            <div class="valuableInput relative organizer box-input">
                                <div class="valuableInput relative organizer box-tel-input">
                                    <input type="tel" placeholder="شماره همراه" class="mobile_number input numberInput azshanbeInput custom-color-gray " name="mobile_number" value="" required autocomplete="mobile_number" autofocus>
                                    <span class="valueInInput">
                                        <span class="separator"></span>
                                        +۹۸
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="submit-button greenBackColor whiteColor organizer register register-btn cursor-pointer">
                                <span class="submit-button-title rightFloat font-size-14 boldFont" data-title="ورود">ورود</span>
                                <span class="icon icon-forward font-size-18 leftFloat"></span>
                            </button>
                        </form>
                        {{-- get verification code (login) -- end --}}

                        {{-- login by verification code -- start --}}
                        <form method="POST" class="verification-code-login d-none" action="{{ route('verification-code-login') }}">
                            @csrf
                            @isset($mtp)
                            <input name="mtp" value="{{ $mtp }}" type="hidden">
                            @endisset
                            <div class="valuableInput relative organizer box-input">
                                <div class="valuableInput relative organizer box-tel-input">
                                    <input type="tel" readonly class="mobile_number input numberInput azshanbeInput custom-color-gray " name="mobile_number" value="" required autocomplete="mobile_number" autofocus>
                                    <span class="valueInInput">
                                        <span class="separator"></span>
                                        +۹۸
                                    </span>
                                </div>
                            </div>

                            <div class="valuableInput relative organizer box-input">
                                <div class="valuableInput relative organizer box-tel-input">
                                    <input type="number" placeholder="کد تایید خود را وارد کنید" class="input numberInput azshanbeInput custom-color-gray " name="verification_code" autocomplete="off" autofocus required>
                                </div>
                            </div>

                            <div class="send-again d-none align-items-center flex-wrap justify-content-between">
                                <span class="d-flex align-items-center custom-color-gray font-size-14">
                                    <span class="icon icon-repeat ml-1"></span>
                                    درخواست ارسال مجدد
                                </span>
                                <div class="d-flex align-items-center">
                                    <progress class="d-none progress-send-again" max="60" value="0"></progress>
                                    <span class="send-again-counter custom-color-gray font-size-14 mr-2"></span>
                                </div>
                            </div>

                            <button type="submit" class="submit-button redBackColor whiteColor organizer register register-btn cursor-pointer">
                                <span class="submit-button-title rightFloat font-size-14 boldFont" data-title="ورود">ورود</span>
                                <span class="icon icon-forward font-size-18 leftFloat"></span>
                            </button>
                        </form>
                        {{-- login by verification code -- end --}}

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="whiteSpace organizer">
        <div class="topWaveWhite">
            <img class="mobileVersion" src="img/whiteTopWave_Phone.svg">
            <img class="desktopVersion" src="img/whiteDesktopWave.svg">
        </div>

        <div class="w-100">
            @UserBmiCalculator([
                "id" => "home-page-bmi-calculator"
            ])
            @endUserBmiCalculator()
            
        </div>
      
        <div class="normalHeader relative organizer" id="change_users_style">
            <h2 class="font-size-18 boldFont">
                تغییرات مراجعین 
            </h2>
        </div>
        <div class="organizer textInCenter position-relative my-8">
            <div class="boxslider">
                <div class="swiper-container swiper-companions">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide" style="width: 50% !important;height: auto;">
                            <figure class="">
                                <img class="img-companions" src="./img/t11.jpg">
                            </figure>
                            <header class="d-flex align-items-center mx-20 my-8">
                                <img class="img-user-customer" src="./img/thumb.svg">
                                <span class="span-companions">
                                    مریم ۳۶ ساله
                                </span>
                            </header>
                            <p class="mx-20 my-8 p-companions">
                                مریم از آبان ماه تا بهمن ماه کاهش سایز و وزن فوق العاده ای رو تجربه کرده و دوره
                                تثبیت وزنش به تازگی تموم شده
                            </p>
                        </div>

                        <div class="swiper-slide" style="width: 50% !important;height: auto;">
                            <figure class="">
                                <img class="img-companions" src="./img/t7.jpg">
                            </figure>
                            <header class="d-flex align-items-center mx-20 my-8">
                                <img class="img-user-customer" src="./img/thumb.svg">
                                <span class="span-companions">
                                    سمیرا ۵۵ ساله
                                </span>
                            </header>
                            <p class="mx-20 my-8 p-companions">
                                سمیرا بخاطر ورزش منظم و برنامه غذایی اصولی تا به اینجا تونسته به خوبی سایز کم کنه و
                                همچنان در حال ادامه دادن روند کاهش وزن هست
                            </p>
                        </div>

                        <div class="swiper-slide" style="width: 50% !important;height: auto;">
                            <figure class="">
                                <img class="img-companions" src="./img/t4.jpg">
                            </figure>
                            <header class="d-flex align-items-center mx-20 my-8">
                                <img class="img-user-customer" src="./img/thumb.svg">
                                <span class="span-companions">
                                    محمدرضا ۴۵ ساله
                                </span>
                            </header>
                            <p class="mx-20 my-8 p-companions">
                                درمان کبد چربم رو مدیون ازشنبه و  تیم متخصص و  عالیشون هستم 
                            </p>
                        </div>

                        <div class="swiper-slide" style="width: 50% !important;height: auto;">
                            <figure class="">
                                <img class="img-companions" src="./img/t2.jpg">
                            </figure>
                            <header class="d-flex align-items-center mx-20 my-8">
                                <img class="img-user-customer" src="./img/thumb.svg">
                                <span class="span-companions">
                                    لیلا ۴۲ ساله
                                </span>
                            </header>
                            <p class="mx-20 my-8 p-companions">
                                لیلا به خاطر فشار خون برای دریافت رژیم اقدام کرد و حالا در طول دو دوره کاملا سبک و
                                بدون ریسک تونسته ۵ کیلو وزن هم کم کنه
                            </p>
                        </div>

                        <div class="swiper-slide" style="width: 50% !important;height: auto;">
                            <figure class="">
                                <img class="img-companions" src="./img/t12.jpg">
                            </figure>
                            <header class="d-flex align-items-center mx-20 my-8">
                                <img class="img-user-customer" src="./img/thumb.svg">
                                <span class="span-companions">
                                    مینا ۲۳ ساله
                                </span>
                            </header>
                            <p class="mx-20 my-8 p-companions">
                                مینا بعد از گذروندن یک دوره شوک و سه دوره رژیم حالا ۶۸ کیلو شده و با انگیزه داره به
                                مسیر کاهش سایز و وزنش ادامه میده
                            </p>
                        </div>

                        <div class="swiper-slide" style="width: 50% !important;height: auto;">
                            <figure class="">
                                <img class="img-companions" src="./img/t10.jpg">
                            </figure>
                            <header class="d-flex align-items-center mx-20 my-8">
                                <img class="img-user-customer" src="./img/thumb.svg">
                                <span class="span-companions">
                                    سحر ۳۱ ساله
                                </span>
                            </header>
                            <p class="mx-20 my-8 p-companions">
                                سحر با اینکه بیماری پلی کیستیک داشت و بخاطر مصرف داروهای هورمونی وزن کم نمی  کرد طی دو دوره با رژیم های ازشنبه تونست ۶ کیلو کم کنه.
                            </p>
                        </div>

                        <div class="swiper-slide" style="width: 50% !important;height: auto;">
                            <figure class="">
                                <img class="img-companions" src="./img/t9.jpg">
                            </figure>
                            <header class="d-flex align-items-center mx-20 my-8">
                                <img class="img-user-customer" src="./img/thumb.svg">
                                <span class="span-companions">
                                    رویا ۳۷ ساله
                                </span>
                            </header>
                            <p class="mx-20 my-8 p-companions">
                                رویا بخاطر اضافه وزن و  خطر بارداری نیاز  به 10 کیلو کاهش وزن داشت که با انگیزه بسیار بالا با رژیم همراهی داشت و الان به وزن مطلوب رسیده.
                            </p>
                        </div>

                        <div class="swiper-slide" style="width: 50% !important;height: auto;">
                            <figure class="">
                                <img class="img-companions" src="./img/t8.jpg">
                            </figure>
                            <header class="d-flex align-items-center mx-20 my-8">
                                <img class="img-user-customer" src="./img/thumb.svg">
                                <span class="span-companions">
                                    سایه ۴۹ ساله
                                </span>
                            </header>
                            <p class="mx-20 my-8 p-companions">
                          سایه به خاطر رژیم های مختلفی که استفاده کرده بود دچار استپ وزنی شد و به کمک متخصصین ازشنبه تونست قفل این استپ رو بشکنه و  از بهترین های ازشنبه  باشه.
                            </p>
                        </div>

                        <div class="swiper-slide" style="width: 50% !important;height: auto;">
                            <figure class="">
                                <img class="img-companions" src="./img/t3.jpg">
                            </figure>
                            <header class="d-flex align-items-center mx-20 my-8">
                                <img class="img-user-customer" src="./img/thumb.svg">
                                <span class="span-companions">
                                    مهتاب ۱۹ ساله
                                </span>
                            </header>
                            <p class="mx-20 my-8 p-companions">
                                مهتاب بخاطر سن کم با رژیم های  خوب ازشنبه و  انگیزه بالا تغییر حیرت انگیزی داشت و این تغییر بعد از چند ماه هنود بازگشت وزن نداره.
                            </p>
                        </div>

                        <div class="swiper-slide" style="width: 50% !important;height: auto;">
                            <figure class="">
                                <img class="img-companions" src="./img/t5.jpg">
                            </figure>
                            <header class="d-flex align-items-center mx-20 my-8">
                                <img class="img-user-customer" src="./img/thumb.svg">
                                <span class="span-companions">
                                    شهلا ۶۰ ساله
                                </span>
                            </header>
                            <p class="mx-20 my-8 p-companions">
                                شهلا بخاطر آرتروز شدید و تجویز بزشک چهارده کیلو تو سه دوره کم کرد و  تیم پشتیبانی ازشنبه کنارشون بود.
                            </p>
                        </div>

                        <div class="swiper-slide" style="width: 50% !important;height: auto;">
                            <figure class="">
                                <img class="img-companions" src="./img/t6.jpg">
                            </figure>
                            <header class="d-flex align-items-center mx-20 my-8">
                                <img class="img-user-customer" src="./img/thumb.svg">
                                <span class="span-companions">
                                    سپهر ۲۷ ساله
                                </span>
                            </header>
                            <p class="mx-20 my-8 p-companions">
                                از شنبه بهم کمک کردتا سبک غذاییم تغییر ه و به وزن ثابت رسیدم.
                            </p>
                        </div>

                        <div class="swiper-slide" style="width: 50% !important;height: auto;">
                            <figure class="">
                                <img class="img-companions" src="./img/t1.jpg">
                            </figure>
                            <header class="d-flex align-items-center mx-20 my-8">
                                <img class="img-user-customer" src="./img/thumb.svg">
                                <span class="span-companions">
                                    عرفان ۲۹ ساله
                                </span>
                            </header>
                            <p class="mx-20 my-8 p-companions">
                                کمر درد زیاد و تنگی نفس علت کاهش وزن من بود و همیشه از این مشکل ناراحت بودم اما الان خوشحالم که به بهترین  حالتم رسیدم و تغذیه مناسب بدنم رو پیدا کردم.

                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="companions-button-next arrow-companions companions"><img class="" src="./img/right-arrow.svg"></div>
            <div class="companions-button-prev arrow-companions companions"><img class="" src="./img/left-arrow.svg"></div>
        </div>

        <div class="normalHeader relative organizer">
            <h2 class="font-size-18 boldFont"> نظرات مراجعین </h2>
        </div>

        <div class="organizer textInCenter position-relative my-8">
            <div class="boxslider">
                <div class="swiper-container swiper-audio">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" style="width: 50% !important;height: auto;">
                            <div class="content px-3 py-3 d-flex flex-wrap">
                                <header class="w-100 d-flex align-items-center">
                                    <h5 class="span-companions">مینا حاتمی</h5>
                                </header>
                                <p class="p-companions">
                                    من با رژیم های از شنبه تونستم 5 کیلو تو یک دوره کم کنم و از 69 کیلو به 65 کیلو برسم و خیلی راضیم.
                                </p>
                            </div>
                            <div class="audiobox w-100 d-flex">
                                <audio class="w-100 aud1" controls preload="metadata" data-class="aud1">
                                    <source src="audio/0meoa-11s6i.mp3" type="audio/mpeg">
                                </audio>
                            </div>
                        </div>
                        <div class="swiper-slide" style="width: 50% !important;height: auto;">
                            <div class="content px-3 py-3 d-flex flex-wrap">
                                <header class="w-100 d-flex align-items-center">
                                    <h5 class="span-companions">مینا رئوف</h5>
                                </header>
                                <p class="p-companions">
                                    من از شنبه تشکر می کنم چون تونستم کاهش وزن خوبی داشته باشم و با اینکه بیمارب روده دارم 6 کیلو کم کردم
                                </p>
                            </div>
                            <div class="audiobox w-100 d-flex">
                                <audio class="w-100 aud2" controls preload="metadata" data-class="aud2">
                                    <source src="audio/4hpas-1y4zb.mp3" type="audio/mpeg">
                                </audio>
                            </div>
                        </div>
                        <div class="swiper-slide" style="width: 50% !important;height: auto;">
                            <div class="content px-3 py-3 d-flex flex-wrap">
                                <header class="w-100 d-flex align-items-center">
                                    <h5 class="span-companions">سیما روزبهان</h5>
                                </header>
                                <p class="p-companions">
                                    من با اینکه خیلی رعایت ندارم با این حال 2 کیلو وزن کم کردم خیلی خوشحالم و خواستم از شما و تیم خوبتون تشکر کنم.
                                </p>
                            </div>
                            <div class="audiobox w-100 d-flex">
                                <audio class="w-100 aud3" controls preload="metadata" data-class="aud3">
                                    <source src="audio/88ruw-x7rqw.mp3" type="audio/mpeg">
                                </audio>
                            </div>
                        </div>
                        <div class="swiper-slide" style="width: 50% !important;height: auto;">
                            <div class="content px-3 py-3 d-flex flex-wrap">
                                <header class="w-100 d-flex align-items-center">
                                    <h5 class="span-companions">لعیا کرمی</h5>
                                </header>
                                <p class="p-companions">
                                    من همیشه از جاهای مختلف رژیم گرفتم و و راضی نبودم اما ازرژیم شما خیلی راحت بودم و با اینکه ابتدای رژیم هستم تغییراتم محسوس است و وقت کم کردم
                                </p>
                            </div>
                            <div class="audiobox w-100 d-flex">
                                <audio class="w-100 aud4" controls preload="metadata" data-class="aud4">
                                    <source src="audio/k5vo4-2tgl0.mp3" type="audio/mpeg">
                                </audio>
                            </div>
                        </div>
                        <div class="swiper-slide" style="width: 50% !important;height: auto;">
                            <div class="content px-3 py-3 d-flex flex-wrap">
                                <header class="w-100 d-flex align-items-center">
                                    <h5 class="span-companions">مهتا اسلامی</h5>
                                </header>
                                <p class="p-companions">
                                    فوق العاده از رژیم های از شنبه راضی هستم و با توجه به قیمت پایینش فکر نمی کردم انقدر خوب و تاثیرگار باشه .من با این رزیم چربی سوزی داشتم و در 14 روز اول 3 کیلو وزن کم کردم در حالی که اصلا گرسنگی حس نکردم..ممنونم از شما
                                </p>
                            </div>
                            <div class="audiobox w-100 d-flex">
                                <audio class="w-100 aud5" controls preload="metadata" data-class="aud5">
                                    <source src="audio/4oppw-k05ez.mp3" type="audio/mpeg">
                                </audio>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="companions-button-next arrow-companions audio"><img class="" src="./img/right-arrow.svg"></div>
            <div class="companions-button-prev arrow-companions audio"><img class="" src="./img/left-arrow.svg"></div>
        </div>


        <div class="instagramFollow textInCenter textInCenter d-flex flex-wrap position-relative w-100 mt-4">
            {{-- <h2 class="boldFont font-size-16 w-100 custom-font-gray">ما را در اینستاگرام دنبال کنید</h2> --}}
            <span class="instagramButton goto-video font-size-18 d-flex justify-content-center whiteColor cursor-pointer" title="azshanbe.me">
                <span class="instagramText">چطور ثبت نام کنم؟‌</span>
            </span>
        </div>

        {{-- a --}}
            <!--begin::contact-us-form-->
            @include('contact-us-form2')
            <!--end::contact-us-form-->
        {{-- b --}}


        <div class="normalHeader relative organizer">
            <h2 class="font-size-18 boldFont"> چرا از شنبه؟ </h2>
        </div>
        <div class="questions how-azshanbe relative">
            <div class="mediumSizeHandler">
                <div class="questionBox">
                    <div class="question boldFont">
                        <span class="questionNumber boldFont brownColor">۱</span>
                        رژیم درمانی
                    </div>
                    <div class="answer lightFont organizer">
                        با کمک رفتاردرمانی، تغیر در سبک زندگی، افزایش فعالیت بدنی و مهم تر از همه اصلاح رژیم غذایی به افراد کمک می ‌کنه تغییر وزن تضمینی داشته باشن. تاکید در رژیم درمانی روی ازبین بردن عادات غذایی نادرست در افراده.
                    </div>
                </div>
                <div class="questionBox">
                    <div class="question boldFont">
                        <span class="questionNumber boldFont brownColor">۲</span>
                        رعایت اصول علمی
                    </div>
                    <div class="answer lightFont organizer">
                        رژیم هایی که به شما وعده لاغری سریع میدن فاقد اعتبارن، چون آسیب های زیادی به دنبال دارن. در رژیمی که با رعایت اصول علمی طراحی شده هدف از کاهش وزن کاهش چربی بدنه و نه از بین بردن آب یا بافت عضلانی. متخصصان از شنبه با توجه به اصول علمی و با دقت زیاد رژیم شما رو طراحی میکنن. 
                    </div>
                </div>
                <div class="questionBox">
                    <div class="question boldFont">
                        <span class="questionNumber boldFont brownColor">۳</span>
                        منوی غذایی روزانه                    
                    </div>
                    <div class="answer lightFont organizer">
                        تمام وعده ها و میان وعده های غذایی در رژیم های از شنبه به تفکیک مشخص شده. جایگزین ها هم برای هر وعده در نظر گرفته شده که در صورت در دسترس نبودن یک ماده غذایی یا عدم تمایل شما به اون وعده غذایی بتونید به راحتی جایگزینش کنید. در انتخاب میوه ها دست شما بازه بر اساس جدولی که تو رژیم تون ارائه شده، میوه های مختلف رو جایگزین کنین. به بخش «پیشنهاد کارشناس» که به طور اختصاصی برای شما تدوین شده با دقت عمل کنین تا نتیجه چشمگیری بگیرید.                     
                    </div>
                </div>
                <div class="questionBox">
                    <div class="question boldFont">
                        <span class="questionNumber boldFont brownColor">۴</span>
                        عدم بازگشت وزن
                    </div>
                    <div class="answer lightFont organizer">
                        از اون جایی که با رژیم های از شنبه به مرور و در طول زمان وزن خودتون رو کم می کنین دچار بازگشت وزن نمی شید. افراد با رژیم های سخت در همان ابتدا وزن زیادی رو از دست میدن اما از اونجایی که نمیتونن طولانی مدت از این رژیم پیروی کنن، مجددا دچار اضافه وزن میشن. هدف از شنبه کاهش وزنتون بر اساس تغییر سبک زندگیه. پس کاهش وزن رو فقط به عنوان هدف کوتاه مدت نبینین و خودتون رو برای یک موفقیت طولانی مدت آماده کنین. 
                    </div>
                </div>
                <div class="questionBox">
                    <div class="question boldFont">
                        <span class="questionNumber boldFont brownColor">۵</span>
                        بدون عوارض جانبی
                    </div>
                    <div class="answer lightFont organizer">
                        رژیم های سخت عوارضی مثل ریزش مو، شکنندگی ناخن ها، مشکلات پوستی، بروز سنگ های صفراوی، پوکی استخوان، افسردگی، تضعیف سیستم ایمنی بدن و... را به دنبال دارن. از شنبه افتخار میکنه که رژیم هایی که طراحی کرده هیچ عوارض جانبی ای در پی نداشته و هیچ گزارشی از رژیم گیرنده ها در این رابطه ثبت نشده. 
                    </div>
                </div>
                <div class="questionBox">
                    <div class="question boldFont">
                        <span class="questionNumber boldFont brownColor">۶</span>
                        در دسترس بودن                    
                    </div>
                    <div class="answer lightFont organizer">
                        رژیم های از شنبه با مواد غذایی ای طراحی می شود که در دسترس همه وجود دارن. هماهنگی این رژیم ها با سفره غذایی خانواده باعث میشه تنها کمی محدودیت وجود داشته باشه و محرومیتی برای افراد ایجاد نشه. نکته دیگه اینه که فردی که می خواد وعده های غذایی رو آماده کنه بخاطر مشابهت غذای رژیم با غذای خانواده به زحمت اضافه نمیفته، پس همه چیز برای انجام یک رژیم خوب و بی دردسر مهیاست.                     
                    </div>
                </div>
                <div class="questionBox">
                    <div class="question boldFont">
                        <span class="questionNumber boldFont brownColor">۷</span>
                        پشتیبانی تخصصی
                    </div>
                    <div class="answer lightFont organizer">
                        تیم پشتیبانی از شنبه تمام وقت آماده ارائه مشاوره و پاسخگویی به سوال های شماست. هر سوالی ذهنتون رو مشغول کرد کافیه به واتساپ شماره 09981150317 پیام بدید یا با شماره 23051172-021 تماس بگیرین. پشتیبان ها با روی باز از شما استقبال میکنن.
                    </div>
                </div>
                <div class="questionBox">
                    <div class="question boldFont">
                        <span class="questionNumber boldFont brownColor">۸</span>
                        تیم تخصصی پزشکی حرفه ای
                    </div>
                    <div class="answer lightFont organizer">
                        اگه دارای بیماری یا مشکل جسمی خاص هستین، مطمئن باشین که رژیم شما با مشورت تیم تخصصی پزشکی و بر اساس اطلاعات شما طراحی میشه. هیچ چیز نمیتونه مانع رسیدن شما به وزن ایدئالتون بشه.
                    </div>
                </div>
                <div class="questionBox">
                    <div class="question boldFont">
                        <span class="questionNumber boldFont brownColor">۹</span>
                        رضایتمندی
                    </div>
                    <div class="answer lightFont organizer">
                        از شنبه به خودش می باله که تونسته رضایت رژیم گیرنده ها رو جلب کنه. پیام های کسب نتیجه مطلوب و قدردانی از تیم متخصصان لبخند رو به لب تیم از شنبه میاره و اونها رو به تلاش بیشتر دلگرم میکنه. 
                    </div>
                </div>
                <div class="questionBox">
                    <div class="question boldFont">
                        <span class="questionNumber boldFont brownColor">۱۰</span>
                        بهترین رژیم با کمترین هزینه
                    </div>
                    <div class="answer lightFont organizer">
                        شما با پرداخت هزینه ای مناسب و برخورداری از پشتیبانی کامل و همه جانبه می تونین یک رژیم غذایی کامل و بی نقص داشته باشین و لحظه به لحظه بیشتر به رویای تناسب اندام تون نزدیک بشین.   
                    </div>
                </div>
            </div>
            {{-- <div class="paddingSpace desktopTextCenter">
                        <button type="submit" class="greenBackColor whiteColor organizer register">
                            <span class="rightFloat font-size-14 boldFont">مشاهده سوالات بیشتر</span>
                            <span class="icon icon-forward font-size-18 leftFloat"></span>
                        </button>
                    </div> --}}

            <div class="weightItem desktopVersion">
                <img src="img/weight.png">
            </div>
        </div>

        <div class="d-flex justify-content-center align-content-center flex-wrap w-100">
            <div class="textInCenter position-relative d-flex flex-wrap mt-4">
                <div class="d-flex w-100 align-items-center justify-content-center boxslider">
                    <p class="p-tel-support ml-2 custom-font-gray"> درخواست مشاوره دارید؟ تماس بگیرید. </p>
                    <a href="tel:09981150317" class="mb-0 d-flex align-items-center a-tel-support" title="۰۹۹۸-۱۱۵۰۳۱۷">
                        ۰۹۹۸-۱۱۵۰۳۱۷ 
                    </a>
                </div>
            </div>
    
            <div class="instagramFollow textInCenter textInCenter d-flex flex-wrap position-relative mt-4">
                <h2 class="boldFont font-size-16 w-100 custom-font-gray">ما را در اینستاگرام دنبال کنید</h2>
                <a class="instagramButton font-size-18 whiteColor cursor-pointer" href="http://instagram.com/azshanbe.me/" title="azshanbe.me">
                    <span class="instagramText">از شنبه در اینستاگرام</span>
                    <span class="icon icon-instagram font-size-24 leftFloat"></span>
                </a>
            </div>
        </div>

        <div class="normalHeader relative organizer">
            <h2 class="font-size-18 boldFont">رژیم های از شنبه</h2>
        </div>
        <div class="organizer textInCenter relative">
            <div class="items">
                <div class="itemBox">
                    <div class="itemImage">
                        <img src="img/weight.svg">
                    </div>
                    <h2 class="font-size-16 font-size-18-desktop">رژیم کاهش وزن</h2>
                </div>
                <div class="itemBox">
                    <div class="itemImage">
                        <img src="img/meat.svg">
                    </div>
                    <h2 class="font-size-16 font-size-18-desktop">رژیم افزایش وزن</h2>
                </div>
                <div class="itemBox">
                    <div class="itemImage">
                        <img src="img/pregnant.svg">
                    </div>
                    <h2 class="font-size-16 font-size-18-desktop">رژیم دوران بارداری</h2>
                </div>
                <div class="itemBox">
                    <div class="itemImage">
                        <img src="img/shoe.svg">
                    </div>
                    <h2 class="font-size-16 font-size-18-desktop">رژیم ورزشی</h2>
                </div>
            </div>
            <div class="forkItem desktopVersion dsm-none">
                <img src="img/fork.png">
            </div>
        </div>
        <div class="normalHeader relative organizer">
            <h2 class="font-size-18 boldFont" style="width: 186px;">چطوری ثبت نام کنیم؟‌</h2>
            <p class="redColor" style="text-align:center; margin: 30px 0 0 0;">برای دیدن آموزش ثبت نام ویدیو را ببینید.</p>
        </div>
        <div class="smallSizeHandler">
            <div class="h_iframe-aparat_embed_frame">
                <span style="display: block;padding-top: 57%"></span>
                <iframe style="
                width: 100%;
                height: 30vw;
                margin-top: 0;
                min-height: 380px;
                max-height: 553px;
            "
             src="https://www.aparat.com/video/video/embed/videohash/r6a4Q/vt/frame" allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
            </div>                
        </div>
        <div class="desktopShadowSeparator" id="videobox">
            <div class="shapeBack desktopVersion">
                <img src="img/grayShadow.svg">
            </div>
            <div class="normalHeader relative organizer" style="margin: 0 !important;">
                <h2 class="font-size-18 boldFont">قرعه کشی ماهانه</h2>
                <p class="redColor" style="text-align:center; margin: 30px 0;">با ما به وزن ایده‌آل‌تون برسید و جایزه
                    بگیرید :)</p>
            </div>
    
            <div class="organizer lottery textInCenter" style="margin-bottom: 30px;">
                <div class="items pos-relative">
                    <div class="itemBox">
                        <div class="itemImage progressive">
                            <img class="progressive__img progressive--is-loaded" data-progressive="img/tablet.png" src="img/tablet.png">
                        </div>
                        <h2 class="font-size-16">یک دستگاه تبلت</h2>
                    </div>
                    <div class="itemBox">
                        <div class="itemImage progressive">
                            <img class="progressive__img progressive--is-loaded" data-progressive="img/money.png" src="img/money.png">
                        </div>
                        <h2 class="font-size-16">100 هزار تومان <strong class="redColor">برای 10 نفر</strong></h2>
                    </div>
                    <div class="itemBox">
                        <div class="itemImage progressive">
                            <img class="progressive__img progressive--is-loaded" data-progressive="img/mobile.png" src="img/mobile.png">
                        </div>
                        <h2 class="font-size-16">یک دستگاه گوشی موبایل</h2>
                    </div>
                    <div class="itemBox">
                        <div class="itemImage progressive">
                            <img class="progressive__img progressive--is-loaded" data-progressive="img/diet-plan.png" src="img/diet-plan.png">
                        </div>
                        <h2 class="font-size-16">یک دوره رژیم رایگان</h2>
                    </div>
                </div>
                <div class="redItem desktopVersion progressive">
                    <img class="progressive__img progressive--is-loaded" data-progressive="img/bottomPinkShape.svg" src="img/bottomPinkShape.svg">
                </div>
            </div>
            
            <div class="normalHeader relative organizer">
                <h2 class="font-size-18 boldFont">سوالات متداول</h2>
            </div>
            <div class="questions relative">
                <div class="mediumSizeHandler">
                    <div class="questionBox">
                        <span class="questionNumber boldFont brownColor">۱</span>
                        <div class="question boldFont">
                            از کجا باید شروع کنم و چیکار کنم?
                        </div>
                        <div class="answer lightFont organizer">
                            فقط کافیه از بالای همین صفحه ثبت نام رو انجام بدی و توی مراحل بعدی اطلاعاتتو وارد کنی.
                            بعدش برات یه پرونده تشکیل میشه که کارشناس‌هامون طبق اون، رژیم اختصاصیت رو طبق مزاج خودت
                            تنظیم میکنن. به محض اینکه آماده بشه خبرت میکنیم :)
                        </div>
                    </div>
                    <div class="questionBox">
                        <span class="questionNumber boldFont brownColor">۲</span>
                        <div class="question boldFont">
                            بعد از اینکه رژیممو گرفتم، اگه سوال یا مشکلی برام پیش اومد چطوری میتونم باهاتون درمیون
                            بذارم؟
                        </div>
                        <div class="answer lightFont organizer">
                            نگران نباش! پشتیبان‌های ما بصورت تلفنی، آنلاین و حتی از طریق واتس اپ آماده پاسخ دادن به
                            سوالاتت هستن
                        </div>
                    </div>
                    <div class="questionBox">
                        <span class="questionNumber boldFont brownColor">۳</span>
                        <div class="question boldFont">
                            اگه مثل برنامه رژیم‌تون پیش رفتم، ولی جواب نگرفتم تکلیف چیه؟
                        </div>
                        <div class="answer lightFont organizer">
                            هدف اصلی مجموعه ازشنبه رضایت شماست. اگه به هر دلیلی ناراضی باشین، ما تمام وقت پاسخگوی
                            مشکلات شما هستیم؛ ولی باید بگیم که برنامه هامون مبنای علمی دارن و مختص شرایط بدنی شما
                            طراحی میشن؛ پس دلیلی نداره که جواب نده! از این بابت خیالتون راحت باشه
                        </div>
                    </div>
                    <div class="questionBox">
                        <span class="questionNumber boldFont brownColor">۴</span>
                        <div class="question boldFont">
                            من موهام خیلی ریزش دارن، اگر رژیم شمارو بگیرم ریزشم بیشتر نمیشه؟ پوستم خراب نمیشه؟
                        </div>
                        <div class="answer lightFont organizer">
                            این سوالیه که خیلیا میپرسن. در جوابش باید بگیم که رژیم هامون کاملا استاندارد هستن و روی
                            همه‌ی جوانب قبلا فکر کردیم. اما بازم اگه مسئله حادی داشتین میتونین حتما با پشتیبان‌هامون
                            درمیون بذارین و طبق اون رژیمتونو بگیرید. چون رژیم ما بصورت جداگانه برای هر کس طراحی میشه
                        </div>
                    </div>
                </div>
                {{-- <div class="paddingSpace desktopTextCenter">
                            <button type="submit" class="greenBackColor whiteColor organizer register">
                                <span class="rightFloat font-size-14 boldFont">مشاهده سوالات بیشتر</span>
                                <span class="icon icon-forward font-size-18 leftFloat"></span>
                            </button>
                        </div> --}}

                <div class="weightItem desktopVersion">
                    <img src="img/weight.png">
                </div>
            </div>
            <div class="normalHeader relative organizer">
                <h2 class="font-size-18 boldFont">ویژگی های از شنبه</h2>
            </div>
            <div class="organizer textInCenter">
                <div class="items">
                    <div class="itemBox">
                        <div class="itemImage">
                            <img src="img/diet.svg">
                        </div>
                        <h2 class="font-size-16">تهیه رژیم شما به صورت اختصاصی</h2>
                    </div>
                    <div class="itemBox">
                        <div class="itemImage">
                            <img src="img/eggs.svg">
                        </div>
                        <h2 class="font-size-16">کارشناس تغذیه همراه شما</h2>
                    </div>
                    <div class="itemBox">
                        <div class="itemImage">
                            <img src="img/thumb.svg">
                        </div>
                        <h2 class="font-size-16">رضایت بالای مشتریان ما</h2>
                    </div>
                    <div class="itemBox">
                        <div class="itemImage">
                            <img src="img/success2.svg">
                        </div>
                        <h2 class="font-size-16">اجرای بیش از صد رژیم موفق</h2>
                    </div>
                </div>
                <div class="redItem desktopVersion dsm-none">
                    <img src="img/bottomPinkShape.svg">
                </div>
            </div>

        </div>

        <footer class="d-flex flex-wrap justify-content-center align-items-center mt-5 w-100">
            <img src="img/footer26.png" class="w-100 mt-5" alt="">
            <div class="w-100 d-flex flex-wrap justify-content-center pb-5 box-bmi">
                <div class="footer-section d-flex flex-wrap"> 
                    <div class="d-flex flex-wrap align-content-start w-32">
                        <!--begin::contact-us-form-->
                            @include('contact-us-form')
                        <!--end::contact-us-form-->
                    </div>
                    <div class="d-flex flex-wrap align-content-start px-3 w-32">
                        <header class="w-100 mb-3">
                            <h5 class="font-size-18 redColor">دسترسی ها</h5>
                        </header>
                        <ul class="d-flex flex-wrap">
                            <li class="w-100 d-flex align-items-center mb-3"><a href="https://azshanbe.me/about" title="درباره ما">درباره ما</a></li>
                            <li class="w-100 d-flex align-items-center mb-3"><a href="https://azshanbe.me/contact" title="تماس با ما">تماس با ما</a></li>
                            <li class="w-100 d-flex align-items-center mb-3"><a href="https://azshanbe.me/#change_users_style" title="تغییرات مراجعین">تغییرات مراجعین</a></li>
                            <li class="w-100 d-flex align-items-center mb-3"><a href="https://azshanbe.me/mag/" title="مطالب آموزشی">مطالب آموزشی</a></li>
                            <li class="w-100 d-flex align-items-center mb-3"><a href="https://azshanbe.me/terms" title="قوانین و مقررات">قوانین و مقررات</a></li>
                        </ul>
                    </div>
                    <div class="d-flex flex-wrap align-content-start px-3 mb-5 w-32">
                        <header class="w-100 mb-3">
                            <h5 class="font-size-18 redColor">اطلاعات تماس</h5>
                        </header>
                        <ul class="d-flex flex-wrap">
                            <li class="d-flex align-items-center mb-3 w-100">
                                <svg version="1.1" id="Capa_1" class="w-25px ml-3" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                        viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path d="M256,0C148.477,0,61,87.477,61,195c0,69.412,21.115,97.248,122.581,231.01C201.194,449.229,221.158,475.546,244,506
                                                c2.833,3.777,7.279,6,12.001,6c4.722,0,9.167-2.224,12-6.002c22.708-30.29,42.585-56.507,60.123-79.638
                                                C429.834,292.209,451,264.292,451,195C451,87.477,363.523,0,256,0z M304.219,408.235c-14.404,18.998-30.383,40.074-48.222,63.789
                                                c-17.961-23.867-34.031-45.052-48.515-64.146C108.784,277.766,91,254.321,91,195c0-90.981,74.019-165,165-165s165,74.019,165,165
                                                C421,254.205,403.17,277.722,304.219,408.235z"/>
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path d="M256,90c-57.897,0-105,47.103-105,105c0,57.897,47.103,105,105,105c57.897,0,105-47.103,105-105
                                                C361,137.103,313.897,90,256,90z M256,270c-41.355,0-75-33.645-75-75s33.645-75,75-75c41.355,0,75,33.645,75,75
                                                S297.355,270,256,270z"/>
                                        </g>
                                    </g>
                                </svg>
    
                                تهران شریعتی حسینه ارشاد کوچه هدیه پلاک 3 ، طبقه 4 ، واحد ازشنبه 
                            </li>
                            <li class="d-flex align-items-center mb-3 w-100">
                                <svg version="1.1" id="Capa_1" class="w-25px ml-3" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 405.333 405.333" style="enable-background:new 0 0 405.333 405.333;" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path d="M373.333,266.88c-25.003,0-49.493-3.904-72.725-11.584c-11.328-3.904-24.171-0.896-31.637,6.699l-46.016,34.752
                                                c-52.779-28.16-86.571-61.931-114.389-114.368l33.813-44.928c8.512-8.533,11.563-20.971,7.915-32.64
                                                C142.592,81.472,138.667,56.96,138.667,32c0-17.643-14.357-32-32-32H32C14.357,0,0,14.357,0,32
                                                c0,205.845,167.488,373.333,373.333,373.333c17.643,0,32-14.357,32-32V298.88C405.333,281.237,390.976,266.88,373.333,266.88z
                                                M384,373.333c0,5.888-4.8,10.667-10.667,10.667c-194.091,0-352-157.909-352-352c0-5.888,4.8-10.667,10.667-10.667h74.667
                                                c5.867,0,10.667,4.779,10.667,10.667c0,27.243,4.267,53.995,12.629,79.36c1.237,3.989,0.235,8.107-3.669,12.16l-38.827,51.413
                                                c-2.453,3.264-2.837,7.637-0.981,11.264c31.637,62.144,70.059,100.587,132.651,132.651c3.605,1.877,8.021,1.493,11.285-0.981
                                                l52.523-39.808c2.859-2.816,7.061-3.797,10.859-2.539c25.515,8.427,52.267,12.693,79.531,12.693
                                                c5.867,0,10.667,4.779,10.667,10.667V373.333z"/>
                                        </g>
                                    </g>
                                </svg>
    
                                <a href="tel:02123051172" title="021-23051172"> 021-23051172 </a> 
                            </li>
                            <li class="d-flex align-items-center mb-3 w-100">
                                <svg version="1.1" id="Capa_1" class="w-25px ml-3" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                        viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path d="M502.747,74.024H9.253C4.143,74.024,0,78.167,0,83.277v345.446c0,4.998,3.965,9.059,8.92,9.236
                                                c0.096,0.011,0.205,0.017,0.333,0.017h493.494c5.111,0,9.253-4.143,9.253-9.253V83.277C512,78.167,507.858,74.024,502.747,74.024z
                                                M480.409,92.53L256,316.939L31.591,92.53H480.409z M493.494,406.384L373.58,286.47c-3.615-3.614-9.473-3.614-13.086,0
                                                c-3.614,3.614-3.614,9.473,0,13.085L480.409,419.47H31.591l119.915-119.915c3.614-3.614,3.614-9.473,0-13.085
                                                c-3.614-3.614-9.473-3.614-13.085,0L18.506,406.385v-300.77l230.951,230.951c1.806,1.806,4.175,2.711,6.542,2.711
                                                c2.368,0,4.736-0.903,6.544-2.711l230.95-230.95V406.384z"/>
                                        </g>
                                    </g>
                                </svg>
                                info@azshanbe.me 
                            </li>
                            <li class="d-flex align-items-center mb-3 w-100">
                                <ul class="d-flex align-items-center flex-wrap social-footer justify-content-center">
                                    <li class=" ml-3"><a href="http://instagram.com/azshanbe.me/" class="instagram-footer d-flex align-items-center justify-content-center" title="اینستاگرام ازشنبه"><i class="icon icon-instagram"></i></a></li>
                                    <li>
                                        <a href="https://bit.ly/2XsNjDj" class="whatsapp-footer d-flex align-items-center justify-content-center" title="ارتباط با پشتیبان">
                                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="15px" y="15px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                <path style="fill:#FAFAFA;" d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104
                                                        l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z"></path>
                                                <path style="fill:#4CAF50;" d="M405.024,361.504c-6.176,17.44-30.688,31.904-50.24,36.128c-13.376,2.848-30.848,5.12-89.664-19.264
                                                C189.888,347.2,141.44,270.752,137.664,265.792c-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624,26.176-62.304
                                                c6.176-6.304,16.384-9.184,26.176-9.184c3.168,0,6.016,0.16,8.576,0.288c7.52,0.32,11.396,0.768,16.256,12.64
                                                c6.176,14.88,21.216,51.616,23.008,55.392c1.824,3.776,3.648,8.896,1.088,13.856c-2.4,5.12-4.512,7.392-8.288,11.744
                                                c-3.776,4.352-7.36,7.68-11.136,12.352c-3.456,4.064-7.36,8.416-3.008,15.936c4.352,7.36,19.392,31.904,41.536,51.616
                                                c28.576,25.44,51.744,33.568,60.032,37.024c6.176,2.56,13.536,1.952,18.048-2.848c5.728-6.176,12.8-16.416,20-26.496
                                                c5.12-7.232,11.584-8.128,18.368-5.568c6.912,2.4,43.488,20.48,51.008,24.224c7.52,3.776,12.48,5.568,14.304,8.736
                                                C411.2,339.152,411.2,344.032,405.024,361.504z"></path>
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="d-flex align-items-center mb-3 w-100">
                                <ul>
                                    <li>
                                        <img id = 'jxlzfukzwlaosizpfukzjxlz' style = 'cursor:pointer' onclick = 'window.open("https://logo.samandehi.ir/Verify.aspx?id=164961&p=rfthgvkaaodspfvlgvkarfth", "Popup","toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")' alt = 'logo-samandehi' src = 'https://logo.samandehi.ir/logo.aspx?id=164961&p=nbpdwlbqshwlbsiywlbqnbpd' />
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    <div class="signIn tempDisable">
        <div class="loginBox">
            <div class="popUpClose desktopVersion cursor-pointer close-modal" data-target=".signIn"></div>
            <form class="loginForm">
                <div class="popUpBoxHeader font-size-18 boldFont organizer desktopVersion">
                    <div class="popUpBoxTitle rightFloat">
                        ثبت نام
                    </div>
                    <div class="popUpBoxCross leftFloat">
                        <span class="icon icon-close cursor-pointer close-modal" data-target=".signIn"></span>
                    </div>
                </div>
                <div class="loginFormInner">
                    <input class="organizer input azshanbeInput" type="text" placeholder="نام و نام خانوادگی">
                    <div class="valuableInput relative organizer">
                        <input class="input numberInput azshanbeInput" type="text" placeholder="شماره همراه">
                        <span class="valueInInput">
                            <span class="separator"></span>
                            +۹۸
                        </span>
                    </div>
                    <input class="organizer input azshanbeInput" type="text" placeholder="کد تایید">
                    <div class="confirmationTimer organizer">
                        <div class="timer inlineView middleContext font-size-14 boldFont">۰۰:۵۸</div>
                        <div class="progressLine inlineView middleContext">
                            <div class="innerLine greenBackColor"></div>
                        </div>
                    </div>
                    <div class="organizer">
                        <div class="resendCode rightFloat boldFont greenColor">
                            <span class="icon icon-repeat"></span>
                            ارسال مجدد کد
                        </div>
                        <div class="changeNumber leftFloat boldFont darkPinkColor">
                            <span class="icon icon-pencil"></span>
                            تغییر شماره
                        </div>
                    </div>

                    <div class="readAgreement font-size-14 lightFont organizer">
                        درصورت ثبت نام شما با <span class="darkPinkColor underline boldFont">ضوابط و قوانین</span>
                        از
                        شنبه
                        موافقت کرده اید
                    </div>

                    <button type="submit" class="greenBackColor whiteColor organizer register">
                        <span class="rightFloat font-size-14 boldFont">شروع ثبت نام</span>
                        <span class="icon icon-forward font-size-18 leftFloat"></span>
                    </button>

                </div>
                <div class="registerFix textInCenter">
                    اگر حساب کاربری دارید از اینجا <span class="boldFont underline greenColor">وارد شوید</span>
                </div>
            </form>

        </div>
    </div>
</div>
<div class="pos-fixed justify-content-center flex-wrap bg-white mm-menu">
    <div class="popUpClose desktopVersion cursor-pointer close-modal" data-target=".mm-menu"></div> 
    <header class="w-100 d-flex flex-wrap justify-content-center align-items-center py-3">
        <h4 class="font-size-24 redColor"> از شنبه </h4>
        <span class="w-100 greenColor font-16 d-flex justify-content-center">به وزن ایده آلت برس</span>
    </header>
    <ul class="w-100 d-flex flex-wrap mm-menu-items px-5 my-3">
        <li class="pos-relative w-100 d-flex align-items-center pr-4">
            <a href="https://azshanbe.me/" class="custom-font-gray" title="صفحه اصلی"> صفحه اصلی </a>
        </li>
        <li class="pos-relative w-100 d-flex align-items-center pr-4">
            <a href="https://azshanbe.me/login" class="custom-font-gray" title="ورود اعضا"> ورود اعضا </a>
        </li>
        <li class="pos-relative w-100 d-flex align-items-center pr-4">
            <a href="https://azshanbe.me/mag/" class="custom-font-gray" title="مجله ازشنبه"> مجله ازشنبه </a>
        </li>
        <li class="pos-relative w-100 d-flex align-items-center pr-4">
            <a href="https://azshanbe.me/contact" class="custom-font-gray" title="تماس با ما"> تماس با ما </a>
        </li>
        <li class="pos-relative w-100 d-flex align-items-center pr-4">
            <a href="https://azshanbe.me/about" class="custom-font-gray" title="درباره ما"> درباره ما </a>
        </li>
        <li class="pos-relative w-100 d-flex align-items-center pr-4">
            <a href="https://azshanbe.me/terms" class="custom-font-gray" title="قوانین و مقررات"> قوانین و مقررات </a>
        </li>
        <li class="pos-relative w-100 d-flex align-items-center pr-4">
            <a href="https://azshanbe.me/contact" class="custom-font-gray" title="ثبت شکایات"> ثبت شکایات </a>
        </li>
    </ul>
    <footer>
        <span class="d-flex align-items-center justify-content-center close-btn-mm-menu cursor-pointer close-modal" data-target=".mm-menu">
            بستن
        </span>
    </footer>
</div>

<div class="fixed-reg-btn goto-reg-btn">
    <a href="https://azshanbe.me/#SignInBox">دریافت رژیم</a>
</div>

<a href="https://bit.ly/2XsNjDj" target="_blank" class="custom-support-btn" title="ارتباط با پشتیبان">
    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="30px" y="30px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
        <path style="fill:#FAFAFA;" d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104
				l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z"></path>
        <path style="fill:#4CAF50;" d="M405.024,361.504c-6.176,17.44-30.688,31.904-50.24,36.128c-13.376,2.848-30.848,5.12-89.664-19.264
				C189.888,347.2,141.44,270.752,137.664,265.792c-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624,26.176-62.304
				c6.176-6.304,16.384-9.184,26.176-9.184c3.168,0,6.016,0.16,8.576,0.288c7.52,0.32,11.396,0.768,16.256,12.64
				c6.176,14.88,21.216,51.616,23.008,55.392c1.824,3.776,3.648,8.896,1.088,13.856c-2.4,5.12-4.512,7.392-8.288,11.744
				c-3.776,4.352-7.36,7.68-11.136,12.352c-3.456,4.064-7.36,8.416-3.008,15.936c4.352,7.36,19.392,31.904,41.536,51.616
				c28.576,25.44,51.744,33.568,60.032,37.024c6.176,2.56,13.536,1.952,18.048-2.848c5.728-6.176,12.8-16.416,20-26.496
				c5.12-7.232,11.584-8.128,18.368-5.568c6.912,2.4,43.488,20.48,51.008,24.224c7.52,3.776,12.48,5.568,14.304,8.736
				C411.2,339.152,411.2,344.032,405.024,361.504z"></path>
    </svg>
</a>
@endsection