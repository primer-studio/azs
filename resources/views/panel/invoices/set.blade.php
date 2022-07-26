@pushonce('styles:panel-template/assets/css/pages/invoices/invoice-2.css')
<!--begin::Page Custom Styles(used by this page) -->
<link href="{{ asset('/panel-assets/template/assets/css/pages/invoices/invoice-2.css') }}" rel="stylesheet" type="text/css" />
<!--end::Page Custom Styles -->
@endpushonce

<div class="kt-portlet">
    <div class="kt-portlet__body kt-portlet__body--fit">
        <div class="kt-invoice-2">
            <div class="kt-invoice__head pb-1">
                <div class="kt-invoice__container">
                    <div class="kt-invoice__brand">
                        <h4>@lang('general.invoice')</h4>
                        <div href="#" class="kt-invoice__logo">
                            <span class="kt-invoice__desc">
                                <span>
                                    <a href="{{ route('panel.profiles.edit', ['profile' => $invoice->profile->id]) }}">{{ $invoice->profile->name }}</a>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="kt-invoice__items mt-0">
                        <div class="row w-100 pt-3">
                            <div class="col-lg-6 d-flex justify-content-between">
                                <div>
                                    @lang('general.date') @lang('general.create') @lang('general.invoice'):
                                </div>
                                <div class="text-left dir-ltr font-weight-bold">{{ jdateComplete($invoice->created_at)  }}</div>
                            </div>
                            @if(!empty($invoice->paid_at))
                                <div class="col-lg-6 d-flex justify-content-between">
                                    <div>
                                        @lang('general.date') @lang('general.payment') @lang('general.invoice'):
                                    </div>
                                    <div class="text-left dir-ltr font-weight-bold">{{ jdateComplete($invoice->paid_at)  }}</div>
                                </div>
                            @endif
                            @if(!empty($invoice->invoice_number))
                                <div class="col-lg-6 font-weight-bold d-flex justify-content-between">
                                    <div>
                                        @lang('general.invoice'):
                                    </div>
                                    <div class="text-left dir-ltr">{{  $invoice->invoice_number  }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-invoice__body">
                <div class="kt-invoice__container">
                    <div>
                        <div class="form-group">
                            <label>@lang('validation.attributes.status'):</label>
                            <span class="font-weight-bold">
                                {{ \Facades\App\Libraries\InvoiceHelper::translateInvoiceStatus($invoice->status) }}
                            </span>
                        </div>

                        @if($invoice->status != \App\Constants\GeneralConstants::TRANSACTION_VERIFIED)
                            @AjaxForm(['form_id' => 'invoice-form', 'is_update' => isset($invoice), 'confirm' =>
                            __('invoice.status_change_confirm') ])@endAjaxForm
                            <form action="{{ route('panel.invoices.update', ['invoice' => $invoice->id]) }}"
                                  id="invoice-form" method="post">
                                @csrf
                                <div class="form-group">
                                    <input name="status" type="hidden"
                                           value="{{ \App\Constants\GeneralConstants::TRANSACTION_VERIFIED }}">
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <button class="submit-button btn btn-success"
                                                type="submit">@lang('general.change_status_to', ['status' => __('invoice.TRANSACTION_VERIFIED')])
                                            <i class="la la-floppy-o p-0"></i></button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>

                @if($invoice->payment_way == \App\Constants\GeneralConstants::PAYMENT_WAY_OFFLINE)
                    <!--begin::offline payment data-->
                        <h6>@lang('invoice.offline_payment_info')</h6>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('validation.attributes.amount')</th>
                                    <th scope="col">@lang('validation.attributes.payment_date')</th>
                                    <th scope="col">@lang('validation.attributes.payment_type')</th>
                                    <th scope="col">@lang('validation.attributes.tracking_number')</th>
                                    <th scope="col">@lang('validation.attributes.card_number')</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ money($invoice->offlinePayment->amount, true) }}  @lang('general.toman')</td>
                                    <td>{{ jdateComplete($invoice->offlinePayment->payment_date) }}</td>
                                    <td>{{ \Facades\App\Libraries\InvoiceHelper::trnaslateOfflinePaymentStatus($invoice->offlinePayment) }}</td>
                                    <td>{{ $invoice->offlinePayment->tracking_number }}</td>
                                    <td>{{ $invoice->offlinePayment->card_number }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--end::offline payment data-->
                @else
                    <!--begin::online payment data-->
                        <h6>@lang('invoice.online_payment_info')</h6>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('validation.attributes.tracking_number')</th>
                                    <th scope="col">@lang('invoice.payment_code')</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        {{ $invoice->refid }}
                                    </td>
                                    <td>
                                        {{ $invoice->payment_code }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--end::online payment data-->
                    @endif


                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>@lang('general.diet')</th>
                                <th>@lang('validation.attributes.period')</th>
                                <th>@lang('general.quantity')</th>
                                <th>@lang("validation.attributes.duration_in_day")</th>
                                <th>@lang('validation.attributes.status')</th>
                                <th>@lang("validation.attributes.price")</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoice->invoiceItems as $invoice_item)
                                <tr>
                                    <td>{{ $invoice_item->diet_registered_data->title }}</td>
                                    <td>{{ $invoice_item->diet_period }}</td>
                                    <td>{{ $invoice_item->quantity }}</td>
                                    <td>{{ $invoice_item->diet_registered_data->duration_in_day }}</td>
                                    <td class="font-weight-normal">
                                        @if(!empty($invoice_item->order))
                                            <a href="{{ route('panel.orders.edit', [ 'order' => $invoice_item->order->id ]) }}"
                                               class="kt-link kt-link--state kt-link--success">@lang('general.registered')
                                                - @lang('general.show') </a>
                                        @else
                                            <span class="kt-link kt-link--state kt-link--danger">
                                                {{ \Facades\App\Libraries\InvoiceHelper::translateInvoiceItemStatus($invoice_item) }}
                                            </span>
                                            @AjaxForm(['form_id' => "recheck-invoice-item-form-" . $invoice_item->id,
                                            'is_update' => false ])@endAjaxForm
                                            <form
                                                action="{{ route('panel.invoices.recheck-invoice-item', ['invoice_item' => $invoice_item->id]) }}"
                                                id="recheck-invoice-item-form-{{ $invoice_item->id }}" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <div class="btn-group" role="group"
                                                         aria-label="Button group with nested dropdown">
                                                        <button class="submit-button btn btn-success"
                                                                type="submit">@lang('general.recheck')</button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="kt-font-danger kt-font-lg">{{ money($invoice_item->price) }} @lang('general.toman')</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="kt-invoice__footer">
                <div class="kt-invoice__container">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>payment way</th>
                                <th>ACC.NO.</th>
                                <th>mobile</th>
                                <th>TOTAL AMOUNT</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    @if($invoice->payment_way == \App\Constants\GeneralConstants::PAYMENT_WAY_IPG)
                                        ipg - {{ $invoice->paymentGateway->title }}
                                    @else
                                        {{ $invoice->payment_way }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('panel.profiles.edit', ['profile' => $invoice->profile->id]) }}">{{ $invoice->profile->name }}</a>
                                </td>
                                <td>
                                    @can('see_mobile_number')
                                        @if(!empty($invoice->profile->user->mobile_number))
                                            <div>
                                                {{ $invoice->profile->user->mobile_number }}
                                                @if(empty($invoice->profile->user->mobile_number_verified_at ))
                                                    (Unverified)
                                                @endif
                                            </div>
                                        @endif
                                    @endcan
                                </td>
                                <td class="kt-font-danger kt-font-xl kt-font-boldest">{{ money($invoice->total_amount) }} @lang('general.toman')</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="kt-invoice__actions">
                <div class="kt-invoice__container">
                    <button type="button" class="btn btn-label-brand btn-bold" onclick="window.print();">Download
                        Invoice
                    </button>
                    <button type="button" class="btn btn-brand btn-bold" onclick="window.print();">Print Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
