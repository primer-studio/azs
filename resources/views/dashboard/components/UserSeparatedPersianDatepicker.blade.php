@php
    $selected_year = null;
    $selected_month = null;
    $selected_day = null;
    $string_slot = (string) $slot;
    if (!empty($string_slot)) {
        $selected_date = verta((integer) $string_slot);
        $selected_year = $selected_date->year;
        $selected_month = $selected_date->month;
        $selected_day = $selected_date->day;
    }
@endphp
<div class="mainQuestionBox organizer">
    <div class="questionInner d-flex">
        @isset($label){{ $label }}@endisset
    </div>
    <div class="answerContainer box-input flex-nowrap day-date-selected">
        {{-- <input name="date_of_birth" type="date" id="date_of_birth" value="{{ $profile->date_of_birth }}" class="fullWidth form-control input azshanbeInput"> --}}
        <div class="answerContainer box-input custom-select custom-select-gender">
            <select class="input azshanbeInput"
                    @isset($name)
                    name="{{ $name }}[day]"
                @endisset
            >
                @for ($i = 1; $i < 31; $i++)
                    <option value="{{ $i }}"
                      @if(!empty($selected_day) && $selected_day == $i) selected @endif
                    >{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="answerContainer box-input custom-select custom-select-gender">
            <select class="input azshanbeInput"
                    @isset($name)
                    name="{{ $name }}[month]"
                @endisset
            >
                <option value="1" @if(!empty($selected_month) && $selected_month == 1) selected @endif>فروردین</option>
                <option value="2" @if(!empty($selected_month) && $selected_month == 2) selected @endif>اردیبهشت</option>
                <option value="3" @if(!empty($selected_month) && $selected_month == 3) selected @endif>خرداد</option>
                <option value="4" @if(!empty($selected_month) && $selected_month == 4) selected @endif>تیر</option>
                <option value="5" @if(!empty($selected_month) && $selected_month == 5) selected @endif>مرداد</option>
                <option value="6" @if(!empty($selected_month) && $selected_month == 6) selected @endif>شهریور</option>
                <option value="7" @if(!empty($selected_month) && $selected_month == 7) selected @endif>مهر</option>
                <option value="8" @if(!empty($selected_month) && $selected_month == 8) selected @endif>آبان</option>
                <option value="9" @if(!empty($selected_month) && $selected_month == 9) selected @endif>آذر</option>
                <option value="10" @if(!empty($selected_month) && $selected_month == 10) selected @endif>دی</option>
                <option value="11" @if(!empty($selected_month) && $selected_month == 11) selected @endif>بهمن</option>
                <option value="12" @if(!empty($selected_month) && $selected_month == 12) selected @endif>اسفند</option>
            </select>
        </div>
        <div class="answerContainer box-input custom-select custom-select-gender">
            <select class=" input azshanbeInput"
                    @isset($name)
                    name="{{ $name }}[year]"
                @endisset
            >
                <option value>@lang('general.select')</option>
                @for ($i = 1320; $i <= verta()->year; $i++)
                    <option value="{{ $i }}"
                            @if(!empty($selected_year) && $selected_year == $i) selected @endif
                    >{{ $i }}</option>
                @endfor
            </select>
        </div>
    </div>
</div>
