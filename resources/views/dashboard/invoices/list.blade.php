<div class="diets purchaseBoxes organizer relative">
    @forelse  ($invoices as $invoice)
        <div class="dietBox whiteBackColor">
            <div class="topShelf">
                <div class="dietNameAndDate font-size-16 boldFont">
                    <a href="{{ route('dashboard.invoices.show', ['invoice' => $invoice->id]) }}">
                        مشاهده صورت حساب
                    </a>
                    <p class="font-size-12 grayColor  lightFont">{{ jdateComplete( $invoice->created_at) }}</p>
                </div>
                <div class="dietKindAndDownload">
                    <div class="dietKind whiteColor inlineView font-size-12">
                        @switch($invoice->payment_way)
                            @case('offline')
                                پرداخت آفلاین
                            @break
                            @case('ipg')
                                پرداخت آنلاین
                            @break
                        @endswitch

                    </div>
                </div>
            </div>
            <div class="bottomShelf">
                <div class="purchasePrice extraBoldFont greenColor">
                    {{ money($invoice->total_amount) }} تومان
                </div>
            </div>
        </div>
    @empty
        <div>
            @lang('general.not_found')
        </div>
    @endforelse

    {{ $invoices->links() }}
</div>
