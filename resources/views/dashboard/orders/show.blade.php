<div class="dietMe w-100 ">

<!--
    <div class="order-status mb-2">
        <label>@lang('validation.attributes.status'):</label>
        @switch($order->status)
    @case(\App\Constants\GeneralConstants::ORDER_STATUS_CREATED)
        <span class="font-weight-bold">
@lang('order.ORDER_STATUS_CREATED')
        </span>
@break
    @case(\App\Constants\GeneralConstants::ORDER_STATUS_COMPLETED)
        <span class="font-weight-bold">
@lang('order.ORDER_STATUS_COMPLETED')
        </span>
@break
    @default
        // TODO[fix-label]:  fix label/message
            {{--{{ $order->status }}--}}
@endswitch
    </div>
    -->

@if($order->status == \App\Constants\GeneralConstants::ORDER_STATUS_COMPLETED)
    @php
        $diet = $order->diet;
    @endphp
@endif


@if(!empty($diet))
    <!--begin::start date-->
        <div class="start=date mt-2">
            شروع رژیم:
            {{ jdate($diet->days->first()) }}
            <p>بر روی روز موردنظر کلیک کرده تا برنامه مختص آن نمایش داده شود.</p>

        </div>
        <!--end::start date-->

        <!--begin::days shortcut-->
        <ul class="d-flex align-items-center week-slieder">
            @foreach($diet->days as $day_number => $day)
                <li class="d-flex align-items-center justify-content-center cursor-pointer px-2 py-2
                        @if(\Carbon\Carbon::today()->timestamp == $day) active @endif"
                    data-tab-b="content-{{ $day_number }}" data-day="{{ $day_number }}">
                <span>@lang('general.day') {{ $day_number }} -
                    {{ jdate($day, true, 'd F') }}
                </span>
                </li>
            @endforeach
        </ul>
        <!--end::days shortcut-->
@endif


@if(!empty($diet))
    <!--begin::daily plans-->
        <div class="tabc-week" style="
            background: white;
            padding: 4%;
            margin-top: 2%;
            border-radius: 5px;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        ">
            <!--begin::daily plan-->

            @php
                $plan = \App\CustomDietDailyPlan::where('order_id', $order->id)->get();
                $pure_plan = (count($plan) == 1) ? json_decode($plan[0]->plan, true) : false;
                $foods = \App\Food::all();
                $sports = \App\Sport::all();
                function issetNotNUll($input) {
                    return (isset($input) && !is_null($input)) ? true : false;
                }
            @endphp


            @foreach($diet->days as $day_number => $day)
                <div
                    class="content content-{{ $day_number }} dietMe-content @if(\Carbon\Carbon::today()->timestamp != $day) tempDisable @endif  daily-plan-{{ $day_number }} @if(\Carbon\Carbon::today()->timestamp == $day) @endif">
                    @if($pure_plan !== false)
                        <style>
                            .card {
                                padding: 3%;
                                box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
                                border-radius: 24px;
                            }

                            .item-list {
                                text-align: right;
                            }

                            .iteration {
                                font-weight: 700;
                                font-size: 20px;
                                width: 10px;
                            }

                            .seprator {
                                width: 5px;
                                height: 5px;
                                background: #eaf5f2;
                                border-radius: 5px;
                            }

                            .box-title {
                                font-weight: 900;
                                margin: 5% 0 2% 0;
                            }

                            .subtitle {
                                color: gray;
                                font-weight: 700;
                                font-size: 10px;
                            }
                        </style>

                        <!-- Breakfast -->
                        <p class="box-title">صبحانه</p>
                        <div class="card">
                            @if(isset($pure_plan[$day_number]['breakfast']))
                                @foreach($pure_plan[$day_number]['breakfast'] as $item_id => $item)
                                    <ul class="item-list">
                                        @include('dashboard.orders.loop.food-item')
                                    </ul>
                                @endforeach
                            @else
                                <p>موردی برای این بخش از برنامه تعریف نشده است.</p>
                            @endif
                            <span class="seprator"></span>
                            <span class="seprator"></span>
                            <span class="seprator"></span>
                        </div>
                        <!-- Breakfast -->

                        <!-- Sport -->
                        <p class="box-title">ورزش</p>
                        <div class="card">
                            @if(isset($pure_plan[$day_number]['sport']))
                                @foreach($pure_plan[$day_number]['sport'] as $item_id => $item)
                                    <ul class="item-list">
                                        @include('dashboard.orders.loop.sport-item')
                                    </ul>
                                @endforeach
                            @else
                                <p>موردی برای این بخش از برنامه تعریف نشده است.</p>
                            @endif
                            <span class="seprator"></span>
                            <span class="seprator"></span>
                            <span class="seprator"></span>
                        </div>
                        <!-- Sport -->


                        <!-- Midmeal-1 -->
                        <p class="box-title">میان‌وعده اول</p>
                        <div class="card">
                            @if(isset($pure_plan[$day_number])) @else @endif
                            @foreach($pure_plan[$day_number]['midmeal-1'] as $item_id => $item)
                                <ul class="item-list">
                                    @include('dashboard.orders.loop.food-item')
                                </ul>
                            @endforeach
                            <span class="seprator"></span>
                            <span class="seprator"></span>
                            <span class="seprator"></span>
                        </div>
                        <!-- Midmeal-1 -->



                        <!-- Lunch -->
                        <p class="box-title">ناهار</p>
                        <div class="card">
                            @if(isset($pure_plan[$day_number]['lunch']))
                                @foreach($pure_plan[$day_number]['lunch'] as $item_id => $item)
                                    <ul class="item-list">
                                        @include('dashboard.orders.loop.food-item')
                                    </ul>
                                @endforeach
                            @else
                                <p>موردی برای این بخش از برنامه تعریف نشده است.</p>
                            @endif
                            <span class="seprator"></span>
                            <span class="seprator"></span>
                            <span class="seprator"></span>
                        </div>
                        <!-- Lunch -->

                        <!-- Midmeal-2 -->
                        <p class="box-title">میان‌وعده دوم</p>
                        <div class="card">
                            @if(isset($pure_plan[$day_number]['midmeal-2']))
                                @foreach($pure_plan[$day_number]['midmeal-2'] as $item_id => $item)
                                    <ul class="item-list">
                                        @include('dashboard.orders.loop.food-item')
                                    </ul>
                                @endforeach
                            @else
                                <p>موردی برای این بخش از برنامه تعریف نشده است.</p>
                            @endif
                            <span class="seprator"></span>
                            <span class="seprator"></span>
                            <span class="seprator"></span>
                        </div>
                        <!-- Midmeal-2 -->

                        <!-- Dinner -->
                        <p class="box-title">شام</p>
                        <div class="card">
                            @if(isset($pure_plan[$day_number]['dinner']))
                                @foreach($pure_plan[$day_number]['dinner'] as $item_id => $item)
                                    <ul class="item-list">
                                        @include('dashboard.orders.loop.food-item')
                                    </ul>
                                @endforeach
                            @else
                                <p>موردی برای این بخش از برنامه تعریف نشده است.</p>
                            @endif
                            <span class="seprator"></span>
                            <span class="seprator"></span>
                            <span class="seprator"></span>
                        </div>
                        <!-- Dinner -->



                    @endif
                </div>
        @endforeach
        <!--end::daily plan-->
        </div>
        <!--end::daily plans-->
    @endif


    @if(empty($diet))
        <div class="w-100 whiteBackColor border-radius-10 px-4 pt-4 pb-3">
            <div
                style="
                /*background: #ffc700;*/
                /*background: #ffc700;*/
                background: #efba00;
                padding: 1.25rem !important;
                border-radius: 3px;
                color: white;
                font-weight: 800;
                /*width: 70%;*/
                margin-bottom: 2%;
                "
                class="font-size-14 boldFont">
                <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0 rightFloat">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="currentColor"></path>
                        <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="currentColor"></path>
                    </svg>
                </span>
                سفارش شما در حال آماده سازی می‌باشد، لطفا منتظر باشید ...
            </div>
        </div>
    @endif
</div>
