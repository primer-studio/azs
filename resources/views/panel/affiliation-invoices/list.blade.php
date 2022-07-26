<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                @lang('general.affiliation_invoices')
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('general.affiliation_partner')</th>
                <th>@lang('validation.attributes.username')</th>
                <th>@lang('general.commission_amount')</th>
                <th>@lang('general.invoice')</th>
                <th>@lang('general.profile')</th>
                <th>@lang('general.date') @lang('general.invoice')</th>
                <th>@lang('general.commission_registration_date')</th>
                <th>edit</th>
            </tr>
            </thead>
            <tbody>
            @forelse  ($affiliation_invoices as $affiliation_invoice)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>
                        <a href="{{ route('panel.affiliation-partners.edit', ['affiliation_partner' => $affiliation_invoice->affiliationPartner->id]) }}" target="_blank">
                            {{ $affiliation_invoice->affiliationPartner->name }}
                        </a>
                    </td>
                    <td>
                        <code>
                            {{ $affiliation_invoice->affiliationPartner->username }}
                        </code>
                    </td>
                    <td>
                        <span class="kt-link kt-link--state kt-link--success">
                            {{ money($affiliation_invoice->commission_amount) }}
                        @lang('general.toman')
                    </span>
                    </td>
                    <td>
                        <a href="{{ route('panel.invoices.edit', ['invoice' => $affiliation_invoice->invoice->id]) }}" target="_blank">
                            @lang('general.view')
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('panel.profiles.edit', ['profile' => $affiliation_invoice->profile->id]) }}" target="_blank">
                            {{ $affiliation_invoice->profile->name }}
                        </a>
                    </td>
                    <td>
                        {{ jdateComplete($affiliation_invoice->invoice->created_at) }}
                    </td>
                    <td>
                        {{ jdateComplete($affiliation_invoice->created_at) }}
                    </td>
                    <td><a href="{{ route('panel.affiliation-invoices.edit', ['affiliation_invoice' => $affiliation_invoice->id]) }}">Edit</a></td>
                </tr>
            @empty
                <tr>
                    <th colspan="6">No affiliation_invoices</th>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex mt-4 justify-content-center">
            {{ $affiliation_invoices->links() }}
        </div>
    </div>
</div>

