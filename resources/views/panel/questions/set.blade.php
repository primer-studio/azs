<div class="kt-portlet">
    <div class="kt-portlet__body">
        @AjaxForm(['form_id' => 'question-form', 'is_update' => isset($question) ])@endAjaxForm

        <form action="{{ isset($question) ? route('panel.questions.update', ['question' => $question->id]) : route('panel.questions.store') }}"
              id="question-form" method="post">
            @csrf

            <div class="row">
                <div class="col-lg-4">
                    {{--  TODO[validation]: make this dynamic to chanage when step changes (just questions in the selected step can be parent) --}}
                    <div class="form-group">
                        <label>@lang('validation.attributes.parent_question')</label>
                        <select name="parent_question_id" class="form-control">
                            <option selected value>@lang('general.none')</option>
                            @foreach($all_questions as $parent_question)
                                <option @if(isset($question->parent_question_id) && $question->parent_question_id == $parent_question->id ) selected @endif value="{{ $parent_question->id }}">{{ $parent_question->title }}</option>
                            @endforeach
                        </select>
                        <span class="form-text text-muted">@lang('general.parent_answer_guide')</span>
                    </div>
                </div>
                <div class="col-lg-5">
                    {{-- TODO[javascript]: only if parent_question_id is selecte, 'available_if_parent_answer_operator' and 'available_if_parent_answer_value' must be shown  --}}
                    <div class="form-group">
                        <label>@lang('validation.attributes.available_if_parent_answer_operator')</label>
                        <select name="available_if_parent_answer_operator" class="form-control">
                            <option value="none">@lang('general.always')</option>
                            <option @if(isset($question->available_if_parent_answer_operator) && $question->available_if_parent_answer_operator ==  'equal_to') selected @endif value="equal_to">@lang('general.if_parent_question_answer_equal_to')</option>
                            <option @if(isset($question->available_if_parent_answer_operator) && $question->available_if_parent_answer_operator ==  'greater_than') selected @endif value="greater_than">@lang('general.if_parent_question_answer_greater_than')</option>
                            <option @if(isset($question->available_if_parent_answer_operator) && $question->available_if_parent_answer_operator ==  'less_than') selected @endif value="less_than">@lang('general.if_parent_question_answer_less_than')</option>
                        </select>
                        <span class="form-text text-muted">@lang('general.available_if_parent_answer_operator_guide')</span>
                    </div>
                </div>
                <div class="col-lg-3">
                    {{--  TODO[validation]: make this dynamic to chanage when available_if_parent_answer_operator changes (show when available_if_parent_answer_operator is not none) --}}
                    <div class="form-group">
                        <label>@lang('validation.attributes.available_if_parent_answer_value')</label>
                        <input name="available_if_parent_answer_value" type="text" class="form-control" @isset($question->available_if_parent_answer_value) value="{{ $question->available_if_parent_answer_value }}" @endisset>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>@lang('validation.attributes.title')</label>
                <input name="title" type="text" class="form-control" @isset($question->title) value="{{ $question->title }}" @endisset>
            </div>

            <div class="form-group">
                <label>@lang('validation.attributes.short_name')</label>
                <input name="short_name" type="text" class="form-control" value="{{ isset($question->short_name) ? $question->short_name : "" }}">
            </div>

            <div class="form-group">
                <label class="kt-checkbox kt-checkbox--bold kt-checkbox--success">
                    <input type="checkbox"   name="is_required_to_receive_diet" id="is_required_to_receive_diet"  @if(!empty($question->is_required_to_receive_diet)) checked @endif >
                    @lang('general.is_required_to_receive_diet')
                    <span></span>
                </label>
            </div>

            {{--  TODO[validation]: make this dynamic--}}
            <div class="form-group">
               <label>@lang('validation.attributes.answer_properties.type')</label>
                <select name="answer_properties[type]" class="form-control">
                    <option @if(isset($question->answer_properties->type) && $question->answer_properties->type == "varchar") selected @endif value="varchar">@lang('general.varchar')</option>
                    <option @if(isset($question->answer_properties->type) && $question->answer_properties->type == "text") selected @endif value="text">@lang('general.text')</option>
                    <option @if(isset($question->answer_properties->type) && $question->answer_properties->type == "integer") selected @endif value="integer">@lang('general.integer')</option>
                    <option @if(isset($question->answer_properties->type) && $question->answer_properties->type == "decimal") selected @endif value="decimal">@lang('general.decimal')</option>
                    <option @if(isset($question->answer_properties->type) && $question->answer_properties->type == "checkbox") selected @endif value="checkbox">@lang('general.checkbox')</option>
                    <option @if(isset($question->answer_properties->type) && $question->answer_properties->type == "radio")  selected @endif value="radio">@lang('general.radio')</option>
                </select>
            </div>

            {{-- TODO[javascript]: all the following lines about options, must be implemented by javasctip, this is just for test --}}
            <div class="row">
                @isset($question->answer_properties->options)
                    @foreach($question->answer_properties->options as $key => $option)
                        <div class="col-lg-3">
                            <div class="card" >
                                <div class="card-body">
                                    <strong>Option {{ $key }}</strong>
                                    <div class="form-group">
                                        title: <input name="answer_properties[options][{{ $key }}][title]" type="text" class="form-control" value="{{ old('answer_properties.options.{$key}.title', isset($option->title ) ? $option->title : "" ) }}">
                                    </div>
                                    <div class="form-group">
                                        value: <input name="answer_properties[options][{{ $key }}][value]" type="text" class="form-control" value="{{ old('answer_properties.options.{$key}.value', isset($option->value ) ? $option->value : "" ) }}">
                                    </div>
                                    <div class="form-group">
                                        sort: <input name="answer_properties[options][{{ $key }}][sort]" type="text" class="form-control" value="{{ old('answer_properties.options.{$key}.sort', isset($option->sort ) ? $option->sort : "" ) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endisset()

                <div class="col-lg-3">
                    <div class="card" >
                        <div class="card-body">
                            <strong>Option 1</strong>
                            <div class="form-group">
                                title: <input name="answer_properties[options][o1][title]" type="text" class="form-control" value="{{ old('answer_properties.options.o1.title', isset($question->answer_properties->options->o1->title ) ? $question->answer_properties->options->o1->title : "" ) }}">
                            </div>
                            <div class="form-group">
                                value: <input name="answer_properties[options][o1][value]" type="text" class="form-control" value="{{ old('answer_properties.options.o1.value', isset($question->answer_properties->options->o1->value ) ? $question->answer_properties->options->o1->value : "" ) }}">
                            </div>
                            <div class="form-group">
                                sort: <input name="answer_properties[options][o1][sort]" type="text" class="form-control" value="{{ old('answer_properties.options.o1.sort', isset($question->answer_properties->options->o1->sort ) ? $question->answer_properties->options->o1->sort : "" ) }}">
                            </div>
                        </div>
                    </div>
                </div>
                {{--            <div class="col-lg-3">--}}
                {{--                <div class="card" >--}}
                {{--                    <div class="card-body">--}}
                {{--                        <strong>Option 2</strong>--}}
                {{--                        <div class="form-group">--}}
                {{--                            title: <input name="answer_properties[options][o2][title]" type="text" class="form-control" value="{{ old('answer_properties.options.o2.title', isset($question->answer_properties->options->o2->title ) ? $question->answer_properties->options->o2->title : "" ) }}">--}}
                {{--                        </div>--}}
                {{--                        <div class="form-group">--}}
                {{--                            value: <input name="answer_properties[options][o2][value]" type="text" class="form-control" value="{{ old('answer_properties.options.o2.value', isset($question->answer_properties->options->o2->value ) ? $question->answer_properties->options->o2->value : "" ) }}">--}}
                {{--                        </div>--}}
                {{--                        <div class="form-group">--}}
                {{--                            sort: <input name="answer_properties[options][o2][sort]" type="text" class="form-control" value="{{ old('answer_properties.options.o2.sort', isset($question->answer_properties->options->o2->sort ) ? $question->answer_properties->options->o2->sort : "" ) }}">--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--            </div>--}}
            </div>

            <div class="form-group">
                <label>@lang('validation.attributes.description')</label>
                <textarea name="description"  class="hi-tinymce-editor form-control">@isset($question->description){{ $question->description }}@endisset</textarea>
            </div>
            <div class="form-group">
                <label>@lang('validation.attributes.status')</label>
                <select name="status" class="form-control">
                    <option @if(isset($question->status) && $question->status ==  'active') selected @endif value="active">@lang('general.active')</option>
                    <option @if(isset($question->status) && $question->status ==  'inactive') selected @endif value="inactive">@lang('general.inactive')</option>
                </select>
            </div>
            <div class="form-group">
                <label>@lang('validation.attributes.sort')</label>
                <input name="sort" type="number" class="form-control" @isset($question->sort) value="{{ $question->sort }}" @endisset>
            </div>

            <div class="form-group">
                @LfmUploadButton([
                'input_name'=> "image",
                'hide_input'=> false,
                'show_thumb'=> true,
                'file_type'=> "image",
                ])
                @isset($question->image){{ $question->image }}@endisset
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


