<!--begin::search box-->
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                @lang('general.search')
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <form method="GET" action="{{ route('panel.affiliation-partners.index') }}">
            <div class="row">
                <div class="col-lg-2">
                    <div class="form-group">
                        <label>@lang('validation.attributes.name')</label>
                        <input name="name" type="text" class="form-control" @isset($affiliation_partner->name) value="{{ $affiliation_partner->name }}" @endisset>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label>@lang('validation.attributes.mobile')</label>
                        <input name="mobile_number" type="text" class="form-control" @isset($affiliation_partner->mobile_number) value="{{ $affiliation_partner->mobile_number }}" @endisset>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label>@lang('validation.attributes.username')</label>
                        <input name="username" type="text" class="form-control" @isset($affiliation_partner->username) value="{{ $affiliation_partner->username }}" @endisset>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>@lang('validation.attributes.card_number')</label>
                        <input name="card_number" type="text" class="form-control" @isset($affiliation_partner->card_number) value="{{ $affiliation_partner->card_number }}" @endisset>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label>@lang('validation.attributes.status')</label>
                        <select name="status" class="form-control">
                            <option value="">@lang('general.select')</option>
                            <option @if(isset($affiliation_partner->status) && $affiliation_partner->status ==  'active') selected @endif value="active">@lang('general.active')</option>
                            <option @if(isset($affiliation_partner->status) && $affiliation_partner->status ==  'inactive') selected @endif value="inactive">@lang('general.inactive')</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <button class="submit-button btn btn-success" type="submit">@lang('general.search') <i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--end::search box-->

<!--begin:: list-->
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                @lang('general.list', ['title' => __('general.affiliation_partners')])
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('validation.attributes.name')</th>
                <th>@lang('validation.attributes.username')</th>
                <th>@lang('validation.attributes.mobile')</th>
                <th>@lang('general.affiliation_invoices_unpaid_commission_amount')</th>
                <th>@lang('general.affiliation_invoices_unpaid_count')</th>
                <th>@lang('validation.attributes.status')</th>
                <th>@lang('general.sales')</th>
                <th>edit</th>
            </tr>
            </thead>
            <tbody>
            @forelse  ($affiliation_partners as $affiliation_partner)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $affiliation_partner->name }}</td>
                    <td>
                        <code>
                            {{ $affiliation_partner->username }}
                        </code>
                    </td>
                    <td>{{ $affiliation_partner->mobile_number }}</td>
                    <td>
                        <span class="kt-link kt-link--state kt-link--success">
                            @if(isset($affiliation_invoice_summary[$affiliation_partner->id]))
                                <strong>
                                    {{ money( $affiliation_invoice_summary[$affiliation_partner->id]->total_commission_amount) }}
                                </strong>
                                @lang('general.toman')
                            @else
                                {{ money(0) }}
                            @endif
                        </span>
                    </td>
                    <td>
                        <span class="kt-link kt-link--state kt-link--primary">
                            <strong>
                                @if(isset($affiliation_invoice_summary[$affiliation_partner->id]))
                                    {{ $affiliation_invoice_summary[$affiliation_partner->id]->count }}
                                @endif
                            </strong>
                        </span>
                    </td>
                    <td>{{ $affiliation_partner->status }}</td>
                    <td>
                        <a href="{{ route('panel.affiliation-invoices.index', ['affiliation_partner_id' => $affiliation_partner->id]) }}"
                           target="_blank">@lang('general.view')</a>
                    </td>
                    <td>
                        <a href="{{ route('panel.affiliation-partners.edit', ['affiliation_partner' => $affiliation_partner->id]) }}">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <th colspan="6">No affiliation_partners</th>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex mt-4 justify-content-center">
            {{ $affiliation_partners->links() }}
        </div>
    </div>
</div>
<!--end:: list-->
