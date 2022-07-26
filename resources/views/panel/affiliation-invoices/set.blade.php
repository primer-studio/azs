<div class="kt-portlet">
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>@lang('general.affiliation_partner')</th>
                <th>@lang('general.invoice')</th>
                <th>@lang('general.profile')</th>
                <th>@lang('general.date') @lang('general.invoice')</th>
                <th>@lang('general.commission_registration_date')</th>
                <th>@lang('validation.attributes.status')</th>
                <th>@lang('general.change_status')</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <a href="{{ route('panel.affiliation-partners.edit', ['affiliation_partner' => $affiliation_invoice->affiliationPartner->id]) }}"
                       target="_blank">
                        {{ $affiliation_invoice->affiliationPartner->name }} -
                        <code>
                            {{ $affiliation_invoice->affiliationPartner->username }}
                        </code>
                    </a>
                </td>
                <td>
                    <a href="{{ route('panel.invoices.edit', ['invoice' => $affiliation_invoice->invoice->id]) }}"
                       target="_blank">
                        @lang('general.view')
                    </a>
                </td>
                <td>
                    <a href="{{ route('panel.profiles.edit', ['profile' => $affiliation_invoice->profile->id]) }}"
                       target="_blank">
                        {{ $affiliation_invoice->profile->name }}
                    </a>
                </td>
                <td>
                    {{ jdateComplete($affiliation_invoice->invoice->created_at) }}
                </td>
                <td>
                    {{ jdateComplete($affiliation_invoice->created_at) }}
                </td>
                <td>
                    {{ $affiliation_invoice->status }}
                </td>
                <td>
                    @AjaxForm(['form_id' => 'change-status-form', 'is_update' => true, 'confirm' => __('general.general_confirm') ])@endAjaxForm
                    <form action="{{ route('panel.affiliation-invoices.update', ['affiliation_invoice' => $affiliation_invoice->id]) }}" id="change-status-form" method="post">
                        @csrf
                        @php
                            $checkout_status = \App\Constants\GeneralConstants::AFFILIATION_INVOICE_STATUS_CHECKOUT;
                            $created_status = \App\Constants\GeneralConstants::AFFILIATION_INVOICE_STATUS_CREATED;
                            $change_status_to = ($affiliation_invoice->status == $checkout_status) ? $created_status : $checkout_status;
                            $change_status_to_label = ($affiliation_invoice->status == $checkout_status) ? __('general.checkout_pending') : __('general.checkout');
                            $button_class = ($affiliation_invoice->status == $checkout_status) ? 'danger' : 'success';
                        @endphp

                        <input type="hidden" name="status" value="{{ $change_status_to }}">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <button class="submit-button btn btn-{{ $button_class }}" type="submit">
                                @lang('general.change_status_to', ['status' => $change_status_to_label])
                            </button>
                        </div>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="kt-separator kt-separator--space-lg kt-separator--border-solid"></div>

        <table class="table">
            <thead>
            <tr>
                <th>
                    @lang('validation.attributes.amount')
                    @lang('general.invoice')
                    <small>(@lang('general.with') @lang('general.vat'))</small>
                </th>
                <th>
                    @lang('validation.attributes.amount')
                    @lang('general.invoice')
                    <small>(@lang('general.without') @lang('general.vat'))</small>
                </th>
                <th>
                    @lang('general.vat')
                </th>
                <th>
                    @lang('general.commission_rate')
                </th>
                <th>
                    @lang('general.commission_amount')
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    {{ money($affiliation_invoice->invoice->total_amount) }}
                    @lang('general.toman')
                </td>
                <td>
                    <span class="kt-link kt-link--state kt-link--danger">
                        {{ money($affiliation_invoice->invoice->total_amount_without_vat) }}
                        @lang('general.toman')
                    </span>
                </td>
                <td>
                    <span class="kt-link kt-link--state kt-link--primary">
                        {{ $affiliation_invoice->invoice->vat }} %
                    </span>
                </td>
                <td>
                    {{ $affiliation_invoice->commission_rate }} %
                </td>
                <td>
                    <span class="kt-link kt-link--state kt-link--success">
                        {{ money($affiliation_invoice->commission_amount) }}
                        @lang('general.toman')
                    </span>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</div>





