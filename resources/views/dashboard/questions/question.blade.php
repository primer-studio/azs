@php
    // $default_empty_value if type is checkbox, must be an empty array ([]), otherwise it can be empty string ('')
    $default_empty_value = ($question->answer_properties->type == 'checkbox') ? [] : '';
    $old = isset($profile->data->{$question->short_name}) ? $profile->data->{$question->short_name} : $default_empty_value;
@endphp

@switch($question->answer_properties->type)
    @case('varchar')
    <div class="mainQuestionBox organizer">
        <div class="questionInner d-flex">
            {!! $question->title !!}
            {{-- icon icon-info --}}
            <span class="questionGuideLine  middleContext darkPinkColor open-modal cursor-pointer" data-target=".helpmodal-question-{{$question->id}}">
                <span class="guideText">راهنما</span>
            </span>
        </div>
        <div class="answerContainer box-input">
            <input name="data[{{ $question->short_name }}]"  id="question-{{ $question->id }}" value="{{ $old }}" type="text"  class="fullWidth input  azshanbeInput" placeholder="پاسخ شما">
        </div>
    </div>
    @break

    @case('text')
    <div class="d-flex flex-wrap inputContainer">
        <label class="organizer">{!! $question->title !!}</label>
        <div class="organizer box-input">
            <textarea name="data[{{ $question->short_name }}]" class="input azshanbeInput" id="question-{{ $question->id }}" rows="3">{{ $old }}</textarea>
        </div>
    </div>
    @break

    @case('integer')
    <div class="mainQuestionBox organizer">
        <div class="questionInner  d-flex">
            {!! $question->title !!}
            <span class="questionGuideLine  middleContext darkPinkColor open-modal cursor-pointer" data-target=".helpmodal-question-{{$question->id}}">
                <span class="guideText">راهنما</span>
            </span>
        </div>
        <div class="answerContainer box-input">
            <input name="data[{{ $question->short_name }}]"  id="question-{{ $question->id }}" value="{{ $old }}" type="number"  class="fullWidth input  azshanbeInput" placeholder="پاسخ شما">
        </div>
    </div>
    @break

    @case('decimal')
    <div class="mainQuestionBox organizer">
        <div class="questionInner  d-flex" >
            {!! $question->title !!}
            <span class="questionGuideLine  middleContext darkPinkColor open-modal cursor-pointer" data-target=".helpmodal-question-{{$question->id}}">
                <span class="guideText">راهنما</span>
            </span>
        </div>
        <div class="answerContainer box-input">
            <input name="data[{{ $question->short_name }}]"  step="0.01" id="question-{{ $question->id }}" value="{{ $old }}" type="number"  class="fullWidth input  azshanbeInput" placeholder="پاسخ شما">
        </div>
    </div>
    @break

    @case('checkbox')
    <div class="mainQuestionBox organizer">
        <div class="questionInner d-flex">
            {!! $question->title !!}
            <span class="questionGuideLine  middleContext darkPinkColor open-modal cursor-pointer" data-target=".helpmodal-question-{{$question->id}}">
                <span class="guideText">راهنما</span>
            </span>
        </div>
        <div class="answerContainer">
            @foreach($question->answer_properties->options as $key => $option)
                <div class="checkOption">
                    <label class="custom-checkbox1 box-input pos-relative d-flex align-items-center" for="question-{{ $question->id }}-option-{{ $key }}">
                        <input name="data[{{ $question->short_name }}][]" @if(in_array($option->value, $old)) checked @endif type="checkbox" value="{{ $option->value }}" id="question-{{ $question->id }}-option-{{ $key }}">
                        <span class="pos-relative d-flex align-items-center justify-content-center bullet"></span>
                        <span class="pos-relative d-flex align-items-center justify-content-center bullet2"></span>
                        <span class="text">{{ $option->title }}</span>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
    @break

    @case('radio')
    <div class="mainQuestionBox organizer">
        <div class="questionInner d-flex">
            {!! $question->title !!}
            <span class="questionGuideLine  middleContext darkPinkColor open-modal cursor-pointer" data-target=".helpmodal-question-{{$question->id}}">
                <span class="guideText">راهنما</span>
            </span>
        </div>
        <div class="answerContainer">
            @foreach($question->answer_properties->options as $key => $option)
                <div class="radioOption">
                    <label class="custom-radio1 box-input pos-relative d-flex align-items-center" for="question-{{ $question->id }}-option-{{ $key }}">
                        <input name="data[{{ $question->short_name }}]" @if($old == $option->value) checked @endif type="radio" value="{{ $option->value }}" id="question-{{ $question->id }}-option-{{ $key }}">
                        <span class="pos-relative d-flex align-items-center justify-content-center bullet"></span>
                        <span class="pos-relative d-flex align-items-center justify-content-center bullet2"></span>
                        <span class="text">{{ $option->title }}</span>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
    @break

    @default
    <div class="d-flex flex-wrap inputContainer">
        <label class="organizer">{!! $question->title !!}</label>
        <div class="organizer box-input">
            <input name="data[{{ $question->short_name }}]"  id="question-{{ $question->id }}" value="{{ $old }}" type="text"  class="input azshanbeInput">
        </div>
    </div>
@endswitch

<div class="popUpBox modal-question editProfile helpmodal helpmodal-question-{{$question->id}}" >
    <div class="popUpCloseBack hidden cursor-pointer close-modal" data-target=".helpmodal-question-{{$question->id}}"></div>
    <div class="popUpWhiteBox relative edit-profile-form">
        <div class="popUpBoxHeader font-size-16 boldFont organizer">
            <div class="popUpBoxTitle rightFloat">
                راهنمای سوالات
            </div>
            <div class="popUpBoxCross leftFloat">
                <span class="pos-relative icon icon-close cursor-pointer close-modal"  data-target=".helpmodal-question-{{$question->id}}"></span>
            </div>
        </div>
        <div class="popUpBoxContent font-size-14">
            {!! $question->description !!}
        </div>
    </div>
</div>

@if(count($question->children))
    @include('dashboard.questions.questions' , ['questions' => $question->children])
@endif

