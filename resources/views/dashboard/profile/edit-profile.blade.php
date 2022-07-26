{{-- TODO[check-view]: these codes are temporary to test, re-write UI with proper codes, set validation errors (check controller validate too), set old data, ... --}}

<div class="editProfile mainForm whiteBackColor mainQuestions organizer px-4 py-4">

    @if (session('check_profile_required_data_middleware_message'))
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var message = '{{ session('check_profile_required_data_middleware_message') }}';
                    createMassage(message, 'invalid');
                })
            </script>
        @endpush
    @endif
    @UserAjaxForm(['form_id' => 'edit-profile', 'is_update' => false ])@endUserAjaxForm

    <form method="post" id="edit-profile"
          action="{{ route('dashboard.my-profiles.update', ['profile' => $profile->id]) }}">
        @csrf

        <div class="mainQuestionBox organizer">
            <div class="questionInner d-flex">
                @lang('validation.attributes.name')
            </div>
            <div class="answerContainer box-input">
                <input class="fullWidth input azshanbeInput" type="text" name="name" value="{{ $profile->name }}">
            </div>
        </div>

        {{-- <div class="d-flex flex-wrap inputContainer">
            <label class="organizer">@lang('validation.attributes.name')</label>
            <div class="organizer box-input">
                <input name="name" type="text" value="{{ $profile->name }}" class="input azshanbeInput">
            </div>
        </div> --}}


        <div class="mainQuestionBox organizer">
            <div class="questionInner d-flex">
                @lang('validation.attributes.gender')
            </div>
            <div class="answerContainer box-input custom-select custom-select-gender">
                <select name="gender" class="fullWidth input azshanbeInput"  id="gender">
                    <option @if( $profile->gender == 'male' ) selected @endif value="male">مرد</option>
                    <option @if( $profile->gender == 'female' ) selected @endif value="female">زن</option>
                </select>
            </div>
        </div>

        <!--begin::date of birth-->
        @UserSeparatedPersianDatepicker([
        "label" => __('validation.attributes.date_of_birth'),
        "name" => 'date_of_birth',
        ])
        {{ $profile->date_of_birth }}
        @endUserSeparatedPersianDatepicker
        <!--end::date of birth-->

        <!--begin::height-->
        <div class="mainQuestionBox organizer">
            <div class="questionInner d-flex">
                @lang('validation.attributes.height') (سانتی متر)
            </div>
            <div class="answerContainer box-input">
                <input name="height" type="number" value="{{ $profile->height }}" class="fullWidth input azshanbeInput">
            </div>
        </div>

        {{-- <div class="d-flex flex-wrap inputContainer">
            <label class="organizer">@lang('validation.attributes.height') (سانتی متر)</label>
            <div class="organizer box-input">
                <input name="height" type="number" value="{{ $profile->height }}" class="input azshanbeInput">
            </div>
        </div> --}}
        <!--end::height-->

        <!--begin::marital_status-->

        <div class="mainQuestionBox organizer">
            <div class="questionInner d-flex">
                @lang('validation.attributes.marital_status')
            </div>
            <div class="answerContainer box-input custom-select custom-select-gender">
                <select name="marital_status"  class="fullWidth input azshanbeInput"  id="marital_status">
                    <option @if( $profile->marital_status == 'single' ) selected @endif value="single">مجرد</option>
                    <option @if( $profile->marital_status == 'married' ) selected @endif value="married">متاهل</option>
                </select>
            </div>
        </div>


        {{-- <div class="d-flex flex-wrap inputContainer marital_status-box marital_status">
            <label class="organizer">@lang('validation.attributes.marital_status')</label>
            <div class="box-input custom-select custom-select-marital_status">
                <select name="marital_status"  id="marital_status">
                    <option @if( $profile->marital_status == 'single' ) selected @endif value="single">مجرد</option>
                    <option @if( $profile->marital_status == 'married' ) selected @endif value="married">متاهل</option>
                </select>
            </div>
        </div> --}}
        <!--end::marital_status-->

        <!--begin::last_diet-->
        <div class="mainQuestionBox organizer">
            <div class="questionInner d-flex">
                @lang('validation.attributes.last_diet')
            </div>
            <div class="answerContainer box-input">
                <input name="last_diet" type="text" value="{{ $profile->last_diet }}" class="fullWidth input azshanbeInput">
            </div>
        </div>

        {{-- <div class="d-flex flex-wrap inputContainer">
            <label class="organizer">@lang('validation.attributes.last_diet')</label>
            <div class="organizer box-input">
                <input name="last_diet" type="text" value="{{ $profile->last_diet }}" class="input azshanbeInput">
            </div>
        </div> --}}
        <!--end::last_diet-->

        <!--begin::blood_type-->
        <div class="mainQuestionBox organizer">
            <div class="questionInner d-flex">
                @lang('validation.attributes.blood_type')
            </div>
            <div class="answerContainer box-input">
                <input name="blood_type" type="text" value="{{ $profile->blood_type }}" class="fullWidth input azshanbeInput">
            </div>
        </div>

        {{-- <div class="d-flex flex-wrap inputContainer">
            <label class="organizer">@lang('validation.attributes.blood_type')</label>
            <div class="organizer box-input">
                <input name="blood_type" type="text" value="{{ $profile->blood_type }}" class="input azshanbeInput">
            </div>
        </div> --}}
        <!--end::blood_type-->

        <!--begin::illness_history-->
        <div class="mainQuestionBox organizer">
            <div class="questionInner d-flex">
                @lang('validation.attributes.illness_history')
            </div>
            <div class="answerContainer box-input">
                <textarea  name="illness_history"  class="fullWidth input azshanbeInput">{{ $profile->illness_history }}</textarea>
            </div>
        </div>


        {{-- <div class="d-flex flex-wrap inputContainer">
            <label class="organizer">@lang('validation.attributes.illness_history')</label>
            <div class="organizer box-input">
                <textarea  name="illness_history"  class="input azshanbeInput">{{ $profile->illness_history }}</textarea>
            </div>
        </div> --}}
        <!--end::illness_history-->

        <!--begin::favorite_foods-->
        <div class="mainQuestionBox organizer">
            <div class="questionInner d-flex">
                @lang('validation.attributes.favorite_foods')
            </div>
            <div class="answerContainer box-input">

                <textarea  name="favorite_foods"  class="fullWidth input azshanbeInput">{{ $profile->favorite_foods }}</textarea>
            </div>
        </div>


        {{-- <div class="d-flex flex-wrap inputContainer">
            <label class="organizer">@lang('validation.attributes.favorite_foods')</label>
            <div class="organizer box-input">
                <textarea  name="favorite_foods"  class="input azshanbeInput">{{ $profile->favorite_foods }}</textarea>
            </div>
        </div> --}}
        <!--end::favorite_foods-->

        <!--begin::disgusting_foods-->
        <div class="mainQuestionBox organizer">
            <div class="questionInner d-flex">
                @lang('validation.attributes.disgusting_foods')
            </div>
            <div class="answerContainer box-input">
                <textarea  name="disgusting_foods"  class="fullWidth input azshanbeInput">{{ $profile->disgusting_foods }}</textarea>
            </div>
        </div>


        {{-- <div class="d-flex flex-wrap inputContainer">
            <label class="organizer">@lang('validation.attributes.disgusting_foods')</label>
            <div class="organizer box-input">
                <textarea  name="disgusting_foods"  class="input azshanbeInput">{{ $profile->disgusting_foods }}</textarea>
            </div>
        </div> --}}
        <!--end::disgusting_foods-->

        <!--begin::prohibited_foods-->
        <div class="mainQuestionBox organizer">
            <div class="questionInner d-flex">
                @lang('validation.attributes.prohibited_foods')
            </div>
            <div class="answerContainer box-input">
                <textarea  name="prohibited_foods"  class="fullWidth input azshanbeInput">{{ $profile->prohibited_foods }}</textarea>
            </div>
        </div>

        {{-- <div class="d-flex flex-wrap inputContainer">
            <label class="organizer">@lang('validation.attributes.prohibited_foods')</label>
            <div class="organizer box-input">
                <textarea  name="prohibited_foods"  class="input azshanbeInput">{{ $profile->prohibited_foods }}</textarea>
            </div>
        </div> --}}
        <!--end::prohibited_foods-->

        <!--begin::province-->
        <div class="mainQuestionBox organizer">
            <div class="questionInner d-flex">
                @lang('validation.attributes.province')
            </div>
            <div class="answerContainer box-input custom-select custom-select-province">
                <select name="province_id" class="input azshanbeInput"  id="province_id">
                    @foreach($provinces as $province)
                        <option @if( $province->id == $profile->province_id ) selected @endif value="{{ $province->id }}">{{ $province->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        {{-- <div class="d-flex flex-wrap inputContainer province-box province">
            <label class="organizer">@lang('validation.attributes.province')</label>
            <div class="box-input custom-select custom-select-province">
                <select name="province_id"  id="province_id">
                    @foreach($provinces as $province)
                        <option @if( $province->id == $profile->province_id ) selected @endif value="{{ $province->id }}">{{ $province->name }}</option>
                    @endforeach
                </select>
            </div>
        </div> --}}
        <!--end::province-->

        <!--begin::city-->
        <div class="mainQuestionBox organizer mb-5">
            <div class="questionInner d-flex">
                @lang('validation.attributes.city')
            </div>
            <div class="answerContainer box-input custom-select custom-select-province">
                <input name="city" type="text" value="{{ $profile->city }}" class="fullWidth input azshanbeInput">
            </div>
        </div>


        {{-- <div class="d-flex flex-wrap inputContainer">
            <label class="organizer">@lang('validation.attributes.city')</label>
            <div class="organizer box-input">
                <input name="city" type="text" value="{{ $profile->city }}" class="input azshanbeInput">
            </div>
        </div> --}}
        <!--end::city-->

        @if(!empty($questions))
            @include('dashboard.profile.questions.questions' , ['questions' => $questions])
        @endif

        <button type="submit" class="submit-button greenBackColor whiteColor organizer register cursor-pointer mt-5">
            <span class="rightFloat font-size-14 boldFont">@lang('general.submit')</span>
            <span class="icon icon-forward font-size-18 leftFloat"></span>
        </button>

    </form>
</div>
