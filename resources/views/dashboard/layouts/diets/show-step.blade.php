<div class="questionContainer container organizer whiteBackColor">

    {{--        <div class="questionSteps">--}}
    {{--            <span class="beforeStep"></span>--}}
    {{--            <span class="middleStep">--}}
    {{--                @foreach($all_steps as $number => $step)--}}
    {{--                    @php--}}
    {{--                        // because $number starts from 0 we will +1 it--}}
    {{--                        $loop_step_number = $number + 1;--}}
    {{--                        if ($loop_step_number < $step_number) {--}}
    {{--                            $class_name = 'beforeActive';--}}
    {{--                        } elseif ($loop_step_number == $step_number) {--}}
    {{--                            $class_name = 'active';--}}
    {{--                        } elseif ($loop_step_number > $step_number) {--}}
    {{--                            $class_name = 'afterActive';--}}
    {{--                        }--}}
    {{--                    @endphp--}}
    {{--                    <span class="stepBox {{ $class_name }}">--}}
    {{--                    <span class="stepNumber">--}}
    {{--                     {{ $loop_step_number }}--}}
    {{--                    </span>--}}
    {{--                    <span class="stepLine"></span>--}}
    {{--                </span>--}}
    {{--                @endforeach--}}
    {{--            </span>--}}
    {{--            <span class="afterSteps"></span>--}}
    {{--        </div>--}}
    <div class="smallPaddingSpace desktop-835-max-width ">

        @if($step_number > 1)
            <div class="organizer d-flex">
                <div class="stepBack font-size-11 cursor-pointer">
                    <span class="icon icon-backward middleContext"></span>
                    <a href="{{ route('dashboard.diets.show-step', ['step_number' => $step_number - 1, 'period' => $period,'slug' => $diet->slug]) }}">
                        مرحله قبل
                    </a>
                </div>
            </div>
        @endif

        <div class="mainQuestions organizer">
            <div class="desktopVersion questionCategories"><span>سوالات پزشکی</span></div>
            <div>
                <p class="lead">{{ $current_step->description }}</p>
                @UserAjaxForm(['form_id' => 'questions', 'is_update' => false ])@endUserAjaxForm
                <form action="{{ route('dashboard.diets.save-step-data', ['step_number' => $step_number, 'period' => $period,'slug' => $diet->slug]) }}" method="post" id="questions">
                @csrf
                @if($current_step->questions_tree)
                    @include('dashboard.questions.questions' , ['questions' => $current_step->questions_tree])
                @endif
                <!--begin::submit button-->
                    <div class="organizer desktopCenterText">
                        <button type="submit" class="submit-button greenBackColor whiteColor organizer register cursor-pointer">
                            <span class="rightFloat font-size-14 boldFont">@lang('general.submit')</span>
                            <span class="icon icon-forward font-size-18 leftFloat"></span>
                        </button>
                    </div>
                    <!--end::submit button-->
                </form>


                @push('scripts')
                    <script src="{{ asset('/dashboard-assets/js/steps/step.js') }}"></script>
                @endpush

            </div>
        </div>
    </div>
</div>
