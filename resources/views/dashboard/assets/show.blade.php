{{ $diet->title }}
{!! $diet->description !!}
@if(!Facades\App\Libraries\SettingHelper::getSettings()->user_must_pay_without_answering_diet_required_questions)
    @if(!empty($diet->active_periods_steps_questions))
        <div>
            <a id="dynamic-next-page-link"
               href="{{ route('dashboard.diets.show-step', ['slug' => $diet->slug, 'period' => $diet->active_periods_steps_questions->keys()->first(), 'step_number' => 1]) }}">دریافت رژیم</a>
        </div>
{{--        <div class="box-input custom-select select-diet-dashbord custom-select-gender">--}}
{{--            <select name="" id="select-period" class="azshanbeInput">--}}
{{--                @foreach($diet->active_periods_steps_questions as $period_number => $period)--}}
{{--                    <option data-value="@lang('validation.attributes.period') {{ $period_number }}" value="{{ route('dashboard.diets.show-step', ['slug' => $diet->slug, 'period' => $period_number, 'step_number' => 1]) }}">@lang('validation.attributes.period') {{ $period_number }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}

{{--        @pushonce('scripts:dashboard-js/diets/select-diet-period.js')--}}
{{--        <script src="{{ asset("/dashboard-assets/js/diets/select-diet-period.js") }}"></script>--}}
{{--        @endpushonce--}}
    @else
        <a href="{{  route('dashboard.pay-with-diet-slug', ['diet_slug' => $diet->slug, 'period' => 1, 'step_number' => 1]) }}">get this diet</a>
    @endif
@else
    <a href="{{  route('dashboard.pay-with-diet-slug', ['diet_slug' => $diet->slug, 'period' => 1, 'step_number' => 1]) }}">get this diet</a>
@endif
