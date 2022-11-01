<li>
    <p>
        <span class="iteration">{{ $loop->iteration }}</span>
        <span class="seprator"></span> {{ $item['title'] }} ({{ $sports->where('id', $item['id'])->first()->unit }})
        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 24 24">
            <path
                d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"/>
        </svg>
        <span class="seprator"></span>
    {{ toPersianDigit($item['count']) }}

        @if(!is_null($sports->where('id', $item['id'])->first()->description) && strlen($sports->where('id', $item['id'])->first()->description))
            <p>
                <svg style="vertical-align: middle; display: inline-block" version="1.0" xmlns="http://www.w3.org/2000/svg"
                     width="15.000000pt" height="15.000000pt" viewBox="0 0 256.000000 256.000000"
                     preserveAspectRatio="xMidYMid meet">

                    <g transform="translate(0.000000,256.000000) scale(0.100000,-0.100000)"
                       fill="#D1345B" stroke="none">
                        <path d="M1204 2231 c-97 -25 -187 -100 -226 -189 -39 -88 -36 -135 42 -547
                        39 -209 75 -394 81 -411 19 -61 110 -124 179 -124 69 0 160 63 179 124 6 17
                        42 202 81 411 78 412 81 459 42 547 -29 65 -95 133 -159 163 -59 28 -163 41
                        -219 26z"/>
                        <path d="M1205 787 c-26 -6 -57 -28 -91 -62 -43 -43 -54 -61 -64 -108 -40
                        -178 113 -329 291 -287 42 10 64 24 105 65 43 43 54 61 64 108 21 91 2 157
                        -64 222 -70 70 -142 89 -241 62z"/>
                    </g>
                </svg>
                <span class="subtitle">{{ strip_tags($sports->where('id', $item['id'])->first()->description) }}</span>
            </p>
        @endif
</li>


