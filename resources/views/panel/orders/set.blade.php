
<!--begin:: order details-->
<div class="kt-portlet">
    <div class="kt-portlet__body">
        @AjaxForm(['form_id' => 'order-form', 'is_update' => true, 'confirm' =>  __('order.status_change_confirm') ])@endAjaxForm
        <form action="{{ route('panel.orders.update' , ['order' => $order->id]) }}"   id="order-form" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                            <label>@lang('validation.attributes.status')</label>
                            <select name="status" class="form-control">
                                <option value="{{ \App\Constants\GeneralConstants::ORDER_STATUS_CREATED }}"
                                        @if( $order->status == \App\Constants\GeneralConstants::ORDER_STATUS_CREATED ) selected @endif  >
                                    @lang('order.ORDER_STATUS_CREATED')
                                </option>
                                <option value="{{ \App\Constants\GeneralConstants::ORDER_STATUS_COMPLETED }}"
                                        @if( $order->status == \App\Constants\GeneralConstants::ORDER_STATUS_COMPLETED ) selected @endif  >
                                @lang('order.ORDER_STATUS_COMPLETED')</option>
                            </select>
                        </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="date_of_birth">start date</label>
                        @PersianDatepicker([
                        "name" => 'start_date',
                        "class" => 'form-control',
                        "id" => 'start_date',
                        ])
                        {{ $order->start_date }}
                        @endPersianDatepicker
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <button class="submit-button btn btn-success" type="button">@lang('general.submit') <i class="la la-floppy-o p-0"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-lg-4">
                <!--begin::upload file-->
                <form action="{{ route('panel.orders.upload-diet-file' , ['order' => $order->id]) }}"  method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <form>
                                <div class="form-group">
                                    <label for="diet_file">
                                        @lang('general.upload')
                                        @lang('general.file')
                                        @lang('general.diet')
                                    </label>
                                    <input name="diet_file" type="file" class="form-control-file" id="diet_file">
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <button class="submit-button btn btn-success" type="submit">@lang('general.upload')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::upload file-->
            </div>
            <div class="col-lg-4">
                <!--begin::old file-->
                @if(!empty($order->file))
                    <div class="row">
                        <div class="col-lg-12">
                            @lang('general.file')
                            @lang('general.diet'):
                            <a href="{{ url($order->file) }}" target="_blank">
                                @lang('general.download')
                            </a>
                        </div>
                        <div class="col-lg-12">
                            @AjaxForm(['form_id' => 'delete-diet-file-form', 'is_update' => false, 'confirm' =>  __('general.confirm_delete_file') ])@endAjaxForm
                            <form id="delete-diet-file-form" action="{{ route('panel.orders.delete-diet-file' , ['order' => $order->id]) }}"  method="post">
                                @csrf
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <button class="submit-button btn btn-danger" type="button">@lang('general.delete')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
                <!--end::old file-->
            </div>
        </div>


    </div>
</div>
<!--end:: order details-->

@AjaxForm(['form_id' => 'daily-plan-form', 'is_update' => false ])@endAjaxForm
<form action="{{ route('panel.orders.store-daily-plan', ['order' => $order->id]) }}"
      id="daily-plan-form" method="post">
    @csrf

    <div class="kt-portlet">
        <div class="kt-portlet__body">
            <div class="form-group d-flex justify-content-center">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button class="submit-button btn btn-success" type="submit">@lang('general.submit_daily_plan')</button>
                </div>
            </div>

            <!--begin::days shortcuts-->
            <div class="mb-3">
                @for ($day = 1; $day <= $order->duration_in_day; $day++)
                    <button type="button" class="day-shortcut btn btn-label-info btn-pill mb-1 btn-elevate btn-pill btn-elevate-air btn-sm" data-day="{{ $day }}">
                        @lang('general.day') {{ $day }}
                    </button>
                @endfor
            </div>
            <!--end::days shortcuts-->
        </div>
    </div>


    <div class="row">
        @for ($day = 1; $day <= $order->duration_in_day; $day++)
            <div class="col-lg-12">
                <div class="day day-{{ $day }} kt-portlet kt-portlet--height-fluid" data-day="{{ $day }}">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                @lang('general.day') {{ $day }}
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="row">

                            <!--begin::sport-->
                            <div class="col-lg-12">
                                @include('panel.orders.sport')
                            </div>
                            <!--end::sport-->

                            <!--begin::recommendation-->
                            <div class="col-lg-12">
                                @include('panel.orders.recommendation')
                            </div>
                            <!--end::recommendation-->

                            <!-- breakfast - start -->
                            <div class="col-lg-12">
                                {{-- TODO[fix-label]:  fix label/message --}}
                                @include('panel.orders.meal', ['meal'=> 'breakfast', 'title' => __('general.breakfast')])
                            </div>
                            <!-- breakfast - end -->

                            <!-- snack1 - start -->
                            <div class="col-lg-12">
                                {{-- TODO[fix-label]:  fix label/message --}}
                                @include('panel.orders.meal', ['meal'=> 'snack1', 'title' => __('general.snack1')])
                            </div>
                            <!-- snack1 - end -->

                            <!-- lunch - start -->
                            <div class="col-lg-12">
                                {{-- TODO[fix-label]:  fix label/message --}}
                                @include('panel.orders.meal', ['meal'=> 'lunch', 'title' => __('general.lunch')])
                            </div>
                            <!-- lunch - end -->

                            <!-- snack2 - start -->
                            <div class="col-lg-12">
                                {{-- TODO[fix-label]:  fix label/message --}}
                                @include('panel.orders.meal', ['meal'=> 'snack2', 'title' => __('general.snack2')])
                            </div>
                            <!-- snack2 - end -->

                            <!-- dinner - start -->
                            <div class="col-lg-12">
                                {{-- TODO[fix-label]:  fix label/message --}}
                                @include('panel.orders.meal', ['meal'=> 'dinner', 'title' => __('general.dinner')])
                            </div>
                            <!-- dinner - end -->

                            <!-- snack3 - start -->
                            <div class="col-lg-12">
                                {{-- TODO[fix-label]:  fix label/message --}}
                                @include('panel.orders.meal', ['meal'=> 'snack3', 'title' => __('general.snack3')])
                            </div>
                            <!-- snack3 - end -->

                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <!--begin::removed_daily_food_plans-->
    <input type="hidden" name="removed_daily_food_plans" class="removed_daily_food_plans" value="{{ json_encode([]) }}">
    <!--end::removed_daily_food_plans-->

    <!--begin::removed_daily_sport_plans-->
    <input type="hidden" name="removed_daily_sport_plans" class="removed_daily_sport_plans" value="{{ json_encode([]) }}">
    <!--end::removed_daily_sport_plans-->

    <!--begin::removed_daily_recommendation_plans-->
    <input type="hidden" name="removed_daily_recommendation_plans" class="removed_daily_recommendation_plans" value="{{ json_encode([]) }}">
    <!--end::removed_daily_recommendation_plans-->

    <div class="form-group">
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <button class="submit-button btn btn-success" type="submit">@lang('general.submit') <i class="la la-floppy-o p-0"></i></button>
        </div>
    </div>
</form>

<!--begin::food templates-->

    <!--begin::food template-->
    <div class="food-template daily-plan bg-white has-calorie-item cursor-grab alert border border-success px-2 d-none" data-type="food">
        <div class="row w-100">
            <div class="col-sm-2">
                <div class="form-group  input-group-sm m-0">
                    <!--begin::daily_food_plan_id-->
                    <input type="hidden" class="daily_food_plan_id" value="0" >
                    <!--end::daily_food_plan_id-->

                    <!--begin::food_id-->
                    <input type="hidden" class="food_id" >
                    <!--end::food_id-->

                    <!--begin::calories_per_unit-->
                    <input type="hidden" class="calories_per_unit" >
                    <!--end::calories_per_unit-->

                    <input type="text" class="before_food_comment form-control" >
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group  input-group-sm m-0">
                    <input type="number" class="amount_in_unit remove-arrows text-center form-control" step=".5" >
                </div>
            </div>
            <div class="col-sm-1 d-flex">
                <div class="alert-text text-center">
                    <span class="unit text-warning text-hover-danger font-weight-bold"></span>
                </div>
            </div>
            <div class="col-sm-3 d-flex">
                <div class="title alert-text text-center font-weight-bold">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group  input-group-sm m-0">
                    <input type="text" class="after_food_comment form-control" >
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group  input-group-sm m-0">
                    <input type="number" class="total_calories text-center remove-arrows form-control" >
                </div>
            </div>
            <div class="col-sm-1 d-flex justify-content-end">
                <div class="alert-close remove-daily-plan remove-food">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="la la-close"></i></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::food template-->

    <!--begin::food search result template-->
    <table class="d-none">
        <tr class="food-search-result-template search-result cursor-pointer d-none">
            <td class="title col-sm-4 text-dark font-weight-bold w-50"></td>
            <td class="unit col-sm-4 text-danger text-hover-danger font-weight-bold" ></td>
            <td class="calories_per_unit col-sm-4 text-success font-weight-bold"></td>
        </tr>
    </table>
    <!--end::food search result template-->

<!--end::food templates-->

<!--begin::sport templates-->

    <!--begin::sport template-->
    <div class="sport-template daily-plan bg-white has-calorie-item cursor-grab alert border border-success px-2 d-none"  data-type="sport">
        <div class="row w-100">
            <div class="col-sm-2">
                <div class="form-group  input-group-sm m-0">
                    <!--begin::daily_sport_plan_id-->
                    <input type="hidden" class="daily_sport_plan_id" value="0" >
                    <!--end::daily_sport_plan_id-->

                    <!--begin::sport_id-->
                    <input type="hidden" class="sport_id" >
                    <!--end::sport_id-->

                    <!--begin::calories_per_unit-->
                    <input type="hidden" class="calories_per_unit" >
                    <!--end::calories_per_unit-->

                    <input type="text" class="before_sport_comment form-control" >
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group  input-group-sm m-0">
                    <input type="number" class="amount_in_unit remove-arrows text-center form-control" step=".5" >
                </div>
            </div>
            <div class="col-sm-1 d-flex">
                <div class="alert-text text-center">
                    <span class="unit text-warning text-hover-danger font-weight-bold"></span>
                </div>
            </div>
            <div class="col-sm-3 d-flex">
                <div class="title alert-text text-center font-weight-bold">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group  input-group-sm m-0">
                    <input type="text" class="after_sport_comment form-control" >
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group  input-group-sm m-0">
                    <input type="number" class="total_calories text-center remove-arrows form-control" >
                </div>
            </div>
            <div class="col-sm-1 d-flex justify-content-end">
                <div class="alert-close remove-daily-plan remove-sport">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="la la-close"></i></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::sport template-->

    <!--begin::sport search result template-->
    <table class="d-none">
        <tr class="sport-search-result-template search-result cursor-pointer d-none">
            <td class="title col-sm-4 text-dark font-weight-bold w-50"></td>
            <td class="unit col-sm-4 text-danger text-hover-danger font-weight-bold" ></td>
            <td class="calories_per_unit col-sm-4 text-success font-weight-bold"></td>
        </tr>
    </table>
    <!--end::sport search result template-->

<!--end::sport templates-->

<!--begin::recommendation templates-->

    <!--begin::recommendation template-->
    <div class="recommendation-template daily-plan bg-white cursor-grab alert border border-success px-2 d-none"  data-type="recommendation">
        <div class="row w-100">
            <div class="col-sm-3">
                <div class="form-group  input-group-sm m-0">
                    <!--begin::daily_recommendation_plan_id-->
                    <input type="hidden" class="daily_recommendation_plan_id" value="0" >
                    <!--end::daily_recommendation_plan_id-->

                    <!--begin::recommendation_id-->
                    <input type="hidden" class="recommendation_id" >
                    <!--end::recommendation_id-->

                    <input type="text" class="before_recommendation_comment form-control" >
                </div>
            </div>

            <div class="col-sm-3 d-flex">
                <div class="title alert-text text-center font-weight-bold">
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group  input-group-sm m-0">
                    <input type="text" class="after_recommendation_comment form-control" >
                </div>
            </div>
            <div class="col-sm-1 d-flex justify-content-end">
                <div class="alert-close remove-daily-plan remove-recommendation">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="la la-close"></i></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::recommendation template-->

    <!--begin::recommendation search result template-->
    <table class="d-none">
        <tr class="recommendation-search-result-template search-result cursor-pointer d-none">
            <td class="title col-sm-4 text-dark font-weight-bold w-50"></td>
        </tr>
    </table>
    <!--end::recommendation search result template-->

<!--end::recommendation templates-->

<!--begin::not found search result template-->
<table class="d-none">
    <tr class="not-found-template cursor-pointer d-none">
        <td colspan="3" class="not-found text-center col-sm-4  text-danger text-hover-danger font-weight-bold" >@lang('general.not_found')</td>
    </tr>
</table>
<!--end::not found search result template-->


@foreach($diet->foods as $day => $meals )
    <div class=" border border-success p-2 m-1">
        day {{ $day }}
        @foreach($meals as $meal => $foods )
            <div class="border border-warning  m-1 p-2">
                {{ $meal }} <br>
                @foreach($foods as $food )
                    {{ $food->before_food_comment }} {{ number_format($food->amount_in_unit) }} {{ $food->food->unit }} {{ $food->food->title }} {{ $food->after_food_comment }} +
                @endforeach
            </div>
        @endforeach
    </div>
@endforeach

@include('panel.includes.include-jquery-ui')

@pushonce('script_variables:/panel-assets/js/orders/set-daily-plan.js')
<script>
    var search_url = "{{ route('panel.orders.search') }}";
    var diet_encoded = '{!! str_replace("'", "\'", json_encode($diet)) !!}';
</script>
@endpushonce

@pushonce('scripts:/panel-assets/template/assets/js/pages/crud/forms/widgets/bootstrap-touchspin.js')
<!--begin::Page Scripts(used by this page) -->
<script src="{{ asset("/panel-assets/template/assets/js/pages/crud/forms/widgets/bootstrap-touchspin.js") }}" type="text/javascript"></script>
<!--end::Page Scripts -->
@endpushonce

@pushonce('scripts:/panel-assets/js/orders/set-daily-plan.js')
<script src="{{ asset("/panel-assets/js/orders/set-daily-plan.js") }}"></script>
@endpushonce

@pushonce('styles:/panel-assets/css/order.css')
<link href="{{ asset("/panel-assets/css/order.css") }}" rel="stylesheet">
@endpushonce
