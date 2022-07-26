<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h5 class="kt-portlet__head-title">
                @lang('general.add_to_cart')
            </h5>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th class="text-center">@lang('general.diet')</th>
                <th class="text-center">@lang('validation.attributes.period')</th>
                <th class="text-center">@lang('validation.attributes.duration_in_day')</th>
                <th class="text-center">@lang('validation.attributes.price')</th>
                <th></th>
            </tr>
            </thead>
                <tbody>
                    @forelse(\Facades\App\Libraries\DietHelper::getAllDiets() as $diet)
                        @foreach($diet->periods as $period)
                            @if(!empty($diet->active_periods_steps_questions->keys()->first())
                                &&
                                \Facades\App\Libraries\DietHelper::canGetDiet($profile->user, $diet)
                                && $period->status == 'active'
                                )
                                <tr>
                                    <td class="text-center" >{{ $diet->title }}</td>
                                    <td class="text-center">{{ $period->period }}</td>
                                    <td class="text-center">{{ $period->duration_in_day }}</td>
                                    <td class="text-center">{{ $period->price }}</td>
                                    <td class="text-center">
                                        @php
                                            $form_id = "add_diet_to_cart_" . $diet->id . "_" . $period->period;
                                        @endphp
                                        @AjaxForm(['form_id' => $form_id, 'is_update' => false ])@endUserAjaxForm
                                        <form id="{{ $form_id }}" class="create-invoice-by-cart" method="post" action="{{ route('panel.cart-items.add-diet-to-cart', ['profile' => $profile->id]) }}">
                                            @csrf
                                            <input type="hidden" name="diet_id" value="{{ $diet->id }}">
                                            <input type="hidden" name="period" value="{{ $period->period }}">
                                            <button class="submit-button btn btn-primary" type="button">
                                                 @lang('general.add_to_cart')
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @empty
                    @endif
                </tbody>
        </table>
    </div>
</div>
