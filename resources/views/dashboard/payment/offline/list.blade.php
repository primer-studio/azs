<div class="diets purchaseBoxes organizer relative">
    @forelse  ($offline_payments as $offline_payment)
        <div class="dietBox">
            <div class="topShelf">
                <div class="dietNameAndDate font-size-16 boldFont">
                    <a href="{{ route('dashboard.offline_payments.show', ['offline_payment' => $offline_payment->id]) }}">
                        مشاهده صورت حساب
                    </a>
                    <p class="font-size-12 grayColor  lightFont">{{ jdateComplete( $offline_payment->payment_date) }}</p>
                </div>
                <div class="dietKindAndDownload">
                    <div class="dietKind whiteColor inlineView font-size-12">
                        @switch($offline_payment->payment_type)
                            @case('card_to_card')
                            @lang('general.card_to_card')
                            @break
                            @case('deposit_by_bank_receipt')
                            @lang('general.deposit_by_bank_receipt')
                            @break
                        @endswitch

                    </div>
                </div>
            </div>
            <div class="bottomShelf">
                <div class="purchasePrice extraBoldFont greenColor">
                    {{ money($offline_payment->amount) }} تومان
                </div>
            </div>
        </div>
    @empty
        <div>
            @lang('general.not_found')
        </div>
    @endforelse

    {{ $offline_payments->links() }}
</div>
