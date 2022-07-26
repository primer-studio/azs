<div class="d-flex flex-wrap w-100 table-diets whiteBackColor border-radius-10 px-4 pt-4 pb-3">
    <header class="w-100 mb-3 d-flex align-items-center">
        <span class="redColor w-25">انتخاب رژیم</span>
        <div class="line w-75 h-2 mr-3 bg-custom-grey"></div>
    </header>

    <span class="span-alert-green w-100 d-flex align-items-center mb-3 px-3 font-size-14">
        تمامی دوره ها توسط متخصصین ارشد تغذیه تنظیم میگردد و شامل پشتیبانی می باشد
    </span>

    @forelse($diets as $diet)
        {{-- show if at least there is 1 active period which contains a least 1 active step --}}
        @if(!empty($diet->active_periods_steps_questions->keys()->first())
            &&
            \Facades\App\Libraries\DietHelper::canGetDiet(auth()->user(), $diet)
            )
            <div class="d-flex align-items-center justify-content-center align-content-center flex-wrap pos-relative">
                <a class="pos-absolute" href="{{ route('dashboard.diets.show-step', ['slug' => $diet->slug, 'period' => $diet->active_periods_steps_questions->keys()->first(), 'step_number' => 1]) }}"></a>
                @if($diet->title == 'رژیم کاهش وزن')
                    <img src="img/slim.svg" alt="" title="">
                @else
                    <img src="img/calories.svg" alt="" title="">
                @endif
                <span class="w-100 ">{{ $diet->title }}</span>
                <div class="w-100 diet-description">{!! $diet->description !!}</div>
                @if($diet->show_price_in_diets_list)
                    <span class="w-100 diet-price">
                        {{-- for now we show the price of priod 1 --}}
                        {{ money($diet->periods[1]->price) }}
                        @lang('general.toman')
                    </span>
                @endif
                <div class="diet-selected mt-3">انتخاب</div>
            </div>
        @endif
    @empty
        <div class="d-flex align-items-center justify-content-center">
            there is no available diet
        </div>
    @endforelse
</div>


<div class="d-flex align-items-center flex-wrap w-100 justify-content-between div-alert-diets-support whiteBackColor w-100 border-radius-10 question-box-pay px-4 pt-4 pb-3 mt-4">
    <div class="d-flex flex-wrap div-text">
        <p class="d-flex font-size-14">
            نیاز به راهنمایی دارید؟
        </p>
        <span class="w-100 d-flex font-size-14">
            از طریق تماس تلفنی و پشتیبانی آنلاین سوال خود را از ما بپرسید.
        </span>
    </div>
    <div class="d-flex flex-wrap aling-items-center justify-content-center div-call-support">
        <span class="mb-1 tiny-span"> 9 صبح تا 6 بعد از ظهر </span>
        <a href="tel:02123051172" class="d-flex align-items-center justify-content-center px-2 mb-2 a-support-btn a-support-btn-red" title="تماس با پشتیبان"> 02123051172 </a>
        <a href="https://bit.ly/2XsNjDj" class="d-flex align-items-center justify-content-center px-2 a-support-btn a-support-btn-green" title="ارتباط با پشتیبان"> ارتباط با پشتیبان </a>
    </div>
</div>
