<div class="dietMe w-100 ">

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

@if($order->status == \App\Constants\GeneralConstants::ORDER_STATUS_COMPLETED)
    @php
        $diet = $order->diet;
    @endphp
@endif


@if(!empty($diet))
    <!--begin::start date-->
        <div class="start=date mt-2">
            شروع رژیم:
            {{ jdate($order->start_date) }}
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
            <p>بر روی روز موردنظر کلیک کرده تا برنامه مختص آن نمایش داده شود.</p>
            <!--begin::daily plan-->
            @foreach($diet->days as $day_number => $day)
                <div class="content content-{{ $day_number }} dietMe-content @if(\Carbon\Carbon::today()->timestamp != $day) tempDisable @endif  daily-plan-{{ $day_number }} @if(\Carbon\Carbon::today()->timestamp == $day) @endif">
                    <!--begin::sport-->
                    @isset($diet->sports[$day_number])
                        <ul class="d-flex flex-wrap w-100 mt-5 sport-day-{{ $day_number }}">
                            <div class="w-100 d-flex mb-4">
                                <strong class="d-flex align-items-center">
                                    {{-- <i class="icon icon-breakfast"></i> --}}
                                    ورزش پیشنهادی
                                </strong>
                            </div>
                            @foreach($diet->sports[$day_number] as $sport)
                                <li class="d-flex align-items-center justify-content-between w-100 px-2">
                                    <div class="d-flex align-items-center cursor-pointer open-modal" data-target=".food-popup">
                                        <figure class="d-flex align-items-center justify-content-center"
                                            style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                            <img src="img/workout.svg" title="" alt="">
                                        </figure>
                                        <div class="d-felx flex-wrap align-items-center">
                                            <span class="w-100 d-flex">{{ $sport->sport->title }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endisset
                <!--end::sport-->

                    <!--begin::recommendation-->
                    @isset($diet->recommendations[$day_number])
                        <ul class="d-flex flex-wrap w-100 mt-5 recommendation-day-{{ $day_number }}">
                            <div class="w-100 d-flex mb-4">
                                <strong class="d-flex align-items-center">
                                    {{-- <i class="icon icon-breakfast"></i> --}}
                                    توصیه روزانه
                                </strong>
                            </div>
                            @foreach($diet->recommendations[$day_number] as $recommendation)
                                <li class="d-flex align-items-center justify-content-between w-100 px-2">
                                    <div class="d-flex align-items-center cursor-pointer open-modal" data-target=".food-popup">
                                        <figure class="d-flex align-items-center justify-content-center"
                                            style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                            <img src="img/help.svg" title="" alt="">
                                        </figure>
                                        <div class="d-felx flex-wrap align-items-center">
                                            <span class="w-100 d-flex">{{ $recommendation->recommendation->title }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                @endisset
                <!--end::recommendation-->

                    <!--begin::foods-->

                    <!--begin::breakfast-->
                @include('dashboard.orders.meal', ['meal' => 'breakfast', 'meal_title' => __('general.breakfast'), 'icon' => '<i class="icon icon-breakfast"></i>'])
                <!--end::breakfast-->

                    <!--begin::snack1-->
                @include('dashboard.orders.meal', ['meal' => 'snack1', 'meal_title' => __('general.snack1'), 'icon' => '<i class="icon icon-snack"></i>'])
                <!--end::snack1-->

                    <!--begin::lunch-->
                @include('dashboard.orders.meal', ['meal' => 'lunch', 'meal_title' => __('general.lunch'), 'icon' => '<i class="icon icon-lunch"></i>'])
                <!--end::lunch-->

                    <!--begin::snack2-->
                @include('dashboard.orders.meal', ['meal' => 'snack2', 'meal_title' => __('general.snack2'), 'icon' => '<i class="icon icon-snack"></i>'])
                <!--end::snack2-->

                    <!--begin::dinner-->
                @include('dashboard.orders.meal', ['meal' => 'dinner', 'meal_title' => __('general.dinner'), 'icon' => '<i class="icon icon-dinner"></i>'])
                <!--end::dinner-->

                    <!--begin::snack3-->
                @include('dashboard.orders.meal', ['meal' => 'snack3', 'meal_title' => __('general.snack3'), 'icon' => '<i class="icon icon-snack"></i>'])
                <!--end::snack3-->

                    <!--end::foods-->
                </div>
            @endforeach
            <!--end::daily plan-->
        </div>
        <!--end::daily plans-->
    @endif
</div>
