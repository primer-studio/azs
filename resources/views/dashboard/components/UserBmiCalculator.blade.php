<div class="d-flex flex-wrap align-items-center justify-content-center w-100 px-3 py-4 box-bmi">
    <div class="d-flex flex-wrap align-items-center justify-content-center w-100 box-form-bmi">
        <div class="d-flex algin-items-center ml-4">
            <img src="img/وزن-ایده-آل.png" alt="" title="">
        </div>
        <div id="{{ $id }}" class="bmi-calculator-container">
            <div class="d-flex align-items center flex-wrap">
                <div class="radioOption ">
                    <label class="custom-radio1 box-input pos-relative d-flex align-items-center position-relative " for="male">
                        <input name="gender" type="radio" value="male" id="male">
                        <span class="pos-relative d-flex align-items-center justify-content-center bullet2"></span>
                        <span class="text">آقا هستم</span>
                    </label>
                </div>
                <div class="radioOption ">
                    <label class="custom-radio1 box-input pos-relative d-flex align-items-center position-relative " for="female">
                        <input name="gender" type="radio" value="female" id="female">
                        <span class="pos-relative d-flex align-items-center justify-content-center bullet2"></span>
                        <span class="text">خانم هستم</span>
                    </label>
                </div>
            </div>
            <div class="d-flex align-items center flex-wrap box-item-input-bmi">
                <label for="weight" class="pos-relative d-flex align-items-center">
                    <span class="pos-absolute d-flex align-items-center px-3 mb-2">
                        <img src="img/weight.svg" alt="" title="">
                        وزن
                    </span>
                    <input type="number" id="weight" maxlength="3" class="weight w-100 input numberInput azshanbeInput pr-5" placeholder="کیلو گرم">
                </label>
                <label for="height" class="pos-relative d-flex align-items-center">
                    <span class="pos-absolute d-flex align-items-center px-3 mb-2">
                        <img src="img/centimeter.svg" alt="" title="">
                        قـد
                    </span>
                    <input type="number" id="height" maxlength="3" class="height w-100 input numberInput azshanbeInput pr-5" placeholder="سانتی متر">
                </label>
            </div>
            <div class="d-flex align-items center flex-wrap box-item-input-bmi">
                <label for="age" class="pos-relative d-flex align-items-center">
                    <span class="pos-absolute d-flex align-items-center px-3 mb-2">
                        <img src="img/agenda.svg" alt="" title="">
                        سن
                    </span>
                    <input type="age" id="age" maxlength="3" class="age input w-100 numberInput azshanbeInput pr-5" placeholder="سال">
                </label>
                <label for="wrist" class="pos-relative d-flex align-items-center">
                    <span class="pos-absolute d-flex align-items-center px-3 mb-2">
                        <img src="img/success.svg" alt="" title="">
                        دور مـچ
                    </span>
                    <input type="wrist" id="wrist" maxlength="3" class="wrist input w-100  numberInput azshanbeInput pr-5" placeholder="سانتی متر">
                </label>
            </div>
        
            <button class="submit redBackColor whiteColor organizer w-50 d-flex align-items-center justify-content-center cursor-pointer btn-result-bmi">
                محاسبه کن
            </button>
        </div>
    </div>
    <div class="d-none flex-wrap align-items-center justify-content-center box-res-bmi w-100">
        <div class="d-flex align-items-center justify-content-center w-100 mb-4">
            <ul class="d-flex align-items-center justify-content-center flex-wrap list-result-bmi">
                <li class="d-felx align-items-center justify-content-center">
                    <div class="d-flex flex-wrap w-100 res">
                        <p class="d-flex align-items-center justify-content-center w-100 p-title p-title-fit"><span>میزان اضافه وزن شما</span></p>
                        <p class="d-flex align-items-center justify-content-center w-100 p-resulte-value p-resulte-value-fit redColor">
                            <span></span> <small>کیلو گرم</small>
                        </p>
                    </div>
                </li>
                <li class="d-none align-items-center justify-content-center">
                    <div class="d-flex flex-wrap w-100 res">
                        <p class="d-flex align-items-center justify-content-center w-100 p-title"><span>وزن مناسب برای شما</span></p>
                        <p class="d-flex align-items-center justify-content-center w-100 p-resulte-value p-resulte-value-desired goldColor">
                            <span></span> <small>کیلو گرم</small>
                        </p>
                    </div>
                </li>
                <li class="d-none align-items-center justify-content-center">
                    <div class="d-flex flex-wrap w-100 res">
                        <p class="d-flex align-items-center justify-content-center w-100 p-title"><span>وزن شما</span></p>
                        <p class="d-flex align-items-center justify-content-center w-100 p-resulte-value p-resulte-value-weight green">
                            <span class=""></span> <small>کیلو گرم</small>
                        </p>
                    </div>
                </li>
                <li class="d-none align-items-center justify-content-center">
                    <div class="d-flex flex-wrap w-100 res">
                        <p class="d-flex align-items-center justify-content-center w-100 p-title"><span>شاخص توده بدن</span></p>
                        <p class="d-flex align-items-center justify-content-center w-100 p-resulte-value p-resulte-value-bmi pinkColor">
                            <span></span>
                        </p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="d-flex align-items-center justify-content-center w-100 box-link-bmi">
            <ul class="d-flex align-items-center justify-content-center flex-wrap">
                <li class="d-felx align-items-center justify-content-center mx-5 mb-2"><p class="redColor font-size-16">پس همین الان رژیمتو شروع کن</p></li>
                <li class="d-felx align-items-center justify-content-center mx-5 mb-2">
                    <a href="https://azshanbe.me/#SignInBox" title="دریافت رژیم اختصاصی شما" class="submit greenBackColor whiteColor organizer px-3 pb-1 d-flex align-items-center justify-content-center cursor-pointer btn-result-bmi">
                        دریافت رژیم اختصاصی شما
                    </a>
                </li>
                <li class="d-felx align-items-center justify-content-center mx-5 mb-2">
                    <span class="cursor-pointer font-size-14 re-test-bmi">
                        دوباره محسابه کن
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>


@pushonce('scripts:/dashboard-assets/js/bmi/bmi.js?v=1.0.13')
<script src="{{  asset('/dashboard-assets/js/bmi/bmi.js?v=1.0.13') }}"></script>
@endpushonce

@push('scripts')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            $("#{{ $id }}").bmiCalculator();
        });
    </script>
@endpush
