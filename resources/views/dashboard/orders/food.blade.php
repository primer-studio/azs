<li class="d-flex align-items-center justify-content-between w-100 px-2">
    <div class="d-flex align-items-center cursor-pointer open-modal" data-target=".food-popup-{{ $food->food_id }}">
        <figure class="d-flex align-items-center justify-content-center"
            style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
            <img src="./img/fast-food.svg" title="" alt="">
        </figure>
        <div class="d-felx flex-wrap align-items-center">
            <span class="w-100 d-flex">
                {{ $food->before_food_comment }} {{ number_format($food->amount_in_unit) }} {{ $food->food->unit }} {{ $food->food->title }}
            </span>
            @if(!empty($food->after_food_comment))
                <em class="w-100 d-flex">
                    {{ $food->after_food_comment }}
                </em>
            @endif
        </div>
    </div>

    @php
        if (empty($shown_popups[$food->food_id])) {
            $set_popup = true;
        }
    @endphp

    @if(!empty($set_popup))
        <div class="popUpBox desktopStaticMode food-popup food-popup-{{ $food->food_id }} ">
            <div class="popUpCloseBack hidden cursor-pointer close-modal" data-target=".food-popup"></div>
            <div class="popUpWhiteBox organizer relative">
                <div class="expand mobileVersion">
                    <span class="expandRectangle"></span>
                </div>
                <div class="popUpBoxHeader font-size-18 boldFont organizer">
                    <div class="popUpBoxTitle rightFloat">
                        {{ $food->food->title }}
                    </div>
                    <div class="popUpBoxCross leftFloat">
                        <span class="icon icon-close cursor-pointer close-modal" data-target=".food-popup"></span>
                    </div>
                </div>
                <div class="popUpBoxContent font-size-14 lightFont organizer">
                    <figure class="mt-3">
                        <img src="./img/fast-food.svg" title="" alt="">
                    </figure>
                    @if(!empty($food->food->description))
                        <div class="food-popup-content">
                            <p class="title">- مواد و طرز تهیه -</p>
                            {!! $food->food->description !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</li>
