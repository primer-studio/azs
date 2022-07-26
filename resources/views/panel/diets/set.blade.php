<div class="kt-portlet">
    <div class="kt-portlet__body">
        @AjaxForm(['form_id' => 'diet-form', 'is_update' => isset($diet) ])@endAjaxForm

        <form action="{{ isset($diet) ? route('panel.diets.update', ['diet' => $diet->id]) : route('panel.diets.store') }}"
              id="diet-form" method="post">
            @csrf

            <div class="form-group">
                <label>@lang('validation.attributes.title')</label>
                <input name="title" type="text" class="form-control" @isset($diet->title) value="{{ $diet->title }}" @endisset>
            </div>
            <div class="form-group">
                <label>@lang('validation.attributes.description')</label>
                <textarea name="description"  class="hi-tinymce-editor form-control">@isset($diet->description){{ $diet->description }}@endisset</textarea>
            </div>
            <div class="form-group">
                <label>@lang('validation.attributes.duration_in_day')</label>
                <input name="duration_in_day" type="number" class="form-control" @isset($diet->duration_in_day) value="{{ $diet->duration_in_day }}" @endisset >
            </div>
            <div class="form-group">
                <label>@lang('validation.attributes.status')</label>
                <select name="status" class="form-control">
                    <option @if(isset($diet->status) && $diet->status ==  'active') selected @endif value="active">@lang('general.active')</option>
                    <option @if(isset($diet->status) && $diet->status ==  'inactive') selected @endif value="inactive">@lang('general.inactive')</option>
                </select>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input name="show_price_in_diets_list" type="checkbox" class="form-check-input" id="show_price_in_diets_list" @if( !empty($diet->show_price_in_diets_list)) checked @endif>
                    <label class="form-check-label" for="show_price_in_diets_list">@lang('general.show_price_in_diets_list')</label>
                </div>
            </div>
            <div class="form-group">
                <label>@lang('validation.attributes.sort')</label>
                <input name="sort" type="number" class="form-control" @isset($diet->sort) value="{{ $diet->sort }}" @endisset>
            </div>

            <div class="form-group">
                @LfmUploadButton([
                'input_name'=> "image",
                'hide_input'=> false,
                'show_thumb'=> true,
                'file_type'=> "image",
                ])
                @isset($diet->image){{ $diet->image }}@endisset
                @endLfmUploadButton
            </div>


            @include('panel.includes.tinymce-editor')

            @include('panel.diets.set-periods')

            <div class="form-group">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button class="submit-button btn btn-success" type="button">@lang('general.submit') <i class="la la-floppy-o p-0"></i></button>
                </div>
            </div>
        </form>
        <div>
            <h5>@lang('general.permission')</h5>
            @if(!empty($diet))
                @AjaxForm(['form_id' => 'set-permission-form', 'is_update' => false , 'confirm' => __('general.general_confirm')])@endAjaxForm
                <form method="post" action="{{ route('panel.diets.set-permission', ['diet' => $diet->id]) }}" id="set-permission-form">
                @csrf
                <div class="form-group mt-3">
                    @lang('general.need_permission_description')
                </div>
                <div class="form-group mt-1">
                    <div class="form-check">
                        <input name="need_permission" type="checkbox" class="form-check-input" id="need_permission" @if( !empty($diet->need_permission)) checked @endif>
                        <label class="form-check-label" for="need_permission">@lang('general.need_permission')</label>

                        @if($diet->need_permission)
                            <code class="mx-2">
                                {{ \App\Constants\GeneralConstants::DIET_PERMISSION_NAME_PREFIX . $diet->id }}
                            </code>
                        @endif
                    </div>
                </div>


                <div class="form-group">
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <button class="submit-button btn btn-success" type="button">@lang('general.submit') <i class="la la-floppy-o p-0"></i></button>
                    </div>
                </div>
            </form>
            @else
                you can assign permissions in edit page
            @endif
        </div>
    </div>
</div>


