@php
    $cart_items = \Facades\App\Libraries\CartHelper::getCartItems($profile->id);
@endphp

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h5 class="kt-portlet__head-title">
                @lang('general.cart')  <span class="">({{ count($cart_items) }})</span>
            </h5>
        </div>
    </div>
    <div class="kt-portlet__body">
        @forelse($cart_items as $cart_item)
            <div class="cart-item bag-cart-item d-flex align-items-center justify-content-between flex-wrap w-100 mb-2 px-2 py-2">
                <div>
                    <a href="{{ route('panel.diets.edit', ['diet' => $cart_item->diet->id]) }}" target="_blank">
                        {{ $cart_item->diet->title }} @lang('validation.attributes.period') {{ $cart_item->period }}
                    </a>
                </div>
                <div class="d-flex align-items-center">
                    <span class="price mx-3">{{ money($cart_item->diet->selected_period->price, true) }} تومان</span>

                    @php
                        $form_id = "remove-cart-item-form-" . $cart_item->id;
                    @endphp

                    @AjaxForm(['form_id' => $form_id, 'is_update' => false ])@endUserAjaxForm
                    <form id="{{ $form_id }}" class="remove-cart-item-form" method="post" action="{{ route('panel.cart-items.remove-diet-from-cart', ['profile' => $profile->id]) }}">
                        @csrf
                        <input type="hidden" name="cart_item_id" value="{{ $cart_item->id }}">
                        <button class="submit-button btn btn-danger cursor-pointer mr-2" type="button">
                            &#x2715;
                        </button>
                    </form>
                </div>

                @if($cart_item->diet->status != 'active' || $cart_item->diet->selected_period->status != 'active')
                    <div class="text-danger">
                        <small>(@lang('general.this_period_is_inactive'))</small>
                    </div>
                @endif

            </div>
        @empty
            @lang('general.empty')
        @endforelse

        @if($cart_items->count())
            @AjaxForm(['form_id' => "create-invoice-by-cart", 'is_update' => false ])@endUserAjaxForm
            <form id="create-invoice-by-cart" class="create-invoice-by-cart" method="post" action="{{ route('panel.cart-items.create-invoice-by-cart', ['profile' => $profile->id]) }}">
                @csrf
                <input type="hidden" name="cart_item_id" value="{{ $cart_item->id }}">
                <button class="submit-button btn btn-success cursor-pointer mr-2" type="button">
                     @lang('general.create')
                     @lang('general.invoice')
                </button>
            </form>
        @endif
    </div>
</div>
