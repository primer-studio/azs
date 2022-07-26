@isset($diet->foods[$day_number])
    @isset($diet->foods[$day_number][$meal])
        <ul class="d-flex flex-wrap w-100 mt-5">
            <div class="w-100 d-flex mb-4">
                <strong class="d-flex align-items-center">
                    {!! $icon !!}
                    {{ $meal_title }}
                </strong>
            </div>
            @php
                $shown_popups = [];
            @endphp
            @foreach($diet->foods[$day_number][$meal] as $food)
                @include('dashboard.orders.food')
            @endforeach
        </ul>
    @endisset
@endisset
