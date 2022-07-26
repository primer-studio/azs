<!--begin::cart-->
@php
    $cart_items = \Facades\App\Libraries\CartHelper::getCurrentProfileCartItems();
@endphp

<div class="menuWhiteBox2 mt-3 py-3 px-2">
    <ul class="tab-title">
        <li class="cursor-pointer pos-relative">
            <span class="menuItemIcon icon icon-cart"></span>
            <div class="menuItem px-2 py-2">
                @lang('general.cart')  <span class="d-flex align-items-center justify-content-center notifNumber notifNumber-bag">{{ count($cart_items) }}</span>
            </div>
        </li>
    </ul>
    @forelse($cart_items as $cart_item)
        <div class="cart-item bag-cart-item d-flex align-items-center justify-content-between flex-wrap w-100 mb-2 px-2 py-2">
            <div>
                {{ $cart_item->diet->title }} @lang('validation.attributes.period') {{ $cart_item->period }}
            </div>
            <div class="d-flex align-items-center">
                <span class="price">{{ money($cart_item->diet->selected_period->price, true) }} تومان</span>

                @php
                    $form_id = "remove-cart-item-form-" . $cart_item->id;
                @endphp

                @UserAjaxForm(['form_id' => $form_id, 'is_update' => false ])@endUserAjaxForm
                <form id="{{ $form_id }}" class="remove-cart-item-form" method="post" action="{{ route('dashboard.remove-diet-from-cart') }}">
                    @csrf
                    <input type="hidden" name="cart_item_id" value="{{ $cart_item->id }}">
                    <button class="submit-button paymentButton whiteColor orangeBack cursor-pointer mr-2" type="button">
                        &#x2715;
                    </button>
                </form>
            </div>

            @if($cart_item->diet->status != 'active' || $cart_item->diet->selected_period->status != 'active')
                <div class="redColor">
                    <small>(@lang('general.this_period_is_inactive'))</small>
                </div>
            @endif

            <div class="pos-relative d-flex align-items-center w-100 box-continuation">
                {{-- <span class="redColor" >*</span> --}}
                @if(!empty($cart_item->last_activity_url))
                    <a class="mr-3" href="{{ url($cart_item->last_activity_url) }}">@lang('general.continue')</a>
                @endif
            </div>
        </div>
        

    @empty
        @lang('general.empty')
    @endforelse

    @if(!empty($cart_items) && count($cart_items) )
        <a class="d-flex align-items-center justify-content-center a-checkout" href="{{ route('dashboard.proforma-invoice') }}">
            @lang('general.go_to_checkout')
        </a>
    @endif

</div>
<!--end::cart-->
