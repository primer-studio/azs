{{--@foreach($pure_plan[$day]['breakfast'] as $item_id => $item)--}}


<div class="diet-day-part-body-item" data-diet-item-cal="{{ $item['cal_unit'] }}"
     data-diet-item-id="{{ $item['id'] }}">
    <div class="item-num"><p>{{ $item_id }}.</p></div>
    <div class="item-title">
        <h3>
            {{ $item['title'] }}
        </h3>
        <p></p>
    </div>
    <!-- <div class="item-count" data-listener=""> -->
    <div class="item-count">
        <i>
            <svg width="14" height="2" viewBox="0 0 14 2" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1H13" stroke="#ABABAB" stroke-width="1.22474"
                      stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </i>
        <p>{{ $item['count'] }}</p><i>
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M1 7H13" stroke="#ABABAB" stroke-width="1.5"
                      stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M7 13V1" stroke="#ABABAB" stroke-width="1.5"
                      stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </i></div>
    <div class="item-cal"><p>{{ $item['cal_unit'] }}</p></div>
    <div class="item-delete">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.75781 7.75781L16.2431 16.2431" stroke="#292D32" stroke-width="1.5" stroke-linecap="round"
                  stroke-linejoin="round"></path>
            <path d="M7.75691 16.2431L16.2422 7.75781" stroke="#292D32" stroke-width="1.5" stroke-linecap="round"
                  stroke-linejoin="round"></path>
        </svg>
    </div>
</div>
