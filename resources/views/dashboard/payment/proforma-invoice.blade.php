<div class="smallPaddingSpace organizer whiteBackColor relative mb-3 border-radius-10">
    <div class="paymentBack">
        <img class="mobileVersion" src="img/bottomPaymentShadow.svg">
        <img class="desktopVersion" src="img/bottomPaymentShadow_desktop.svg">
    </div>
    <div class="tinySizeHandler w-100">
        <div class="organizer d-flex justify-content-between py-3">
            <div class="paymentTitle organizer d-flex align-items-center">
                <div class="paymentImage">
                    <img src="img/credit-cards-payment.svg">
                </div>
                <div class="paymentDescription d-flex align-items-center font-size-14 mr-1">
                    &#1662;&#1585;&#1583;&#1575;&#1582;&#1578;
                </div>
            </div>
            <div class="stepBack font-size-11 cursor-pointer" onclick="window.history.go(-1); return false;">
                <span class="icon icon-backward middleContext ml-2"></span>
                &#1605;&#1585;&#1581;&#1604;&#1607; &#1602;&#1576;&#1604;
            </div>
        </div>


        <!--begin::diets-->
        <div class="d-flex flex-wrap w-100 mb-2 boxbegin-dites">
            @forelse($diets as $diet)
                <div class="d-flex align-items-center justify-content-between w-100 mb-1 px-2 py-2">
                    <div class="font-size-14">
                        {{ $diet->title }} @lang('validation.attributes.period') {{ $diet->selected_period->period }}
                    </div>
                    <div class="d-flex align-items-center font-size-14">
                        <span class="price font-size-14">{{ money($diet->selected_period->price, true) }} &#1578;&#1608;&#1605;&#1575;&#1606;</span>

                        @php
                            $form_id = "remove-cart-item-form-" . $diet->id . "-" . $diet->selected_period->period;
                        @endphp

                        @UserAjaxForm(['form_id' => $form_id, 'is_update' => false ])@endUserAjaxForm
                        <form id="{{ $form_id }}" class="remove-cart-item-form" method="post"
                              action="{{ route('dashboard.proforma-remove-diet-from-cart') }}">
                            @csrf
                            <input type="hidden" name="diet_id" value="{{ $diet->id }}">
                            <input type="hidden" name="period" value="{{  $diet->selected_period->period  }}">
                            {{-- <button class="submit-button paymentButton whiteColor orangeBack cursor-pointer mr-3" type="button">
                                <span class="middleContext">
                                    &#1581;&#1584;&#1601;
                                </span>
                            </button> --}}
                        </form>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning text-center mt-2">
                    &#1585;&#1688;&#1740;&#1605;&#1740; &#1576;&#1585;&#1575;&#1740; &#1662;&#1585;&#1583;&#1575;&#1582;&#1578;
                    &#1608;&#1580;&#1608;&#1583; &#1606;&#1583;&#1575;&#1585;&#1583;
                </div>
            @endforelse
        </div>

        <div class="paymentFinish organizer p-none mb-3">
            <div class="tinySizeHandler w-100">
                @php
                    $helper = new \App\Libraries\ProfileHelper();
                    $user_has_active_discount = DB::table('user_discounts')->where([
                        'profile_id' => $helper->getCurrentProfile()->id,
                        'is_valid' => 1,
                    ])->latest()->first();
                    if(!is_null($user_has_active_discount)) {
                        $discount_code = \App\Discount::where('id', $user_has_active_discount->discount_id)->first();
                         if ($discount_code->is_active) {
                            if ($discount_code->type == 'simple') {
                                $new_total = money($total_diets_amount - (float) $discount_code->amount, true);
                            } elseif ($discount_code->type == 'percentage') {
                                $new_total = money($total_diets_amount - ($total_diets_amount * ($discount_code->amount/100)), true);
                            } else {
                                $new_total = money($total_diets_amount, true);
                            }
                        }
                    }
                @endphp
                @if(!is_null($user_has_active_discount) && $discount_code->is_active)
                    <div id="discount-wrapper" class="mainQuestionBox">
                        <p>شما کد تخفیف فعال دارید و به سبد خریدتان اعمال شده است.</p>
                        <p class="font-size-14">
                            مبلغ بدون تخفیف: {{ money($total_diets_amount, true) }}
                        </p>
                    </div>
                @else
                <div id="discount-wrapper" class="mainQuestionBox organizer">
                    <div class="questionInner d-flex">
                        <p class="fullWidth">
                            <span class="float-right">کد تخفیف دارید؟</span>
                            <span class="float-right">
                                <input id="discount-code" name="height" type="text"
                                       class="input azshanbeInput"
                                       placeholder="اینجا وارد نمایید.">
                            </span>
                            <span class="float-left">
                                <a onclick="SetDiscountCode()" style="padding: 10px 20px; border-radius: 5px; font-size: 15px; cursor: pointer;" class="d-flex align-items-center justify-content-center a-checkout">
                                    اعمال کد
                                </a>
                            </span>
                        </p>
                    </div>
                    <div class="fullWidth">
                        <span id="discount-message" style="display: none"></span>
                    </div>
                    <script>
                        function SetDiscountCode() {
                            let discount_code = document.querySelector('#discount-code').value;
                            let msg = document.querySelector('#discount-message');
                            let final_price = document.querySelector('#final-amount');
                            let payment_final_price = document.querySelector('#pay-button-final-price');
                            const params = {
                                code: discount_code
                            }
                            var xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    let res = JSON.parse(this.responseText);
                                    if (res.status == 200) {
                                        msg.innerText = res.message;
                                        msg.style.color = '#535353';
                                        msg.style.display = 'block';
                                        final_price.innerText = res.new_total + ' تومان';
                                        payment_final_price.innerHTML = 'پرداخت آنلاین ( ' + res.new_total + ' تومان )';
                                        setTimeout(function () {
                                            document.querySelector('#discount-wrapper').style.display = 'none'
                                        }, 1000);
                                    } else {
                                        msg.style.display = 'block';
                                        msg.style.color = '#f1416c';
                                        msg.innerText = res.message;
                                    }

                                }
                            };
                            xhttp.open("POST", "{{ route('dashboard.set-order-discount') }}", true);
                            xhttp.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            xhttp.send('code='+discount_code);
                        }
                    </script>
                </div>
                @endif

                <div
                    class="flexDesktop organizer d-flex justify-content-between align-items-center flex-wrap positionsticpayment">
                    <div class="paymentPrice font-size-14 d-flex align-items-center justify-content-center px-3 w-100">
                        &#1605;&#1576;&#1604;&#1594; &#1602;&#1575;&#1576;&#1604; &#1662;&#1585;&#1583;&#1575;&#1582;&#1578;
                        @if($vat)
                            &#1605;&#1580;&#1605;&#1608;&#1593;: <span>{{ money($total_diets_amount, true) }}</span>
                            &#1605;&#1575;&#1604;&#1740;&#1575;&#1578; &#1576;&#1585; &#1575;&#1585;&#1586;&#1588;
                            &#1575;&#1601;&#1586;&#1608;&#1583;&#1607;: <span>{{ money($vat, true) }}</span>
                        @endif
                        <p id="final-amount" class="paymentNumber font-size-18 boldFont inlineDesktopMode ">@if(isset($new_total)) {{ $new_total }} @else {{ money($total_amount, true) }} @endif
                            &#1578;&#1608;&#1605;&#1575;&#1606;</p>
                    </div>


                    <!--begin::online payments-->
                    <div class="d-flex flex-wrap w-100 mt-3 px-3 py-3 network-pay">
                        <div class="d-flex align-items-center justify-content-between w-100 mb-3 pb-2 box-network-sell">
                            <div class="d-flex flex-wrap ">
                                <p class="d-flex font-size-14">
                                    &#1662;&#1585;&#1583;&#1575;&#1582;&#1578; &#1575;&#1740;&#1606;&#1578;&#1585;&#1606;&#1578;&#1740;
                                </p>
                                <span class="w-100 d-flex font-size-14">
                                    &#1662;&#1585;&#1583;&#1575;&#1582;&#1578; &#1575;&#1586; &#1591;&#1585;&#1740;&#1602; &#1583;&#1585;&#1711;&#1575;&#1607; &#1576;&#1575;&#1606;&#1705; &#1605;&#1585;&#1705;&#1586;&#1740;. &#1587;&#1585;&#1740;&#1593;&#1548; &#1570;&#1606;&#1740; &#1608; &#1705;&#1575;&#1605;&#1604;&#1575; &#1575;&#1740;&#1605;&#1606;
                                </span>
                            </div>
                            <img src="img/GetImage.aspx.jpg" alt="">
                        </div>
                        <div class="w-100" style="text-align: right; margin-right: 3%;">
                            <label for=""></span> درگاه پرداخت را
                                انتخاب نمایید.</label>
                            <select id="choosed_gateway" onchange="ChooseGateWay(this)"
                                    class="form-select form-select-lg mb-3" aria-label="درگاه پرداخت را انتخاب نمایید."
                                    style="
                                        width: 30%;
                                        padding: 1%;
                                        border-radius: 2px;
                                        border: 1px solid #d3d3d3;
                                        background: #ffffff91;
                                        color: #61c9a8;
                                        font-weight: 800;
                                        font-family: inherit;
                                    ">
                                <option value="0" selected>انتخاب درگاه</option>
                                @foreach($payment_gateways->reverse() as $payment_gateway)
                                    <option id="{{ $payment_gateway->short_name }}"
                                            data-src="{{ $payment_gateway->image }}" value="{{ $payment_gateway->id }}">
                                        <img src="{{ $payment_gateway->image }}" alt="">{{ $payment_gateway->title }}
                                    </option>
                                @endforeach
                            </select>
                            <img src="" id="payment-gatway-image" alt="" style="max-width: 30px; margin-bottom: 1%;">
                        </div>
                        <script>
                            function ChooseGateWay(current_obj) {
                                console.log(current_obj.options.selectedIndex)
                                var e = document.getElementById("choosed_gateway");
                                var value = e.value;
                                var text = e.options[e.selectedIndex].text;
                                if (value != 0) {
                                    document.getElementById('payment_gateway').value = value;
                                    document.getElementById('paymentButton').style.removeProperty('background');
                                    document.getElementById('paymentButton').disabled = false;
                                    var img_alt = $(e).find('option:selected').data('src');
                                    document.getElementById('payment-gatway-image').setAttribute('src', img_alt);
                                } else {
                                    document.getElementById('payment_gateway').value = '';
                                    document.getElementById('paymentButton').style.background = '#c3c3c3';
                                    document.getElementById('paymentButton').disabled = true;
                                    document.getElementById('payment-gatway-image').setAttribute('src', '');
                                }
                            }
                        </script>
                        <div class="d-flex justify-content-center align-items-center w-100">
                            <form method="post" class="w-100" action="{{ route('dashboard.pay-ipg') }}">
                                @csrf
                                <input id="payment_gateway" type="hidden" name="payment_gateway" value="">
                                <button
                                    disabled
                                    style="background: #c3c3c3"
                                    id="paymentButton"
                                    class="paymentButton w-100 whiteColor orangeBack cursor-pointer d-flex align-items-center justify-content-between paymentbtn w-100"
                                    type="submit">
                                    <span class="icon icon-card middleContext"></span>
                                    {{--                                            <span class="middleContext">--}}
                                    {{--                                                &#1662;&#1585;&#1583;&#1575;&#1582;&#1578; &#1576;&#1575; {{ $payment_gateway->title }}--}}
                                    {{--                                            </span>--}}
                                    <span id="pay-button-final-price" class="middleContext">
                                            &#1662;&#1585;&#1583;&#1575;&#1582;&#1578; &#1570;&#1606;&#1604;&#1575;&#1740;&#1606; ( @if(isset($new_total)) {{ $new_total }} @else {{ money($total_amount, true) }} @endif &#1578;&#1608;&#1605;&#1575;&#1606; )
                                        </span>
                                    <span class="icon icon-forward middleContext"></span>
                                </button>
                            </form>
                        @forelse($payment_gateways as $payment_gateway)
                            <!--
                                <div class="w-100" class="pay-through" id="pay-through-{{ $payment_gateway->id }}"
                                     style="display: none">
                                    <form method="post" class="w-100" action="{{ route('dashboard.pay-ipg') }}">
                                        @csrf
                                <input id="payment_gateway" type="hidden" name="payment_gateway" value="{{ $payment_gateway->id }}">
                                        <button
                                            class="paymentButton w-100 whiteColor orangeBack cursor-pointer d-flex align-items-center justify-content-between paymentbtn w-100"
                                            type="submit">
                                            <span class="icon icon-card middleContext"></span>
{{--                                            <span class="middleContext">--}}
                            {{--                                                &#1662;&#1585;&#1583;&#1575;&#1582;&#1578; &#1576;&#1575; {{ $payment_gateway->title }}--}}
                            {{--                                            </span>--}}
                                <span class="middleContext">
&#1662;&#1585;&#1583;&#1575;&#1582;&#1578; &#1570;&#1606;&#1604;&#1575;&#1740;&#1606; ( {{ money($total_amount, true) }} &#1578;&#1608;&#1605;&#1575;&#1606; )
                                        </span>
                                            <span class="icon icon-forward middleContext"></span>
                                        </button>
                                    </form>
                                </div>
                                !-->
                            @empty
                                <div>
                                    &#1583;&#1585;&#1711;&#1575;&#1607; &#1662;&#1585;&#1583;&#1575;&#1582;&#1578;
                                    &#1570;&#1606;&#1604;&#1575;&#1740;&#1606; &#1601;&#1593;&#1575;&#1604;&#1740;
                                    &#1608;&#1580;&#1608;&#1583; &#1606;&#1583;&#1575;&#1585;&#1583;
                                </div>
                            @endforelse
                        </div>

                    </div>

                    <!--end::online payments-->
                </div>
            </div>
        </div>

        <!--end::diets-->


        @if(!empty($diets->count()))

            <div class="paymentFinish p-none mt-3 organizer">
                <div class="tinySizeHandler w-100">
                    <div class="bottomVerticalSpace organizer d-flex align-items-center redAlertColor">
                        <span class="icon icon-danger font-size-16 rightFloat"></span>
                        <div class="dangerMessage font-size-11 mbs-5 d-flex mr-3 alert-filter">
                            &#1604;&#1591;&#1601;&#1575; &#1602;&#1576;&#1604; &#1575;&#1586; &#1662;&#1585;&#1583;&#1575;&#1582;&#1578;
                            &#1575;&#1740;&#1606;&#1578;&#1585;&#1606;&#1578;&#1740;&#1548; &#1601;&#1740;&#1604;&#1578;&#1585;&#1588;&#1705;&#1606;
                            &#1582;&#1608;&#1583; &#1585;&#1575; &#1582;&#1575;&#1605;&#1608;&#1588; &#1705;&#1606;&#1740;&#1583;
                        </div>
                    </div>
                    {{-- <div class="flexDesktop organizer d-flex justify-content-between align-items-center flex-wrap positionsticpayment">
                        <div class="paymentPrice font-size-14 d-flex align-items-center justify-content-center">
                            &#1605;&#1576;&#1604;&#1594; &#1602;&#1575;&#1576;&#1604; &#1662;&#1585;&#1583;&#1575;&#1582;&#1578;
                            @if($vat)
                            &#1605;&#1580;&#1605;&#1608;&#1593;: <span>{{ money($total_diets_amount, true) }}</span>
                            &#1605;&#1575;&#1604;&#1740;&#1575;&#1578; &#1576;&#1585; &#1575;&#1585;&#1586;&#1588; &#1575;&#1601;&#1586;&#1608;&#1583;&#1607;: <span>{{ money($vat, true) }}</span>
                            @endif
                            <p class="paymentNumber font-size-18 boldFont orangeColor inlineDesktopMode ">{{ money($total_amount, true) }} &#1578;&#1608;&#1605;&#1575;&#1606;</p>
                        </div>


                        <!--begin::online payments-->
                        @forelse($payment_gateways as $payment_gateway)
                        <form method="post" action="{{ route('dashboard.pay-ipg') }}">
                            @csrf
                            <input type="hidden" name="payment_gateway" value="{{ $payment_gateway->id }}">
                            <button class="paymentButton whiteColor orangeBack cursor-pointer d-flex align-items-center paymentbtn" type="submit">
                                <span class="icon icon-card middleContext"></span>
                                <span class="middleContext">
                                    &#1662;&#1585;&#1583;&#1575;&#1582;&#1578; &#1576;&#1575; {{ $payment_gateway->title }}
                                </span>
                                <span class="icon icon-forward middleContext"></span>
                            </button>
                        </form>
                        @empty
                        <div>
                            &#1583;&#1585;&#1711;&#1575;&#1607; &#1662;&#1585;&#1583;&#1575;&#1582;&#1578; &#1570;&#1606;&#1604;&#1575;&#1740;&#1606; &#1601;&#1593;&#1575;&#1604;&#1740; &#1608;&#1580;&#1608;&#1583; &#1606;&#1583;&#1575;&#1585;&#1583;
                        </div>
                        @endforelse
                        <!--end::online payments-->
                    </div> --}}
                </div>
            </div>
        @endif
    </div>
</div>

<div
    class="d-flex align-items-center flex-wrap w-100 justify-content-between div-alert-diets-support whiteBackColor w-100 border-radius-10 question-box-pay px-4 pt-4 pb-3 mt-4">
    <div class="d-flex flex-wrap div-text">
        <p class="d-flex font-size-14">
            &#1606;&#1740;&#1575;&#1586; &#1576;&#1607; &#1585;&#1575;&#1607;&#1606;&#1605;&#1575;&#1740;&#1740; &#1583;&#1575;&#1585;&#1740;&#1583;&#1567;
        </p>
        <span class="w-100 d-flex font-size-14">
            &#1575;&#1586; &#1591;&#1585;&#1740;&#1602; &#1578;&#1605;&#1575;&#1587; &#1578;&#1604;&#1601;&#1606;&#1740; &#1608; &#1662;&#1588;&#1578;&#1740;&#1576;&#1575;&#1606;&#1740; &#1570;&#1606;&#1604;&#1575;&#1740;&#1606; &#1587;&#1608;&#1575;&#1604; &#1582;&#1608;&#1583; &#1585;&#1575; &#1575;&#1586; &#1605;&#1575; &#1576;&#1662;&#1585;&#1587;&#1740;&#1583;.
        </span>
    </div>
    <div class="d-flex flex-wrap aling-items-center justify-content-center div-call-support">
        <span class="mb-1 tiny-span"> 9 &#1589;&#1576;&#1581; &#1578;&#1575; 6 &#1576;&#1593;&#1583; &#1575;&#1586; &#1592;&#1607;&#1585; </span>
        <a href="tel:09352230154"
           class="d-flex align-items-center justify-content-center px-2 mb-2 a-support-btn a-support-btn-red"
           title="&#1578;&#1605;&#1575;&#1587; &#1576;&#1575; &#1662;&#1588;&#1578;&#1740;&#1576;&#1575;&#1606;">
            09352230154 </a>
        <a href="https://wa.me/+989352230154"
           class="d-flex align-items-center justify-content-center px-2 a-support-btn a-support-btn-green"
           title="&#1575;&#1585;&#1578;&#1576;&#1575;&#1591; &#1576;&#1575; &#1662;&#1588;&#1578;&#1740;&#1576;&#1575;&#1606;">
            &#1575;&#1585;&#1578;&#1576;&#1575;&#1591; &#1576;&#1575;
            &#1662;&#1588;&#1578;&#1740;&#1576;&#1575;&#1606; </a>
    </div>
</div>
