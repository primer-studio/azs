@php
    // $default_empty_value if type is checkbox, must be an empty array ([]), otherwise it can be empty string ('')
    $default_empty_value = ($question->answer_properties->type == 'checkbox') ? [] : '';
    $db_or_default_old = isset($profile->data->{$question->short_name}) ? $profile->data->{$question->short_name} : $default_empty_value;
    $old = old("data." . $question->short_name, $db_or_default_old);
    // for checkbox if user selects none of options, then the old('checkbox_input_name') does not isset, so the $db_or_default_old will be used
    // but this is not the desired action, we want to select none of options in this situation
    if (!empty(old()) && $question->answer_properties->type == 'checkbox' && !isset(old()['data'][$question->short_name])) {
        $old = [];
    }
@endphp
<div class="card my-2">
    <div class="card-body">
        <strong class="card-title">{{ $question->title }}</strong>
        @switch($question->answer_properties->type)
            @case('varchar')
            <div class="form-group">
                <label for="question-{{ $question->id }}">{!! $question->description !!}</label>
                <textarea name="data[{{ $question->short_name }}]" class="form-control" id="question-{{ $question->id }}" rows="3">{{ $old }}</textarea>
            </div>
            @break

            @case('text')
            <div class="form-group">
                <label for="question-{{ $question->id }}">{!! $question->description !!}</label>
                <textarea name="data[{{ $question->short_name }}]" class="form-control" id="question-{{ $question->id }}" rows="3">{{ $old }}</textarea>
            </div>
            @break

            @case('integer')
            <div class="form-group">
                <label for="question-{{ $question->id }}">{!! $question->description !!}</label>
                <input name="data[{{ $question->short_name }}]" type="number" class="form-control" id="question-{{ $question->id }}" value="{{ $old }}">
            </div>
            @break

            @case('decimal')
            <div class="form-group">
                <label for="question-{{ $question->id }}">{!! $question->description !!}</label>
                <input name="data[{{ $question->short_name }}]" type="number" step="0.01" class="form-control" id="question-{{ $question->id }}" value="{{ $old }}">
            </div>
            @break

            @case('checkbox')
            @foreach($question->answer_properties->options as $key => $option)
                <div class="form-check">
                    <input name="data[{{ $question->short_name }}][]" class="form-check-input" @if(in_array($option->value, $old)) checked @endif type="checkbox" value="{{ $option->value }}" id="question-{{ $question->id }}-option-{{ $key }}">
                    <label class="form-check-label" for="question-{{ $question->id }}-option-{{ $key }}">
                        {{ $option->title }}
                    </label>
                </div>
            @endforeach
            @break

            @case('radio')
            @foreach($question->answer_properties->options as $key => $option)
                <div class="form-check">
                    <input name="data[{{ $question->short_name }}]" class="form-check-input" @if($old == $option->value) checked @endif type="radio" value="{{ $option->value }}" id="question-{{ $question->id }}-option-{{ $key }}">
                    <label class="form-check-label" for="question-{{ $question->id }}-option-{{ $key }}">
                        {{ $option->title }}
                    </label>
                </div>
            @endforeach
            @break

            @default
            <div class="form-group">
                <label for="question-{{ $question->id }}">{!! $question->description !!}</label>
                <textarea name="data[{{ $question->short_name }}]" class="form-control" id="question-{{ $question->id }}" rows="3">{{ $old }}</textarea>
            </div>
        @endswitch

    <!--begin::operator's comment-->

        <!--begin::Accordion-->
        @php
            // by default the accordion is close
            $card_title_class = 'collapsed';
            $target_class = '';
            $aria_expanded = 'false';

            $db_or_default_old_comment =  !empty($data_comments->{$question->id}) ? $data_comments->{$question->id} : "";
            $comment = old("data_comments." . $question->id, $db_or_default_old_comment);
            // if there is a comment for this question, let's open the accordion
            if(!empty($comment)) {
                $card_title_class = '';
                $target_class = 'show';
                $aria_expanded = 'true';
            }


        @endphp
        <div class="accordion accordion-light accordion-toggle-arrow data_comment_{{ $question->id }}_container" id="operator_comment_accordion_{{ $question->id }}">
            <div class="card mb-0">
                <div class="card-header" id="operator_comment_heading_{{ $question->id }}">
                    <div class="card-title {{ $card_title_class }}" data-toggle="collapse" data-target="#operator_comment_target_{{ $question->id }}" aria-expanded="{{ $aria_expanded }}" aria-controls="operator_comment_target_{{ $question->id }}">
                        <i class="flaticon-comment"></i>
                        <small>@lang('general.operator_comment') @lang('general.customer_does_not_see') </small>
                    </div>
                </div>
                <div id="operator_comment_target_{{ $question->id }}" class="collapse data_comment_{{ $question->id }} {{ $target_class }}" aria-labelledby="operator_comment_heading_{{ $question->id }}" data-parent="#operator_comment_accordion_{{ $question->id }}">
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <textarea name="data_comments[{{ $question->id }}]" class="form-control"  rows="3">{{ $comment }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Accordion-->
        <!--end::operator's comment-->

        @if(count($question->children))
            @include('panel.profiles.questions.questions' , ['questions' => $question->children])
        @endif
    </div>
</div>
