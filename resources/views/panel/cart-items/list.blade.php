<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h5 class="kt-portlet__head-title">
                @lang('general.cart_items')
            </h5>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('general.profile')</th>
                <th>@lang('validation.attributes.mobile')</th>
                <th>@lang('general.diet')</th>
                <th>@lang('validation.attributes.period')</th>
                <th>@lang('general.last') @lang('validation.attributes.status')</th>
                <th>@lang('general.updated_at')</th>
                <th>@lang('general.auto_reminder_sms_sent_at')</th>
                <th>@lang('general.auto_reminder_sms_count')</th>
                <th>@lang('general.manual_reminder_sms_sent_at')</th>
                <th>@lang('general.manual_reminder_sms_count')</th>
                <th>@lang('general.send_reminder_sms')</th>
            </tr>
            </thead>
            <tbody>
            @forelse  ($cart_items as $cart_item)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>
                        <a href="{{ route('panel.profiles.edit', ['profile' => $cart_item->profile->id]) }}" target="_blank">
                            {{ $cart_item->profile->name }}
                        </a>
                    </td>
                    <td>
                        @can('see_mobile_number')
                            @if(!empty($cart_item->profile->user->mobile_number_verified_at))
                                {{ $cart_item->profile->user->mobile_number }}
                            @endif
                        @endcan
                    </td>
                    <td>
                        <a href="{{ route('panel.diets.edit', ['diet' => $cart_item->diet->id]) }}" target="_blank">
                            {{ $cart_item->diet->title }}
                        </a>
                    </td>
                    <td>
                        <strong>{{ $cart_item->period }}</strong>
                    </td>
                    <td class="font-weight-bold">
                        @if($cart_item->is_proforma_invoice)
                            @lang('general.proforma_invoice')
                        @else
                            @lang('validation.attributes.step')
                            {{ $cart_item->step_number }}
                        @endif
                    </td>
                    <td>
                        <span class="kt-link kt-link--state kt-link--info">
                            {{ jdateComplete($cart_item->updated_at) }} -
                            <strong>
                                {{ dateDiff($cart_item->updated_at) }}
                            </strong>
                        </span>
                    </td>
                    <td>
                        <span class="kt-link kt-link--state kt-link--success">
                            @if(!empty($cart_item->auto_reminder_sms_sent_at))
                                {{ jdateComplete($cart_item->auto_reminder_sms_sent_at) }} -
                                <strong>
                                    {{ dateDiff($cart_item->auto_reminder_sms_sent_at) }}
                                </strong>
                            @endif
                        </span>
                    </td>
                    <td>
                        <span class="kt-link kt-link--state kt-link--success">
                            {{ $cart_item->auto_reminder_sms_count }}
                        </span>
                    </td>
                    <td>
                        <span class="kt-link kt-link--state kt-link--success">
                            @if(!empty($cart_item->manual_reminder_sms_sent_at))
                                {{ jdateComplete($cart_item->manual_reminder_sms_sent_at) }} -
                                <strong>
                                    {{ dateDiff($cart_item->manual_reminder_sms_sent_at) }}
                                </strong>
                            @endif
                        </span>
                    </td>
                    <td>
                        <span class="kt-link kt-link--state kt-link--success">
                            {{ $cart_item->manual_reminder_sms_count }}
                        </span>
                    </td>
                    <td>
                        @if(!empty($cart_item->profile->user->mobile_number_verified_at))
                            @AjaxForm(['form_id' => "send-reminder-sms-form-" . $cart_item->id , 'is_update' => false])@endAjaxForm
                            <form action="{{ route('panel.cart-items.send-reminder-sms', ['cart_item' => $cart_item->id]) }}" id="send-reminder-sms-form-{{ $cart_item->id }}" method="post">
                                @csrf
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <button class="submit-button btn btn-hover-primary" type="submit">
                                        @lang('general.send')
                                    </button>
                                </div>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <th colspan="6">
                        @lang('general.not_found')
                    </th>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex mt-4 justify-content-center">
            {{ $cart_items->links() }}
        </div>
    </div>
</div>

