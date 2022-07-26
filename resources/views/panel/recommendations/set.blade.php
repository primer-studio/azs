<div class="kt-portlet">
    <div class="kt-portlet__body">
        @AjaxForm(['form_id' => 'recommendation-form', 'is_update' => isset($recommendation) ])@endAjaxForm

        <form action="{{ isset($recommendation) ? route('panel.recommendations.update', ['recommendation' => $recommendation->id]) : route('panel.recommendations.store') }}"
              id="recommendation-form" method="post">
            @csrf

            <div class="form-group">
                <label>@lang('validation.attributes.title')</label>
                <input name="title" type="text" class="form-control" @isset($recommendation->title) value="{{ $recommendation->title }}" @endisset>
            </div>

            <div class="form-group">
                <label>@lang('validation.attributes.description')</label>
                <textarea name="description"  class="hi-tinymce-editor form-control">@isset($recommendation->description){{ $recommendation->description }}@endisset</textarea>
            </div>
            <div class="form-group">
                <label>@lang('validation.attributes.status')</label>
                <select name="status" class="form-control">
                    <option @if(isset($recommendation->status) && $recommendation->status ==  'active') selected @endif value="active">@lang('general.active')</option>
                    <option @if(isset($recommendation->status) && $recommendation->status ==  'inactive') selected @endif value="inactive">@lang('general.inactive')</option>
                </select>
            </div>
            <div class="form-group">
                <label>@lang('validation.attributes.sort')</label>
                <input name="sort" type="number" class="form-control" @isset($recommendation->sort) value="{{ $recommendation->sort }}" @endisset>
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


