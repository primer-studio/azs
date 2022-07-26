<div class="kt-portlet">
    <div class="kt-portlet__body">
        @AjaxForm(['form_id' => 'affiliation_partner-form', 'is_update' => isset($affiliation_partner) ])@endAjaxForm

        <form action="{{ isset($affiliation_partner) ? route('panel.affiliation-partners.update', ['affiliation_partner' => $affiliation_partner->id]) : route('panel.affiliation-partners.store') }}"
              id="affiliation_partner-form" method="post">
            @csrf

            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>@lang('validation.attributes.name')</label>
                        <input name="name" type="text" class="form-control" @isset($affiliation_partner->name) value="{{ $affiliation_partner->name }}" @endisset>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>@lang('validation.attributes.mobile')</label>
                        <input name="mobile_number" type="text" class="form-control" @isset($affiliation_partner->mobile_number) value="{{ $affiliation_partner->mobile_number }}" @endisset>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>@lang('validation.attributes.username')</label>
                        <input name="username" type="text" class="form-control" @isset($affiliation_partner->username) value="{{ $affiliation_partner->username }}" @endisset>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>@lang('validation.attributes.commission_rate')</label>
                        <input name="commission_rate" type="number" step=".01" class="form-control" @isset($affiliation_partner->commission_rate) value="{{ $affiliation_partner->commission_rate }}" @endisset>
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
                            <option @if(isset($affiliation_partner->status) && $affiliation_partner->status ==  'active') selected @endif value="active">@lang('general.active')</option>
                            <option @if(isset($affiliation_partner->status) && $affiliation_partner->status ==  'inactive') selected @endif value="inactive">@lang('general.inactive')</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>@lang('validation.attributes.description')</label>
                        <textarea name="description"  class="hi-tinymce-editor form-control">@isset($affiliation_partner->description){{ $affiliation_partner->description }}@endisset</textarea>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button class="submit-button btn btn-success" type="submit">@lang('general.submit') <i class="la la-floppy-o p-0"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

@if(!empty($affiliation_partner))
    <div class="kt-portlet">
        <div class="kt-portlet__body">
            <table class="table">
                <thead>
                <tr>
                    <th>@lang('general.affiliation_invoices_unpaid_commission_amount')</th>
                    <th>@lang('general.affiliation_invoices_unpaid_count')</th>
                    <th>@lang('general.sales')</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($affiliation_invoice_summary))
                    <tr>
                        <td>
                            @if(isset($affiliation_invoice_summary))
                                {{ money( $affiliation_invoice_summary->total_commission_amount) }}
                                @lang('general.toman')
                            @else
                                {{ money(0) }}
                            @endif
                        </td>
                        <td>
                            @if(isset($affiliation_invoice_summary))
                                {{ $affiliation_invoice_summary->count }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('panel.affiliation-invoices.index', ['affiliation_partner_id' => $affiliation_partner->id]) }}" target="_blank">@lang('general.view')</a>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>@lang('general.not_found')</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endif
