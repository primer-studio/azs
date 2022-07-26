<div class="diets purchaseBoxes organizer relative">
    @forelse($profile->notifications as $notification)
        {{$notification->markAsRead()}}
        @switch($notification->type)
            @case('App\Notifications\OrderCompleted')
            <div class="dietBox">
                <div class="topShelf">
                    <div class="font-size-16 boldFont">
                        <a href="{{ route('dashboard.orders.show' , ['order' => $notification->data['order_id']]) }}">
                            طراحی
                            {{ $notification->data['diet_title'] }}
                            دوره
                            {{$notification->data['selected_period']['period'] }}
                            کامل شد
                        </a>
                    </div>
                    <div class="dietKindAndDownload">
                        <span class="dietKind whiteColor inlineView font-size-12">
                            {{ jdateComplete($notification->created_at) }}
                        </span>
                    </div>
                </div>
            </div>
            @break
            @case('App\Notifications\OrderCreated')
            <div class="dietBox">
                <div class="topShelf">
                    <div class="font-size-16 boldFont">
                        <a href="{{ route('dashboard.orders.show' , ['order' => $notification->data['order_id']]) }}">
                            طراحی
                            {{ $notification->data['diet_title'] }}
                            دوره
                            {{$notification->data['selected_period']['period'] }}
                            آغاز شد
                        </a>
                    </div>
                    <div class="dietKindAndDownload">
                        <span class="dietKind whiteColor inlineView font-size-12">
                            {{ jdateComplete($notification->created_at) }}
                        </span>
                    </div>
                </div>
            </div>
            @break
            @case('App\Notifications\OfflinePaymentVerified')
            <div class="dietBox">
                <div class="topShelf">
                    <div class="font-size-16 boldFont">
                        <a href="{{ route('dashboard.invoices.show' , ['invoice' => $notification->data['invoice_id']]) }}">
                            پرداخت آفلاین تایید شد
                        </a>
                    </div>
                    <div class="dietKindAndDownload">
                        <span class="dietKind whiteColor inlineView font-size-12">
                            {{ jdateComplete($notification->created_at) }}
                        </span>
                    </div>
                </div>
            </div>
            @break

            @case('App\Notifications\PendingInvoiceItem')
            <div class="dietBox">
                <div class="topShelf">
                    <div class="font-size-16 boldFont">
                        <a href="{{ route('dashboard.invoices.show' , ['invoice' => $notification->data['invoice_id']]) }}">
                            توقف طراحی رژیم به دلیل کامل نبودن پروفایل
                        </a>
                    </div>
                    <div class="dietKindAndDownload">
                        <span class="dietKind whiteColor inlineView font-size-12">
                            {{ jdateComplete($notification->created_at) }}
                        </span>
                    </div>
                </div>
            </div>
            @break

            @case('App\Notifications\InvoicePaid')
            <div class="dietBox">
                <div class="topShelf">
                    <div class="font-size-16 boldFont">
                        <a href="{{ route('dashboard.invoices.show' , ['invoice' => $notification->data['invoice_id']]) }}">
                            صورت حساب پرداخت شد
                        </a>
                    </div>
                    <div class="dietKindAndDownload">
                        <span class="dietKind whiteColor inlineView font-size-12">
                            {{ jdateComplete($notification->created_at) }}
                        </span>
                    </div>
                </div>
            </div>
            @break
        @endswitch
    @empty
        <div>
            @lang('general.not_found')
        </div>
    @endforelse
</div>
