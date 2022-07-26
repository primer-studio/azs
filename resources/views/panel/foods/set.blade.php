<div class="kt-portlet">
    <div class="kt-portlet__body">
        @AjaxForm(['form_id' => 'food-form', 'is_update' => isset($food) ])@endAjaxForm

        <form action="{{ isset($food) ? route('panel.foods.update', ['food' => $food->id]) : route('panel.foods.store') }}"
              id="food-form" method="post">
            @csrf

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>@lang('validation.attributes.title')</label>
                        <input name="title" type="text" class="form-control" @isset($food->title) value="{{ $food->title }}" @endisset>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>@lang('validation.attributes.unit')</label>
                        <input name="unit" type="text" class="form-control" @isset($food->unit) value="{{ $food->unit }}" @endisset>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>@lang('validation.attributes.calories_per_unit')</label>
                        <input name="calories_per_unit" type="number" class="form-control" @isset($food->calories_per_unit) value="{{ $food->calories_per_unit }}" @endisset>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>@lang('validation.attributes.description')</label>
                <textarea name="description"  class="hi-tinymce-editor form-control">@isset($food->description){{ $food->description }}@endisset</textarea>
            </div>
            <div class="form-group">
                <label>@lang('validation.attributes.status')</label>
                <select name="status" class="form-control">
                    <option @if(isset($food->status) && $food->status ==  'active') selected @endif value="active">@lang('general.active')</option>
                    <option @if(isset($food->status) && $food->status ==  'inactive') selected @endif value="inactive">@lang('general.inactive')</option>
                </select>
            </div>
            <div class="form-group">
                <label>@lang('validation.attributes.sort')</label>
                <input name="sort" type="number" class="form-control" @isset($food->sort) value="{{ $food->sort }}" @endisset>
            </div>
            <div class="form-group">
                @LfmUploadButton([
                'input_name'=> "image",
                'hide_input'=> false,
                'show_thumb'=> true,
                'file_type'=> "image",
                ])
                @isset($food->image){{ $food->image }}@endisset
                @endLfmUploadButton
            </div>


            @include('panel.includes.tinymce-editor')


            <div class="form-group">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button class="submit-button btn btn-success" type="submit">@lang('general.submit') <i class="la la-floppy-o p-0"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>


