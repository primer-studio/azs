<div class="diets purchaseBoxes organizer relative">
    @forelse  ($orders as $order)
        <div class="dietBox whiteBackColor">
            <div class="topShelf">
                <div class="dietNameAndDate font-size-16 boldFont">
                    <!-- <a href=""> -->
                    {{-- {{ route('dashboard.orders.show' , ['order' => $order->id]) }} --}}
{{--                    <a class="button-primary" href="{{ route('dashboard.orders.show' , ['order' => $order->id]) }}" target="_blank">--}}
{{--                        رژيم شماره {{ $loop->iteration }}--}}
{{--                    </a>--}}
                    <a>{{ $order->invoiceItem->diet_registered_data->title }}</a>
                    <a style="margin-right: 5px; background: #61C9A8; padding: 5px 10px ; color: white; border-radius: 5px" href="{{ route('dashboard.orders.show' , ['order' => $order->id]) }}" target="_blank">
                         نمایش
                    </a>
                    <div style="height: 10px"></div>
                    <p class="font-size-12 grayColor  lightFont">{{ jdate($order->created_at, true, "F Y") }}</p>
                </div>
                <div class="dietKindAndDownload">
{{--                    <div class="dietKind whiteColor inlineView font-size-12">--}}
{{--                        {{ $order->invoiceItem->diet_registered_data->title }}--}}
{{--                        دوره--}}
{{--                        {{ $order->invoiceItem->diet_registered_data->selected_period->period }}--}}
{{--                    </div>--}}
                    <span class="separator inlineView"></span>
                    @if(!empty($order->file))
                    <div class="download greenColor inlineView textInCenter middleContext">
                        <a href="{{ url($order->file) }}" target="_blank" class="font-size-14">  </a>
                        <span class="icon icon-download"></span>
                        <!--begin::download file-->
                        <p class="font-size-14"> دانلود </p>

                        <!--end::download file-->
                        <!-- <a href="" target="_blank">
                            {{-- <a href="" target="_blank"> --}}
                            {{-- @lang('general.download')
                            @lang('general.file')
                            @lang('general.diet') --}}
                        </a> -->

                    </div>
                    @endif
                </div>
            </div>
            <div class="bottomShelf">
                <div class="purchasePrice extraBoldFont greenColor">
                    {{ money($order->invoiceItem->price, true, true) }} تومان
                </div>
                <div class="purchaseNumber lightFont font-size-14 grayColor">#{{ $order->id }}</div>
            </div>
        </div>
    @empty
        <div>
            @lang('general.not_found')
        </div>
    @endforelse
</div>
