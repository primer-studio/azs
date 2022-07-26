<input type="hidden" class="old-periods" @isset($diet->periods) value='{{ json_encode($diet->periods) }}' @endisset>

<div class="mb-4">
    <button type="button" class="add-period btn btn-bold btn-sm btn-label-brand">
        <i class="la la-plus"></i> @lang('general.add', ['title' => __('validation.attributes.period')])
    </button>
</div>

<div class="row periods-container">
</div>



<div class="col-lg-4 period-template d-none">
    <div class="kt-portlet  ">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">@lang('validation.attributes.period') <span class="number"></span></h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="kt-portlet__content">
                <div class="form-group">
                    <label>@lang('validation.attributes.duration_in_day')</label>
                    <input  type="number" class="duration_in_day form-control" >
                    <input  type="hidden" class="period_number" >
                </div>
                <div class="form-group">
                    <label>@lang('validation.attributes.price')</label>
                    <input type="number" class="price form-control" >
                </div>
                <div class="form-group">
                    <label>@lang('validation.attributes.status')</label>
                    <select class="status form-control">
                        <option  value="active">@lang('general.active')</option>
                        <option  value="inactive">@lang('general.inactive')</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

@pushonce('scripts:panel-diets/set-periods.js')
<script src="{{ asset("/panel-assets/js/diets/set-periods.js") }}"></script>
@endpushonce
