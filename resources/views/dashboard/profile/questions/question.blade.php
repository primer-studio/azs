@php
    // $default_empty_value if type is checkbox, must be an empty array ([]), otherwise it can be empty string ('')
    $default_empty_value = ($question->answer_properties->type == 'checkbox') ? [] : '';
    $old = isset($profile->data->{$question->short_name}) ? $profile->data->{$question->short_name} : $default_empty_value;
@endphp
<div class="card my-2 mb-5">
    <div class="card-body">
        @switch($question->answer_properties->type)
            @case('varchar')
            <div class="mainQuestionBox organizer mb-5">
                <div class="questionInner">
                    {!! $question->title !!}
                </div>
                <div class="answerContainer box-input ">
                    <input name="data[{{ $question->short_name }}]"  id="question-{{ $question->id }}" value="{{ $old }}" type="text"  class="fullWidth input azshanbeInput">
                </div>
            </div>
            {{-- <div class="d-flex flex-wrap inputContainer">
                <label class="organizer">{!! $question->title !!}</label>
                <div class="organizer box-input">
                    <input name="data[{{ $question->short_name }}]"  id="question-{{ $question->id }}" value="{{ $old }}" type="text"  class="input azshanbeInput">
                </div>
            </div> --}}
            @break

            @case('text')
            <div class="mainQuestionBox organizer mb-5">
                <div class="questionInner">
                    {!! $question->title !!}
                </div>
                <div class="answerContainer box-input">
                    <textarea name="data[{{ $question->short_name }}]" class="fullWidth input azshanbeInput" id="question-{{ $question->id }}" rows="3">{{ $old }}</textarea>
                </div>
            </div>

            {{-- <div class="d-flex flex-wrap inputContainer">
                <label class="organizer">{!! $question->title !!}</label>
                <div class="organizer box-input">
                    <textarea name="data[{{ $question->short_name }}]" class="input azshanbeInput" id="question-{{ $question->id }}" rows="3">{{ $old }}</textarea>
                </div>
            </div> --}}
            @break

            @case('integer')
            <div class="mainQuestionBox organizer mb-5">
                <div class="questionInner">
                    {!! $question->title !!}
                </div>
                <div class="answerContainer box-input">
                    <input name="data[{{ $question->short_name }}]"  id="question-{{ $question->id }}" value="{{ $old }}" type="number"  class="fullWidth input azshanbeInput">
                </div>
            </div>
            
            {{-- <div class="d-flex flex-wrap inputContainer">
                <label class="organizer">{!! $question->title !!}</label>
                <div class="organizer box-input">
                    <input name="data[{{ $question->short_name }}]"  id="question-{{ $question->id }}" value="{{ $old }}" type="number"  class="input azshanbeInput">
                </div>
            </div> --}}
            @break

            @case('decimal')
            <div class="mainQuestionBox organizer mb-5">
                <div class="questionInner">
                    {!! $question->title !!}
                </div>
                <div class="answerContainer box-input">
                    <input name="data[{{ $question->short_name }}]" step="0.01"  id="question-{{ $question->id }}" value="{{ $old }}" type="number"  class="fullWidth input azshanbeInput">
                </div>
            </div>

            {{-- <div class="d-flex flex-wrap inputContainer">
                <label class="organizer">{!! $question->title !!}</label>
                <div class="organizer box-input">
                    <input name="data[{{ $question->short_name }}]" step="0.01"  id="question-{{ $question->id }}" value="{{ $old }}" type="number"  class="input azshanbeInput">
                </div>
            </div> --}}
            @break

            @case('checkbox')
            <div>
                <div class="mainQuestionBox organizer mb-5">
                    <div class="questionInner">
                        {!! $question->title !!}
                    </div>
                    <div class="answerContainer box-input">
                        @foreach($question->answer_properties->options as $key => $option)
                            <div class="checkOption w-100">
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

                {{-- <div class="d-flex flex-wrap inputContainer">
                    <label class="organizer">{!! $question->title !!}</label>
                </div>
                <div class="answerContainer">
                    @foreach($question->answer_properties->options as $key => $option)
                        <div class="checkOption w-100">
                            <label class="custom-checkbox1 box-input pos-relative d-flex align-items-center" for="question-{{ $question->id }}-option-{{ $key }}">
                                <input name="data[{{ $question->short_name }}][]" @if(in_array($option->value, $old)) checked @endif type="checkbox" value="{{ $option->value }}" id="question-{{ $question->id }}-option-{{ $key }}">
                                <span class="pos-relative d-flex align-items-center justify-content-center bullet"></span>
                                <span class="pos-relative d-flex align-items-center justify-content-center bullet2"></span>
                                <span class="text">{{ $option->title }}</span>
                            </label>
                        </div>
                    @endforeach
                </div> --}}
            </div>
            @break

            @case('radio')
            <div>
                <div class="mainQuestionBox organizer mb-5">
                    <div class="questionInner">
                        {!! $question->title !!}
                    </div>
                    <div class="answerContainer box-input">
                        @foreach($question->answer_properties->options as $key => $option)
                            <div class="radioOption w-100">
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

                {{-- <div class="d-flex flex-wrap inputContainer">
                    <label class="organizer">{!! $question->title !!}</label>
                </div>
                <div class="answerContainer">
                    @foreach($question->answer_properties->options as $key => $option)
                        <div class="radioOption w-100">
                            <label class="custom-radio1 box-input pos-relative d-flex align-items-center" for="question-{{ $question->id }}-option-{{ $key }}">
                                <input name="data[{{ $question->short_name }}]" @if($old == $option->value) checked @endif type="radio" value="{{ $option->value }}" id="question-{{ $question->id }}-option-{{ $key }}">
                                <span class="pos-relative d-flex align-items-center justify-content-center bullet"></span>
                                <span class="pos-relative d-flex align-items-center justify-content-center bullet2"></span>
                                <span class="text">{{ $option->title }}</span>
                            </label>
                        </div>
                    @endforeach
                </div> --}}
            </div>
            @break

            @default
            <div class="mainQuestionBox organizer mb-5">
                <div class="questionInner">
                    {!! $question->title !!}
                </div>
                <div class="answerContainer box-input">
                    <input name="data[{{ $question->short_name }}]"  id="question-{{ $question->id }}" value="{{ $old }}" type="text"  class="fullWidth input azshanbeInput">
                </div>
            </div>

            {{-- <div class="d-flex flex-wrap inputContainer">
                <label class="organizer">{!! $question->title !!}</label>
                <div class="organizer box-input">
                    <input name="data[{{ $question->short_name }}]"  id="question-{{ $question->id }}" value="{{ $old }}" type="text"  class="input azshanbeInput">
                </div>
            </div> --}}
        @endswitch
        @if(count($question->children))
            @include('dashboard.questions.questions' , ['questions' => $question->children])
        @endif
    </div>
</div>
