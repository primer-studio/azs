<!--begin::create new profile-->
@UserAjaxForm(['form_id' => "create-new-profile", 'is_update' => false , 'confirm' => __('general.create_new_profile_confirmation') ])@endUserAjaxForm
<form method="post" id="create-new-profile" action="{{ route('dashboard.my-profiles.store') }}" class="mb-3">
    @csrf
    <button class="submit-button paymentButton whiteColor orangeBack cursor-pointer mr-3" type="button">
        ایجاد پروفایل جدید
    </button>
</form>
<!--end::create new profile-->

<div class="d-flex flex-wrap table-my-profile">
    <div class="d-flex align-items-center w-100 d-head">
        <div class="d-flex align-items-center justify-content-center base8">
            #
        </div>
        <div class="d-flex align-items-center justify-content-center base60">
            مشخصات
        </div>
        <div class="d-flex align-items-center justify-content-center base14">
            وضعیت
        </div>
        <div class="d-flex align-items-center justify-content-center base18">
            جزییات
        </div>
    </div>

    @foreach($profiles as $profile)
        @UserAjaxForm(['form_id' => "set-current-profile-{$profile->id}", 'is_update' => false ])@endUserAjaxForm
        <div class="d-flex align-items-center flex-wrap w-100 d-body">
            <div class="d-flex align-items-center justify-content-center h-100 base8">
                {{ $loop->iteration }}
            </div>
            <div class="d-flex align-items-center justify-content-center h-100 base60">
                {{ $profile->name }}
            </div>
            <div class="d-flex align-items-center justify-content-center h-100 base14">
                @if($profile->id == $current_profile->id)
                    <span class="greenColor">فعال</span>
                @else
                    <form method="post" id="set-current-profile-{{ $profile->id }}" action="{{ route('dashboard.my-profiles.set-current-profile') }}">
                        @csrf
                        <input name="profile" type="hidden" value="{{ encrypt($profile->id) }}">
                        <button class="submit-button cursor-pointer" type="button">
                            انتخاب
                        </button>
                    </form>
                @endif
            </div>
            <div class="d-flex align-items-center justify-content-center h-100 base18">
                <a href="{{ route('dashboard.my-profiles.edit' , ['profile' => $profile->id]) }}">مشاهده</a>
            </div>
        </div>
    @endforeach
</div>
