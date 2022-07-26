<!--begin::search box-->
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                @lang('general.search')
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <form method="GET" action="{{ route('panel.comprehensive-report') }}">
            <!--begin::search inputs-->
            <div class="row">

                <div class="col-lg-2">
                    <div class="form-group">
                        <label>@lang('validation.attributes.name')</label>
                        <input name="profile_name" type="text" class="form-control" @isset($search_items->profile_name) value="{{ $search_items->profile_name }}" @endisset>
                    </div>
                </div>

                @can('see_mobile_number')
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>@lang('validation.attributes.mobile')</label>
                            <input name="mobile_number" type="text" class="form-control" @isset($search_items->mobile_number) value="{{ $search_items->mobile_number }}" @endisset>
                        </div>
                    </div>
                @endcan

                <div class="col-lg-2">
                    <div class="form-group">
                        <label>@lang('general.diet')</label>
                        <select name="diet_id" class="form-control">
                            <option value="">@lang('general.select')</option>
                            @foreach(\Facades\App\Libraries\DietHelper::getAllDiets(false) as $diet)
                                <option @if(isset($search_items->diet_id) && $search_items->diet_id ==  $diet->id) selected @endif value="{{ $diet->id }}">{{ $diet->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="form-group">
                        <label>@lang('invoice.payment_type')</label>
                        <select name="payment_way" class="form-control">
                            <option value="">@lang('general.select')</option>
                            <option @if(isset($search_items->payment_way) && $search_items->payment_way ==  'ipg') selected @endif value="ipg">@lang('invoice.ipg')</option>
                            <option @if(isset($search_items->payment_way) && $search_items->payment_way ==  'offline') selected @endif value="offline">@lang('invoice.offline')</option>
                            <option @if(isset($search_items->payment_way) && $search_items->payment_way ==  'manual_by_admin') selected @endif value="manual_by_admin">@lang('invoice.manual_by_admin')</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">

                <!--begin::paid-->
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="kt-checkbox kt-checkbox--bold kt-checkbox--success">
                            <input name="paid" type="checkbox" @if(isset($search_items->paid)) checked @endif>
                            @lang('general.paid')
                            <span></span>
                        </label>
                    </div>
                </div>
                <!--end::paid-->

                <!--begin::in_progress-->
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="kt-checkbox kt-checkbox--bold kt-checkbox--success">
                            <input name="in_progress" type="checkbox" @if(isset($search_items->in_progress)) checked @endif>
                            @lang('validation.attributes.in_progress')
                            <span></span>
                        </label>
                    </div>
                </div>
                <!--end::in_progress-->

                <!--begin::not_in_progress-->
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="kt-checkbox kt-checkbox--bold kt-checkbox--success">
                            <input name="not_in_progress" type="checkbox" @if(isset($search_items->not_in_progress)) checked @endif>
                            @lang('validation.attributes.not_in_progress')
                            <span></span>
                        </label>
                    </div>
                </div>
                <!--end::not_in_progress-->

                <!--begin::order_created-->
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="kt-checkbox kt-checkbox--bold kt-checkbox--success">
                            <input name="order_created" type="checkbox" @if(isset($search_items->order_created)) checked @endif>
                            @lang('general.order_created')
                            <span></span>
                        </label>
                    </div>
                </div>
                <!--end::order_created-->

                <!--begin::order_completed-->
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="kt-checkbox kt-checkbox--bold kt-checkbox--success">
                            <input name="order_completed" type="checkbox" @if(isset($search_items->order_completed)) checked @endif>
                            @lang('general.order_completed')
                            <span></span>
                        </label>
                    </div>
                </div>
                <!--end::order_completed-->

                <!--begin::close_to_renewal-->
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="kt-checkbox kt-checkbox--bold kt-checkbox--success">
                            <input name="close_to_renewal" type="checkbox" @if(isset($search_items->close_to_renewal)) checked @endif>
                            @lang('general.close_to_renewal')
                            <span></span>
                        </label>
                    </div>
                </div>
                <!--end::close_to_renewal-->

                <!--begin::expired-->
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="kt-checkbox kt-checkbox--bold kt-checkbox--success">
                            <input name="expired" type="checkbox" @if(isset($search_items->expired)) checked @endif>
                            @lang('general.expired')
                            <span></span>
                        </label>
                    </div>
                </div>
                <!--end::expired-->
            </div>

            <hr class="mb-4">

            <!--begin::date_range-->
            <div class="date-range">
                <h5 class="mt-2 mb-5">@lang('general.date_range')</h5>

                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>@lang('general.event')</label>
                            <select name="date_range_event" class="form-control">
                                <option value="">@lang('general.select')</option>
                                <option @if(isset($date_range_event) && $date_range_event == 'profile_created_at') selected @endif value="profile_created_at">@lang('general.date') @lang('general.sign_up')</option>
                                <option @if(isset($date_range_event) && $date_range_event == 'paid_at') selected @endif value="paid_at">@lang('general.date') @lang('general.payment')</option>
                                <option @if(isset($date_range_event) && $date_range_event == 'order_created_at') selected @endif value="order_created_at">@lang('general.date') @lang('general.create') @lang('general.order')</option>
                                <option @if(isset($date_range_event) && $date_range_event == 'order_start_date') selected @endif value="order_start_date">@lang('general.date') @lang('general.start') @lang('general.order')</option>
                                <option @if(isset($date_range_event) && $date_range_event == 'order_end_date') selected @endif value="order_end_date">@lang('general.date') @lang('general.end') @lang('general.order')</option>
                                <option @if(isset($date_range_event) && $date_range_event == 'invoice_created_at') selected @endif value="invoice_created_at">@lang('general.date') @lang('general.create') @lang('general.invoice')</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="date_range_start">@lang('general.from')
                                <small>
                                    (@lang('general.from') @lang('general.start_of_day'))
                                </small>
                            </label>
                            @PersianDatepicker([
                            "name" => 'date_range_start',
                            "class" => 'form-control',
                            "id" => 'date_range_start',
                            ])
                            @if(!empty($date_range_start)) {{ jdateToTimestamp($date_range_start) }} @endif
                            @endPersianDatepicker
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="date_range_end">@lang('general.to')
                                <small>
                                    (@lang('general.to') @lang('general.end_of_day'))
                                </small>
                            </label>
                            @PersianDatepicker([
                            "name" => 'date_range_end',
                            "class" => 'form-control',
                            "id" => 'date_range_end',
                            ])
                            @if(!empty($date_range_end)) {{ jdateToTimestamp($date_range_end) }} @endif
                            @endPersianDatepicker
                        </div>
                    </div>
                </div>
            </div>
            <!--end::date_range-->

            <hr class="mb-5">

            <!--end::search inputs-->

            <!--begin::sort-->
            <div>
                <h5 class="mt-2 mb-3">@lang('general.sort')</h5>
                <div class="row">

                    @for($i=1; $i <=4 ; $i++)
                        <!--begin:: sort 1-->
                            <div class="col-lg-3">
                                <div class="d-flex flex-column border border-dark alert bg-light">
                                    <div class="form-group">
                                        <label>@lang('general.sort_by') ({{$i}})</label>
                                        <select name="sort_item_{{$i}}" class="form-control">
                                            <option value="">@lang('general.select')</option>
                                            @php
                                                $sort_item_key = "sort_item_" . $i;
                                                $sort_type_item_key = "sort_type_item_" . $i;
                                                $sort_item = isset($sort_items->{$sort_item_key}) ? $sort_items->{$sort_item_key} : "";
                                                $sort_type_item = isset($sort_type_items->{$sort_type_item_key}) ? $sort_type_items->{$sort_type_item_key} : "";
                                            @endphp
                                            <option @if( $sort_item ==  'profile_created_at') selected @endif value="profile_created_at">@lang('general.date') @lang('general.sign_up')</option>
                                            <option @if( $sort_item ==  'order_created_at') selected @endif value="order_created_at">@lang('general.date') @lang('general.create') @lang('general.order')</option>
                                            <option @if( $sort_item ==  'paid_at') selected @endif value="paid_at">@lang('general.date') @lang('general.payment')</option>
                                            <option @if( $sort_item ==  'invoice_created_at') selected @endif value="invoice_created_at">@lang('general.date') @lang('general.create') @lang('general.invoice')</option>
                                            <option @if( $sort_item ==  'order_start_date') selected @endif value="order_start_date">@lang('general.date') @lang('general.start') @lang('general.order')</option>
                                            <option @if( $sort_item ==  'order_end_date') selected @endif value="order_end_date">@lang('general.date') @lang('general.end') @lang('general.order')</option>
                                            <option @if( $sort_item ==  'mobile_number') selected @endif value="mobile_number">@lang('validation.attributes.mobile')</option>
                                            <option @if( $sort_item ==  'invoice_status') selected @endif value="invoice_status">@lang('validation.attributes.status') @lang('general.invoice')</option>
                                            <option @if( $sort_item ==  'payment_way') selected @endif value="payment_way">@lang('invoice.payment_type')</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('general.sort_type') (1)</label>
                                        <select name="sort_type_item_{{ $i }}" class="form-control">
                                            <option @if($sort_type_item ==  'ASC') selected @endif value="ASC">@lang('general.asc')</option>
                                            <option @if($sort_type_item ==  'DESC') selected @endif value="DESC">@lang('general.desc')</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--end:: sort 1-->
                    @endfor

                </div>
            </div>
            <!--end::sort-->

            <!--begin::buttons-->
            <div class="row">
                <div class="col-lg-1">
                    <div class="form-group mb-0">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <button class="submit-button btn btn-success" type="submit">@lang('general.search') <i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="form-group mb-0">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <a href="{{ route('panel.comprehensive-report') }}" class="submit-button btn btn-info" type="submit">@lang('general.reset') <i class="fa fa-times" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::buttons-->
        </form>
    </div>
</div>
<!--end::search box-->

<div class="kt-portlet" id="result-container">
    <div class="kt-portlet__body">
        <div class="d-flex justify-content-between flex-row ">
            <div class="d-flex flex-row align-items-center">
                <h6 class="text-center">@lang('general.total_number'): {{ $items->total() }}</h6>
            </div>
            <div class="mb-4">
                <a href="{{ route('panel.profiles.create') }}" target="_blank" class="add-period btn btn-bold btn-sm btn-label-brand">
                    <i class="la la-plus"></i> @lang('general.add', ['title' => __('general.profile')])
                </a>
            </div>
        </div>
        <table class="comprehensive-report table table-bordered table-hover" id="comprehensive-report-table">
            <thead>
            <tr class="font-size-12">
                <th class="text-center">#</th>
                <th class="text-center">@lang('validation.attributes.status')</th>
                <th>@lang('validation.attributes.name')</th>
                <th class="text-center">@lang('validation.attributes.mobile')</th>
                <th class="text-center">
                    @lang('validation.attributes.status')
                    @lang('general.payment')
                </th>
                <th class="text-center">@lang('general.diet')</th>
                <th class="text-center">@lang('validation.attributes.period')</th>
                <th class="text-center">@lang('general.cart_items')</th>
                <th class="text-center">@lang('validation.attributes.price')</th>
                <th class="text-center">@lang('general.order')</th>
                <th class="text-center">@lang('validation.attributes.is_temp')</th>
                <th class="text-center">@lang('validation.attributes.city')</th>
                <th class="text-center">@lang('invoice.payment_type')</th>
                <th class="text-center">
                    @lang('general.date')
                    @lang('general.payment')
                    @lang('general.invoice')
                </th>
                <th class="text-center">
                    @lang('general.date')
                    @lang('general.create')
                    @lang('general.order')
                </th>
                <th class="text-center">
                    @lang('general.date')
                    @lang('general.start')
                    @lang('general.order')
                </th>
                <th class="text-center">
                    @lang('general.date')
                    @lang('general.end')
                    @lang('general.order')
                </th>
                <th class="text-center">
                    @lang('general.week')
                </th>
                <th class="text-center">
                    @lang('general.date')
                    @lang('general.sign_up')
                </th>
                <th class="text-center">
                    @lang('general.date')
                    @lang('general.create')
                    @lang('general.invoice')
                </th>
                <th class="text-center">@lang('validation.attributes.is_dissatisfied')</th>
                <th class="text-center">@lang('validation.attributes.in_progress')</th>
            </tr>
            </thead>
            <tbody>
            @forelse($items as  $key => $item)
                @php
                    $status = "not_paid"; // default
                    $css_class = "table-danger"; // default
                    $status_translation = __('general.not_paid'); // default
                    if (!empty($item->invoice_id) && $item->invoice_status == \App\Constants\GeneralConstants::TRANSACTION_VERIFIED) {
                        $status = 'paid';
                        $css_class = "table-primary";
                        $status_translation = __('general.paid');
                        if (!empty($item->order_id)) {
                            if ($item->order_status == \App\Constants\GeneralConstants::ORDER_STATUS_CREATED) {
                                $status = "order_created";
                                $css_class = "table-active";
                                $status_translation = __('general.order_created');
                            } elseif ($item->order_status == \App\Constants\GeneralConstants::ORDER_STATUS_COMPLETED) {
                                 if (!empty($item->order_end_date)) {
                                    $end_date = \Carbon\Carbon::createFromTimestamp($item->order_end_date);
                                    $days_remaining_to_renewal = $end_date->diffInDays(now());
                                }
                                $status = "order_completed";
                                $css_class = "table-success";
                                $status_translation = __('general.order_completed') . (!empty($days_remaining_to_renewal) ? " ($days_remaining_to_renewal)" : "");
                                if (!empty($item->order_end_date) && $item->order_end_date > now()->timestamp) {
                                    if ($days_remaining_to_renewal < 7) {
                                        $status = "close_to_renewal";
                                        $css_class = "table-warning";
                                        $status_translation = __('general.close_to_renewal') . (!empty($days_remaining_to_renewal) ? " ($days_remaining_to_renewal)" : "");
                                    }
                                } else {
                                    $status = "expired";
                                    $css_class = "table-expired";
                                    $status_translation = __('general.expired') . (!empty($days_remaining_to_renewal) ? " ($days_remaining_to_renewal)" : "");
                                }
                            }
                        }
                    }
                @endphp
                <tr class="{{ $status }} {{ $css_class }} font-size-11">
                    <td class="text-center">{{ $key+ $items->firstItem() }}</td>
                    <td class="text-center">{{ $status_translation }}</td>
                    <td>
                        <a href="{{ route('panel.profiles.edit', ['profile' => $item->profile_id]) }}" class="font-weight-bold" target="_blank">
                            {{ $item->name }}
                        </a>

                    </td>
                    <td class="text-center">
                        @can('see_mobile_number')
                            @if(!empty($item->mobile_number))
                                {{ $item->mobile_number }}
                                @if(!empty($item->mobile_number_verified_at))
                                    <small class="text-success">(verified)</small>
                                @endif
                            @else
                                <i class="fa fa-times" aria-hidden="true"></i>
                            @endif
                        @endcan
                    </td>
                    <td class="text-center">
                        @if(!empty($item->invoice_id))
                            <a href="{{ route('panel.invoices.edit', ['invoice' => $item->invoice_id]) }}"
                               target="_blank">
                                <small class="font-weight-bold">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    (@lang('general.invoice'))
                                </small>
                            </a>

                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(!empty($item->diet))
                            <a href="{{ route('panel.diets.edit', ['diet' => $item->diet->id]) }}" target="_blank" class="font-weight-bold">
                                {{ $item->diet->title }}
                            </a>
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($item->diet_period)
                            {{ $item->diet_period }}
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(!empty($item->cartItems))
                            {{
                                $item->cartItems->implode('diet.title', " | ")
                            }}
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($item->total_amount)
                            {{ money($item->total_amount) }}
                            @lang('general.toman')
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(!empty($item->order_id))
                            <a href="{{ route('panel.orders.edit', ['order' => $item->order_id]) }}"
                               class="font-weight-bold"
                               target="_blank">
                                <small class="font-weight-bold">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    (@lang('general.order'))
                                </small>
                            </a>
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($item->is_temp)
                            <i class="fa fa-check" aria-hidden="true"></i>
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(!empty($item->city))
                            {{ $item->city }}
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(!empty($item->payment_way))
                            {{ \Facades\App\Libraries\InvoiceHelper::translatePaymentWay($item->payment_way) }}
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(!empty($item->paid_at))
                            <div class="dir-ltr">
                                {{ jdateComplete($item->paid_at) }}
                            </div>
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(!empty($item->order_created_at))
                            <div class="dir-ltr">
                                {{ jdateComplete($item->order_created_at) }}
                            </div>
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(!empty($item->order_start_date))
                            <div class="dir-ltr">
                                {{ jdate($item->order_start_date) }}
                            </div>
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(!empty($item->order_end_date))
                            <div class="dir-ltr">
                                {{ jdate($item->order_end_date) }}
                            </div>
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>

                    @php
                        $order_week_number = null; // default (to reset the old values in the previous rows)
                        if (!empty($item->order_start_date) && !empty($item->order_end_date)) {
                            $order_start_date = \Carbon\Carbon::parse($item->order_start_date);
                            $order_end_date = \Carbon\Carbon::parse($item->order_end_date);
                            if($order_start_date->startOfDay() < now()->endOfDay() && $order_end_date->endOfDay() >= now()->startOfDay()) {
                               $days_left = $order_start_date->diffInDays() ;
                               $order_week_number = ceil( ($days_left + 1) / 7);
                            }
                        }
                    @endphp

                    <td class="text-center @if(!empty($order_week_number)) order-week order-week-{{ $order_week_number }} @endif">
                        @if(!empty($order_week_number))
                             @lang('general.week') <strong>{{ $order_week_number }}</strong><br>
                            @lang('general.day') <strong>{{ $days_left }}</strong>
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="dir-ltr">
                            {{ jdateComplete($item->profile_created_at) }}
                        </div>
                    </td>
                    <td class="text-center">
                        @if(!empty($item->invoice_created_at))
                            <div class="dir-ltr">
                                {{ jdateComplete($item->invoice_created_at) }}
                            </div>
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td class="text-center @if($item->is_dissatisfied) bg-danger @endif">
                        @if($item->is_dissatisfied)
                            <i class="fa fa-check" aria-hidden="true"></i>
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td class="text-center @if(!empty($item->inProgressBy)) bg-success text-white @else bg-danger @endif">
                        @if(!empty($item->inProgressBy))
                            @lang('general.by')
                            {{ $item->inProgressBy->name }}
                        @else
                            <i class="fa fa-times" aria-hidden="true"></i>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <th colspan="50" class="text-center">@lang('general.not_found')</th>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex mt-4 justify-content-center">
            {{ $items->links() }}
        </div>
    </div>
</div>


@pushonce('styles:/panel-assets/css/comprehensive-report.css')
<link href="{{ asset("/panel-assets/css/comprehensive-report.css?v=1.02") }}" rel="stylesheet">
@endpushonce
