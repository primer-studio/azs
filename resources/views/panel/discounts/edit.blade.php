<div class="kt-portlet">
    <div class="kt-portlet__body">
        <h4 style="margin-bottom: 2%">ویرایش کد تخفیف {{ $discount->title }} [<code>{{$discount->hash}}</code>]</h4>
        <form action="{{ route('panel.discounts.edit', ['id' => $discount->id]) }}"
              id="discount-form" method="post">
            @csrf

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>@lang('general.title')</label>
                        <input name="title" type="text" class="form-control" value="{{ $discount->title }}">
                    </div>
                    <div class="form-group">
                        <label>@lang('general.code')</label>
                        <input name="hash" id="hash" type="text" class="form-control" value="{{ $discount->hash }}">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>@lang('general.type')</label>
                        <select name="type" id="type" class="form-control">
                            <option value="simple" @if($discount->type == 'simple') selected @endif>ساده</option>
                            <option value="percentage" @if($discount->type == 'percentage') selected @endif>درصد</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>@lang('general.amount')</label>
                        <input name="amount" id="amount" type="number" class="form-control" value="{{ $discount->amount }}">
                        <p class="text-danger">تنها عدد وارد کنید. <strong>عدد درصد و یا مقدار به ریال</strong></p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <p>@lang('general.properties')</p>
                        <input type="checkbox" class="form-check-inline" name="is_otu" id="is_otu" @if($discount->is_otu) checked @endif>
                        <label class="form-check-label" for="is_otu">@lang('general.one_time_use')</label>
                        <span class="clearfix"></span>
                        <input type="checkbox" class="form-check-inline" name="is_active" id="is_active" @if($discount->is_active) checked @endif>
                        <label class="form-check-label" for="is_active">@lang('general.active')</label>
                    </div>
                </div>
            </div>
{{--            <div class="col-12">--}}
{{--                <div class="form-group">--}}
{{--                    <label><textarea name="description"  class="hi-tinymce-editor form-control">@isset($sport->description){{ $sport->description }}@endisset</textarea> @lang('validation.attributes.description')</label>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="form-group">--}}
{{--                <label>@lang('validation.attributes.status')</label>--}}
{{--                <select name="status" class="form-control">--}}
{{--                    <option @if(isset($sport->status) && $sport->status ==  'active') selected @endif value="active">@lang('general.active')</option>--}}
{{--                    <option @if(isset($sport->status) && $sport->status ==  'inactive') selected @endif value="inactive">@lang('general.inactive')</option>--}}
{{--                </select>--}}
{{--            </div>--}}
{{--            <div class="form-group">--}}
{{--                <label>@lang('validation.attributes.sort')</label>--}}
{{--                <input name="sort" type="number" class="form-control" @isset($sport->sort) value="{{ $sport->sort }}" @endisset>--}}
{{--            </div>--}}

            @include('panel.includes.tinymce-editor')


            <div class="form-group">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button class="submit-button btn btn-success" type="submit">@lang('general.submit') <i class="la la-floppy-o p-0"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>


