<div class="d-flex flex-wrap table-invoices whiteBackColor px-2 py-2">
    <div class="d-flex flex-wrap w-100 py-3">
        <div class="item ml-5 d-flex align-items-center pos-relative">
            جزئیات سفارش
        </div>
        <div class="item ml-5 d-flex align-items-center pos-relative">
            <p>
                {{ jdateComplete($invoice->created_at)  }}
            </p>
        </div>
    </div>
    <div class="d-flex flex-wrap d-flex align-items-center w-100 py-3">
        <div class="item ml-5 d-flex align-items-center pos-relative">
            <span class="ml-2">کاربر :</span>
            <p>{{ $invoice->profile->name }}</p>
        </div>
        <div class="item ml-5 d-flex align-items-center pos-relative">
            <span class="ml-2">شماره تماس :</span>
            <p>
                @if(!empty($invoice->profile->user->mobile_number))
                    {{ $invoice->profile->user->mobile_number }}
                    @if(empty($invoice->profile->user->mobile_number_verified_at ))
                        -
                    @endif
                @endif
            </p>
        </div>
    </div>
    @foreach($invoice->invoiceItems as $invoice_item)
        <div class="d-flex flex-wrap d-flex align-items-center w-100 py-3">
            <div class="item ml-5 d-flex align-items-center pos-relative">
                <span class="ml-2">رژیم :</span>
                <p>
                    {{ $invoice_item->diet_registered_data->title }}
                </p>
            </div>
            <div class="item ml-5 d-flex align-items-center pos-relative">
                <span class="ml-2"> دوره :</span>
                <p>
                    {{ $invoice_item->diet_period }}
                </p>
            </div>
            <div class="item ml-5 d-flex align-items-center pos-relative">
                <span class="ml-2"> تعداد :</span>
                <p>
                    {{ $invoice_item->quantity }}
                </p>
            </div>

            <div class="item ml-5 d-flex align-items-center pos-relative">
                <span class="ml-2"> روزهای دوره :</span>
                <p>
                    {{ $invoice_item->diet_registered_data->duration_in_day }}
                </p>
            </div>

            <div class="item ml-5 d-flex align-items-center pos-relative">
                <span class="ml-2"> قیمت واحد :</span>
                <p>
                    {{ money($invoice_item->price) }}
                </p>
            </div>
        </div>
        <div class="d-flex flex-wrap d-flex align-items-center w-100 py-3">
            <div class="item ml-5 d-flex align-items-center pos-relative">
                <span class="ml-2">وضعیت :</span>
                <p>
                    @if(!empty($invoice_item->order))
                        <a href="{{ route('dashboard.orders.show', [ 'order' => $invoice_item->order->id ]) }}" class="kt-link kt-link--state kt-link--success">@lang('general.registered') - @lang('general.show') </a>
                    @else
                        <span  class="redColor">
                            {{ \Facades\App\Libraries\InvoiceHelper::translateInvoiceItemStatus($invoice_item) }}
                        </span>
                        @UserAjaxForm(['form_id' => "recheck-invoice-item-form-" . $invoice_item->id, 'is_update' => false ])@endAjaxForm
                        <form action="{{ route('dashboard.invoices.recheck-invoice-item', ['invoice_item' => $invoice_item->id]) }}"
                              id="recheck-invoice-item-form-{{ $invoice_item->id }}" method="post">
                            @csrf
                            <div class="form-group">
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <button class="submit-button submit-button paymentButton whiteColor orangeBack cursor-pointer mr-3" type="submit">@lang('general.recheck')</button>
                                </div>
                            </div>
                        </form>
                @endif
                </p>
            </div>
        </div>

        @endforeach

    <div class="d-flex flex-wrap d-flex align-items-center w-100 py-3">
        <div class="item ml-5 d-flex align-items-center pos-relative">
            <span class="ml-2">روش پرداخت :</span>
            <p>
                @if($invoice->payment_way == "ipg")
                    ipg - {{ $invoice->paymentGateway->title }}
                @else
                    {{ $invoice->payment_way }}
                @endif
            </p>
        </div>
        <div class="item ml-5 d-flex align-items-center pos-relative">
            <span class="ml-2"> مجموع :</span>
            <p>
                {{ money($invoice->total_amount) }}
            </p>
        </div>
    </div>
</div>
