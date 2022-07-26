<div class="kt-portlet">
    <div class="kt-portlet__body">
        @AjaxForm(['form_id' => 'step-form', 'is_update' => isset($step) ])@endAjaxForm

        <form action="{{ isset($step) ? route('panel.steps.update', ['step' => $step->id]) : route('panel.steps.store') }}"
              id="step-form" method="post">
            @csrf
            <div class="form-group">
                <label>@lang('general.diet')</label>
                <select name="diet_id" class="form-control">
                    <option value="0">[select]</option>
                    @foreach($all_diets as $diet)
                        <option value="{{ $diet->id }}" @isset($step) @if( $step->diet_id == $diet->id ) selected @endif  @endisset >{{ $diet->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>@lang('validation.attributes.period')</label>
                <input name="period" type="number" class="form-control" @isset($step->period) value="{{ $step->period }}" @endisset>
            </div>
            <div class="form-group">
                <label>@lang('validation.attributes.title')</label>
                <input name="title" type="text" class="form-control" @isset($step->title) value="{{ $step->title }}" @endisset>
            </div>
            <div class="form-group">
                <label>@lang('validation.attributes.description')</label>
                <textarea name="description"  class="hi-tinymce-editor form-control">@isset($step->description){{ $step->description }}@endisset</textarea>
            </div>

            <div class="form-group">
                <label>@lang('validation.attributes.status')</label>
                <select name="status" class="form-control">
                    <option @if(isset($step->status) && $step->status ==  'active') selected @endif value="active">@lang('general.active')</option>
                    <option @if(isset($step->status) && $step->status ==  'inactive') selected @endif value="inactive">@lang('general.inactive')</option>
                </select>
            </div>
            <div class="form-group">
                <label>@lang('validation.attributes.sort')</label>
                <input name="sort" type="number" class="form-control" @isset($step->sort) value="{{ $step->sort }}" @endisset>
            </div>

            <div class="form-group">
                @LfmUploadButton([
                'input_name'=> "image",
                'hide_input'=> false,
                'show_thumb'=> true,
                'file_type'=> "image",
                ])
                @isset($step->image){{ $step->image }}@endisset
                @endLfmUploadButton
            </div>

            @include('panel.steps.select-question')
            @include('panel.includes.tinymce-editor')

            <div class="form-group">

                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button class="submit-button btn btn-success" type="submit">@lang('general.submit') <i class="la la-floppy-o p-0"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
