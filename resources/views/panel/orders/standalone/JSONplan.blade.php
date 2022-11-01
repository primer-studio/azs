<div id="scoped" style="direction: ltr">
    <style scoped>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }

        a, p, h1, h2, h3, h4, h5, h6 {
            /*font-family: "iranyekan";*/
            font-weight: normal;

            direction: rtl;
        }


        a {
            text-decoration: none;
        }


        .main {
            background-color: #F2F3F8;
            width: 100%;
            display: block;
        }

        .diet-pagination-cont {
            width: 100%;
        }

        .diet-pagination {
            width: 100%;
            padding-top: 25px;

            display: flex;
            flex-flow: row wrap;
            justify-content: center;
            align-items: center;
        }

        .pagination {

            display: flex;
            flex-flow: row-reverse wrap;
            justify-content: center;
            align-items: center;
        }

        .pagination div.pagination-icon {
            width: 45px;
            height: 45px;
            background-color: #fefefe;
            margin: 0px 10px;

            display: flex;
            flex-flow: column wrap;
            justify-content: center;
            align-items: center;

            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .pagination div.pagination-icon:hover {
            box-shadow: 0px 2px 10px 0px rgba(0, 0, 0, 0.15);
        }

        .pagination div.pagination-icon p {
            font-size: 18px;
            font-weight: normal;
            color: #ADADAD;
        }

        .pagination div.active {
            box-shadow: 0px 2px 10px 0px rgba(0, 0, 0, 0.15);
        }

        .pagination div.active p {
            color: #000000;
        }

        .nxt-btn, .prv-btn {
            transition: all 0.3s;
            cursor: pointer;
        }

        .nxt-btn svg, .prv-btn svg {
            width: 100%;
        }

        .nxt-btn svg path, .prv-btn svg path {
            transition: all 0.3s;
        }

        .nxt-btn:hover svg path, .prv-btn:hover svg path {
            stroke: #000000;
        }


        .diet-cont {
            width: 100%;
            display: block;
        }

        .diet {
            width: 100%;
            display: block;
            padding: 50px;
            padding-top: 25px;

            display: flex;
            flex-flow: row nowrap;
            justify-content: center;
        }

        .diet-toolkit-cont {
            /* max-width: 40%; */
            /* flex: 0 0 40%; */
            flex: 0 0 25%;
            position: relative;
            padding-right: 25px;
        }

        .diet-toolkit {
            width: 100%;
            position: sticky;
            top: 25px;

            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: auto auto auto auto;
            gap: 20px;
            /* grid-auto-flow: row; */
        }

        .diet-toolkit-box-cont {
            min-width: 275px;
            /* width: 293px; */
            /* grid-area: ; */
            background-color: #FFFFFF;

            box-shadow: 0px 4px 15px 0px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
        }

        .diet-toolkit-box {
            width: 100%;
        }

        .diet-toolkit-box-header {
            width: 100%;
            background-color: #F0F0F0;

            display: flex;
            flex-flow: row wrap;
            justify-content: center;
            align-items: center;

            border-radius: 15px;
        }

        .diet-toolkit-box-header h2 {
            padding: 15px 0px;


            text-align: center;
            font-size: 24px;
            font-weight: 800;
            color: #676767;
        }


        .diet-toolkit-box-body {
            padding: 10px;
        }


        /* Tookit box search */
        .diet-toolkit-box-search-cont {
            width: 100%;
        }

        .diet-toolkit-box-search-cont .diet-toolkit-box-search {
            width: 100%;
        }

        .diet-toolkit-box-search-cont .diet-toolkit-box-search input {
            width: 100%;
            padding: 10px 15px;
            margin-bottom: 5px;
            border: unset;
            outline: unset;

            direction: rtl;
            text-align: right;
            font-size: 14px;
            color: rgb(102, 102, 102);

            border-radius: 5px;
            /* box-shadow: 0px 1px 10px 0px rgba(0, 0, 0, 0.1); */
            border: 1px solid #66666625;
            transition: all 0.3s;
        }

        .diet-toolkit-box-search-cont .diet-toolkit-box-search input:focus {
            border: 1px solid #FFFFFF;
            box-shadow: 0px 1px 10px 0px rgba(0, 0, 0, 0.1);
        }


        .diet-toolkit-box-body-items {
            width: 100%;
            height: 190px;

            display: flex;
            flex-flow: column nowrap;

            overflow-x: hidden;
            overflow-y: auto;

            scrollbar-width: thin;
        }

        .diet-toolkit-box-body-items::-webkit-scrollbar {
            width: 10px;
            margin-left: 5px;
        }

        .diet-toolkit-box-body-items::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            -webkit-border-radius: 15px;
            border-radius: 15px;
        }

        .diet-toolkit-box-body-items::-webkit-scrollbar-thumb {
            background-color: #cdcdcd;
            /* box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3); */

            -webkit-border-radius: 15px;
            border-radius: 15px;
        }

        .diet-toolkit-box-body-items::-webkit-scrollbar-thumb:hover {
            background-color: #919191;
        }


        .diet-toolkit-box-body-item {
            width: 100%;
            padding: 10px 10px;
            /* padding-right: 5px; */

            display: flex;
            flex-flow: row nowrap;
            justify-content: space-between;
            align-items: center;

            border-radius: 15px;

            transition: all 0.3s;
        }

        .diet-toolkit-box-body-item:hover {
            background-color: #eeeeee;
        }

        .diet-toolkit-box-body-item p.toolkit-item-count {
            flex: 0 0 25px;

            text-align: center;
            font-size: 13px;
            font-weight: normal;
            color: #666666;
        }

        .diet-toolkit-box-body-item p.toolkit-item-cal {
            /* flex: 0 0 25px; */

            direction: ltr;
            text-align: center;
            font-size: 12px;
            font-weight: normal;
            color: #666666;
        }

        .diet-toolkit-box-body-item p.toolkit-item-cal::after {
            content: "Cal";
        }

        .diet-toolkit-box-body-item p.toolkit-item-name {
            flex: 1 0 auto;
            /* max-width: 225px; */
            padding-right: 15px;

            text-align: right;
            font-size: 13px;
            font-weight: normal;
            color: #666666;
        }

        .diet-toolkit-box-body-item span.toolkit-item-icon {
            flex: 0 0 10px;
        }


        .diet-toolkit-control-cont {
            /* width: 293px; */
            background-color: #FFFFFF;

            align-self: center;

            box-shadow: 0px 4px 15px 0px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
        }

        .diet-toolkit-control {
            width: 100%;
            padding: 10px;

            display: flex;
            flex-flow: row wrap;
            justify-content: center;
            align-items: center;
        }

        .diet-toolkit-btn-1 {
            flex: 0 0 46%;

            margin: 0px 5px;
            margin-bottom: 10px;
            padding: 10px 35px;
            background-color: #F0F0F0;
            border-radius: 15px;

            font-size: 16px;
            font-weight: normal;
            color: #676767;

            display: flex;
            flex-flow: row wrap;
            justify-content: center;
            align-items: center;

            cursor: pointer;
            transition: all 0.3s;
        }

        .diet-toolkit-btn-2 {
            flex: 1 0 100%;

            padding: 20px 10px;
            background-color: #96F188;
            border-radius: 15px;

            font-size: 16px;
            font-weight: normal;
            color: #fefefe;

            display: flex;
            flex-flow: row wrap;
            justify-content: center;
            align-items: center;

            cursor: pointer;
            transition: all 0.3s;
        }

        .diet-toolkit-btn-1:hover {
            box-shadow: 0px 4px 15px 0px rgba(0, 0, 0, 0.1);
        }

        .diet-toolkit-btn-2:hover {
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }


        .diet-parts-cont {
            /* max-width: 60%; */
            /* flex: 0 0 60%; */
            flex: 0 0 75%;
            display: none;

            animation: fade-in 0.3s;
        }

        .diet > div.active {
            display: block;
        }

        .diet-parts {
            display: flex;
            flex-flow: column wrap;
            align-items: flex-start;
        }

        .diet-day-cont {
            width: 100%;
            background-color: #FFFFFF;

            margin-bottom: 15px;

            box-shadow: 0px 4px 15px 0px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
        }

        .diet-day {
            width: 100%;
            padding: 15px;

            display: flex;
            flex-flow: row wrap;
            justify-content: space-between;
            align-items: center;
        }

        .diet-day h2 {
            font-size: 16px;
            font-weight: 500;
            color: #ADADAD;
        }

        .diet-day p {
            font-size: 14px;
            font-weight: 400;
            color: #696969;
        }


        .diet-days-part-cont {
            /* max-width: 66%; */
            width: 100%;
            background-color: #FFFFFF;
            margin-bottom: 15px;
            border: 1px solid #66666625;

            /* box-shadow: 0px 4px 15px 0px rgba(0, 0, 0, 0.1); */
            border-radius: 15px;

            transition: all 0.3s;
        }

        [data-selecting-day-part] {
            border: 1px solid #FFFFFF;;
            box-shadow: 0px 4px 15px 0px rgba(0, 0, 0, 0.1);
        }

        .diet-day-part {
            width: 100%;

        }

        .diet-day-part-head {
            width: 100%;
            padding: 15px;

            display: flex;
            flex-flow: row-reverse nowrap;
            justify-content: space-between;
            align-items: center;
        }

        .diet-day-part-select {
            position: absolute;

            display: flex;
            flex-flow: row wrap;
            justify-content: center;
            align-items: center;

            cursor: pointer;
        }

        .diet-day-part-select div.select-tick {
            display: none;
            position: absolute;

            animation: fade-in 0.3s
        }

        .diet-day-part-head div.active div.select-tick {
            display: block;
        }

        .diet-day-part-select div.select-box {
            /* position: absolute; */
        }


        .diet-day-part-head h2 {
            margin-right: 35px;

            font-size: 18px;
            font-weight: 500;
            color: #ADADAD;
        }

        .diet-day-part-head span {
            direction: rtl;
            font-family: "iranyekan";
            font-size: 14px;
            font-weight: 300;
            font-style: normal;
            color: #ADADAD;
        }

        .diet-day-part-head span i {
            display: inline-block;

            font-family: "iranyekan";
            /* font-weight: 600; */
            font-style: normal;
            direction: ltr;
        }

        .diet-day-part-head span i::after {
            content: " Cal";
        }

        .diet-day-part-body {
            width: 100%;
            height: 170px;
            padding: 15px;

            overflow-x: hidden;
            overflow-y: auto;
            scrollbar-width: thin;
        }

        .diet-day-part-body::-webkit-scrollbar {
            width: 10px;
            margin-left: 5px;
        }

        .diet-day-part-body::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            -webkit-border-radius: 15px;
            border-radius: 15px;
        }

        .diet-day-part-body::-webkit-scrollbar-thumb {
            background-color: #cdcdcd;
            /* box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3); */

            -webkit-border-radius: 15px;
            border-radius: 15px;
        }

        .diet-day-part-body::-webkit-scrollbar-thumb:hover {
            background-color: #919191;
        }


        .diet-day-part-body-item {
            width: 100%;
            margin-bottom: 10px;

            /* Just for Animation */
            max-height: 150px;

            display: flex;
            flex-flow: row-reverse nowrap;
            justify-content: space-between;
            align-items: center;

            transition: all 0.3s;
            animation: fade-in 0.3s;
        }

        .diet-day-part-body-item:last-child {
            /* margin-bottom: 0px; */
        }


        .diet-day-part-body-item .item-num {
            padding: 0px 15px;

            display: flex;
            flex-flow: row wrap;
            justify-content: center;
            align-items: center;
        }

        .diet-day-part-body-item .item-num p {
            font-size: 14px;
            font-weight: 500;
            color: #ADADAD;
        }


        .diet-day-part-body-item .item-title {
            padding: 0px 15px;
            flex-grow: 1;

            display: flex;
            flex-flow: column wrap;
            justify-content: center;
            align-items: flex-end;
        }

        .diet-day-part-body-item .item-title h3 {
            font-size: 12px;
            font-weight: 400;
            color: #666666;
        }

        .diet-day-part-body-item .item-title p {
            font-size: 9px;
            font-weight: 400;
            color: #BDBDBD;
        }


        .diet-day-part-body-item .item-count {
            padding: 0px 15px;

            display: flex;
            flex-flow: row nowrap;
            justify-content: center;
            align-items: center;
        }

        .diet-day-part-body-item .item-count i {
            width: 12px;
            height: 12px;

            display: flex;
            flex-flow: row nowrap;
            justify-content: center;
            align-items: center;

            cursor: pointer;
        }

        .diet-day-part-body-item .item-count i svg {
            width: 100%;
        }


        .diet-day-part-body-item .item-count p {
            margin: 0px 10px;

            font-size: 12px;
            font-weight: 400;
            color: #666666;
        }

        .diet-day-part-body-item .item-cal {
            padding: 0px 15px;
            display: flex;
            flex-flow: column wrap;
            justify-content: center;
            align-items: flex-end;
        }

        .diet-day-part-body-item .item-cal p {
            direction: ltr;
            font-size: 12px;
            font-weight: 400;
            color: #666666;
        }

        .diet-day-part-body-item .item-cal p::after {
            content: " Cal";
        }


        .diet-day-part-body-item .item-delete {
            padding: 0px 5px;
            display: flex;
            flex-flow: column wrap;
            justify-content: center;
            align-items: flex-end;

            cursor: pointer;
            transition: all 0.3s;
        }

        .diet-day-part-body-item .item-delete:hover {
            transform: rotate(90deg);
        }


        /* LightBox */
        .lightbox-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            width: 100%;
            height: 100%;
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;

            animation: fade-in 0.3s;
        }

        .lightbox-active {
            display: block;
        }

        .lightbox-message-cont {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;

            display: flex;
            flex-flow: row nowrap;
            justify-content: center;
            align-items: center;

            display: none;

            animation: pop-in 0.5s;
        }

        .lightbox-message-active {
            display: flex;
        }

        .lightbox-message {
            background-color: #FFFFFF;
            width: 450px;
            padding: 30px 15px;

            display: flex;
            flex-flow: column nowrap;
            justify-content: center;
            align-items: center;

            border-radius: 15px;
            box-shadow: 0px 4px 15px 0px rgba(0, 0, 0, 0.15);
        }

        .lightbox-message .lightbox-message-icon {
            width: 100%;
            margin-bottom: 10px;

            display: flex;
            flex-flow: row wrap;
            justify-content: center;
            align-items: center;
        }

        .lightbox-message .lightbox-message-icon svg {
            width: 55px;
        }

        .lightbox-message .lightbox-message-title {
            width: 100%;
            margin-bottom: 10px;

            text-align: center;

            /* display: flex;
            flex-flow: row wrap;
            justify-content: center;
            align-items: center; */
        }

        .lightbox-message .lightbox-message-title h2 {
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            color: #616161;
        }


        .lightbox-message .lightbox-message-desc {
            width: 100%;
            margin-bottom: 20px;

            text-align: center;
        }

        .lightbox-message .lightbox-message-desc p {
            text-align: center;
            font-size: 12px;
            font-weight: 400;
            color: #8d8d8d;
        }

        .lightbox-message .lightbox-message-btn {
            background-color: #96F188;
            width: 275px;
            padding: 10px 0px;

            display: flex;
            flex-flow: row wrap;
            justify-content: center;
            align-items: center;

            border-radius: 15px;
            box-shadow: 0px 2px 10px 0px rgba(0, 0, 0, 0.10);
            cursor: pointer;
            transition: all 0.3s;
        }

        .lightbox-message .lightbox-message-btn:hover {
            box-shadow: unset;
        }

        .lightbox-message .lightbox-message-btn p {
            text-align: center;
            font-size: 16px;
            font-weight: 400;
            color: #fefefe;
        }


        /*************** HERE WE GO FOR Responsibility
        /* X-Large devices (large desktops, less than 1400px) */
        @media screen and (max-width: 1399.98px) {

        }

        /* XX-Large devices (larger desktops)
         No media query since the xxl breakpoint has no upper bound on its width */
        /* X-Small devices (portrait phones, less than 576px)*/
        /* Large devices (desktops, less than 1200px) */

        @media screen and (max-width: 1199.98px) {
            .diet-toolkit {
                grid-template-columns: 1fr;
            }
        }


        /* Medium devices (tablets, less than 992px) */
        @media screen and (max-width: 991.98px) {
        }

        /* Small devices (landscape phones, less than 768px) */
        @media screen and (max-width: 767.98px) {
        }

        /* Small devices (landscape phones, less than 768px) */
        @media screen and (max-width: 575.98px) {
        }


        /* animations */
        @keyframes fade-in {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes pop-in {
            0% {
                opacity: 0;
                transform: scale(0.5);
            }
            80% {
                transform: scale(1.1);
            }
            100% {
                opacity: 1;
                transform: scale(1.0);
            }
        }
    </style>
    <div id="main" class="main">
        <div class="diet-pagination-cont">
            <div class="diet-pagination">
                <div class="nxt-btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M14.9998 19.9201L8.47984 13.4001C7.70984 12.6301 7.70984 11.3701 8.47984 10.6001L14.9998 4.08008"
                            stroke="#ADADAD" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="pagination">
                    @foreach($diet->days as $day => $timestamp)
                        <div class="pagination-icon @if($loop->iteration == 1) active @endif"
                             data-day-number="{{ $day }}">
                            <p>
                                {{ toPersianDigit($day) }}
                            </p>
                        </div>
                    @endforeach

                </div>
                <div class="prv-btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.91016 19.9201L15.4302 13.4001C16.2002 12.6301 16.2002 11.3701 15.4302 10.6001L8.91016 4.08008"
                            stroke="#ADADAD" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="diet-cont">
            <div class="diet">

                <div class="diet-toolkit-cont">
                    <div class="diet-toolkit">

                        <div class="diet-toolkit-box-cont">
                            <div class="diet-toolkit-box">
                                <div class="diet-toolkit-box-header">
                                    <h2 style="
                                            background: #ffffff;
                                            width: auto;
                                            height: 3px;
                                            display: table;
                                            padding: 2px 10px;
                                            vertical-align: middle;
                                            border-radius: 6px;
                                            float: left !important;
                                            margin-right: 60%;
                                            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
                                        "
                                        onclick="">+</h2>
                                    <h2>
                                        غذا
                                    </h2>
                                </div>
                                <div class="diet-toolkit-box-body">
                                    <div class="diet-toolkit-box-search-cont">
                                        <div class="diet-toolkit-box-search">
                                            <input type="text" name="search" id="diet_items_search"
                                                   class="diet-toolkit-box-input" placeholder="جستجو"/>
                                        </div>
                                    </div>
                                    <div class="diet-toolkit-box-body-items">
                                        @foreach($foods as $index => $food)
                                            <div class="diet-toolkit-box-body-item"
                                                 data-diet-item-id="{{ $food->id }}"
                                                 data-diet-item-des="{{ strip_tags($food->description) }}"
                                                 data-diet-item-cal="{{ $food->calories_per_unit }}"
                                                 data-diet-item-cal="food">
                                                <p class="toolkit-item-cal">
                                                    {{ toPersianDigit($food->calories_per_unit) }}
                                                </p>
                                                <p class="toolkit-item-name" title="{{ toPersianDigit($food->unit) }}"
                                                   data-diet-item-title="{{ StripHtmlEntities($food->title) }}">
                                                    {{ StripHtmlEntities($food->title) }}
                                                </p>
                                                <span class="toolkit-item-icon" data-btn-role="add-item">
                                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5H9" stroke="#666666" stroke-linecap="round"
                                                              stroke-linejoin="round"/>
                                                        <path d="M5 9V1" stroke="#666666" stroke-linecap="round"
                                                              stroke-linejoin="round"/>
                                                    </svg>
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="diet-toolkit-box-cont">
                            <div class="diet-toolkit-box">
                                <div class="diet-toolkit-box-header">
                                    <h2>
                                        ورزش
                                    </h2>
                                </div>
                                <div class="diet-toolkit-box-body">
                                    <div class="diet-toolkit-box-search-cont">
                                        <div class="diet-toolkit-box-search">
                                            <input type="text" name="search" id="diet_items_search"
                                                   class="diet-toolkit-box-input" placeholder="جستجو"/>
                                        </div>
                                    </div>
                                    <div class="diet-toolkit-box-body-items">
                                        @foreach($sports as $index => $sport)
                                            <div class="diet-toolkit-box-body-item"
                                                 data-diet-item-id="{{ $sport->id }}"
                                                 data-diet-item-des="{{ strip_tags($sport->description) }}"
                                                 data-diet-item-cal="{{ $sport->calories_per_unit }}"
                                                 data-diet-item-type="sport">
                                                <p class="toolkit-item-cal">
                                                    {{ toPersianDigit($sport->calories_per_unit) }}
                                                </p>
                                                <p class="toolkit-item-name" title="{{ toPersianDigit($sport->unit) }}"
                                                   data-diet-item-title="{{ StripHtmlEntities($sport->title) }}">
                                                    {{ StripHtmlEntities($sport->title) }}
                                                </p>
                                                <span class="toolkit-item-icon" data-btn-role="add-item">
                                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5H9" stroke="#666666" stroke-linecap="round"
                                                              stroke-linejoin="round"/>
                                                        <path d="M5 9V1" stroke="#666666" stroke-linecap="round"
                                                              stroke-linejoin="round"/>
                                                    </svg>
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="diet-toolkit-control-cont">
                            <div class="diet-toolkit-control">
                                <div class="diet-toolkit-btn-1 toolkit-nxt-btn">
                                    <p>
                                        روز بعد
                                    </p>
                                </div>
                                <div class="diet-toolkit-btn-1 toolkit-prv-btn">
                                    <p>
                                        روز قبل
                                    </p>
                                </div>
                                <div class="diet-toolkit-btn-2 save_diet_program" id="save_diet_program">
                                    <p>
                                        ذخیره برنامه رژیم
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @php
                $plan = \App\CustomDietDailyPlan::where('order_id', $order->id)->get();
                $pure_plan = (count($plan) == 1) ? json_decode($plan[0]->plan, true) : false;
            @endphp
            <!-- dev foreach $diet->days -->
                @foreach($diet->days as $day => $timestamp)
                    <div class="diet-parts-cont @if($loop->iteration == 1) active @endif" data-day="{{ $day }}">
                        <div class="diet-parts">

                            <div id="diet-day" class="diet-day-cont" data-diet-day="{{ $day }}">
                                <div class="diet-day">
                                    <p>
                                        روز {!! toPersianDigit($day) . "&nbsp;&nbsp; [" . jdate($timestamp) . "]" !!}
                                    </p>
                                    <h2>
                                        {{ App\InvoiceItem::findOrFail($order->invoice_item_id)->diet_registered_data->title }}
                                    </h2>
                                </div>
                            </div>

                            <div class="diet-days-part-cont" data-diet-day-part="breakfast">
                                <div class="diet-day-part">
                                    <div class="diet-day-part-head">

                                        <div class="diet-day-part-select">
                                            <div class="select-tick">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.91746 12.9071L1.34498 8.8881C1.27183 8.8058 1.36441 8.68462 1.46237 8.7349C2.32416 9.17719 4.12294 10.1229 4.5 10.5C4.77616 10.7761 5.22384 10.7761 5.5 10.5C5.91739 10.0826 11.2127 3.74202 12.9512 1.65816C13.0272 1.56697 13.1099 1.6255 13.0439 1.7242C11.3547 4.24893 5.7549 11.9612 5.06905 12.905C5.03152 12.9567 4.95987 12.9549 4.91746 12.9071Z"
                                                        fill="#96F188" stroke="#96F188" stroke-width="1.5"
                                                        stroke-linecap="round"/>
                                                </svg>
                                            </div>
                                            <div class="select-box">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_i_44_2)">
                                                        <rect width="20" height="20" rx="5" fill="white"/>
                                                    </g>
                                                    <defs>
                                                        <filter id="filter0_i_44_2" x="0" y="0" width="20" height="20"
                                                                filterUnits="userSpaceOnUse"
                                                                color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                            <feBlend mode="normal" in="SourceGraphic"
                                                                     in2="BackgroundImageFix" result="shape"/>
                                                            <feColorMatrix in="SourceAlpha" type="matrix"
                                                                           values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                                           result="hardAlpha"/>
                                                            <feMorphology radius="1" operator="dilate" in="SourceAlpha"
                                                                          result="effect1_innerShadow_44_2"/>
                                                            <feOffset/>
                                                            <feGaussianBlur stdDeviation="3"/>
                                                            <feComposite in2="hardAlpha" operator="arithmetic" k2="-1"
                                                                         k3="1"/>
                                                            <feColorMatrix type="matrix"
                                                                           values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
                                                            <feBlend mode="normal" in2="shape"
                                                                     result="effect1_innerShadow_44_2"/>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>

                                        <h2>
                                            صبحانه
                                        </h2>

                                        <span>
                                جمع مقدار کالری:
                                <i>
                                    25,000 K.Cal
                                </i>
                            </span>
                                    </div>
                                    <div class="diet-day-part-body">
                                    @if($pure_plan !== false)
                                        <!-- items -->
                                        @foreach($pure_plan[$day]['breakfast'] as $item_id => $item)
                                            @include('panel.orders.standalone.loop.box-item')
                                        @endforeach
                                        <!-- items -->
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="diet-days-part-cont" data-diet-day-part="midmeal-1">
                                <div class="diet-day-part">
                                    <div class="diet-day-part-head">

                                        <div class="diet-day-part-select">
                                            <div class="select-tick">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.91746 12.9071L1.34498 8.8881C1.27183 8.8058 1.36441 8.68462 1.46237 8.7349C2.32416 9.17719 4.12294 10.1229 4.5 10.5C4.77616 10.7761 5.22384 10.7761 5.5 10.5C5.91739 10.0826 11.2127 3.74202 12.9512 1.65816C13.0272 1.56697 13.1099 1.6255 13.0439 1.7242C11.3547 4.24893 5.7549 11.9612 5.06905 12.905C5.03152 12.9567 4.95987 12.9549 4.91746 12.9071Z"
                                                        fill="#96F188" stroke="#96F188" stroke-width="1.5"
                                                        stroke-linecap="round"/>
                                                </svg>
                                            </div>
                                            <div class="select-box">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_i_44_2)">
                                                        <rect width="20" height="20" rx="5" fill="white"/>
                                                    </g>
                                                    <defs>
                                                        <filter id="filter0_i_44_2" x="0" y="0" width="20" height="20"
                                                                filterUnits="userSpaceOnUse"
                                                                color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                            <feBlend mode="normal" in="SourceGraphic"
                                                                     in2="BackgroundImageFix" result="shape"/>
                                                            <feColorMatrix in="SourceAlpha" type="matrix"
                                                                           values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                                           result="hardAlpha"/>
                                                            <feMorphology radius="1" operator="dilate" in="SourceAlpha"
                                                                          result="effect1_innerShadow_44_2"/>
                                                            <feOffset/>
                                                            <feGaussianBlur stdDeviation="3"/>
                                                            <feComposite in2="hardAlpha" operator="arithmetic" k2="-1"
                                                                         k3="1"/>
                                                            <feColorMatrix type="matrix"
                                                                           values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
                                                            <feBlend mode="normal" in2="shape"
                                                                     result="effect1_innerShadow_44_2"/>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>

                                        <h2>
                                            میان وعده اول
                                        </h2>
                                        <span>
                                جمع مقدار کالری:
                                <i>
                                    25,000 K.Cal
                                </i>
                            </span>
                                    </div>
                                    <div class="diet-day-part-body">
                                    @if($pure_plan !== false)
                                        <!-- items -->
                                        @foreach($pure_plan[$day]['midmeal-1'] as $item_id => $item)
                                            @include('panel.orders.standalone.loop.box-item')
                                        @endforeach
                                        <!-- items -->
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="diet-days-part-cont" data-diet-day-part="lunch">
                                <div class="diet-day-part">
                                    <div class="diet-day-part-head">

                                        <div class="diet-day-part-select">
                                            <div class="select-tick">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.91746 12.9071L1.34498 8.8881C1.27183 8.8058 1.36441 8.68462 1.46237 8.7349C2.32416 9.17719 4.12294 10.1229 4.5 10.5C4.77616 10.7761 5.22384 10.7761 5.5 10.5C5.91739 10.0826 11.2127 3.74202 12.9512 1.65816C13.0272 1.56697 13.1099 1.6255 13.0439 1.7242C11.3547 4.24893 5.7549 11.9612 5.06905 12.905C5.03152 12.9567 4.95987 12.9549 4.91746 12.9071Z"
                                                        fill="#96F188" stroke="#96F188" stroke-width="1.5"
                                                        stroke-linecap="round"/>
                                                </svg>
                                            </div>
                                            <div class="select-box">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_i_44_2)">
                                                        <rect width="20" height="20" rx="5" fill="white"/>
                                                    </g>
                                                    <defs>
                                                        <filter id="filter0_i_44_2" x="0" y="0" width="20" height="20"
                                                                filterUnits="userSpaceOnUse"
                                                                color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                            <feBlend mode="normal" in="SourceGraphic"
                                                                     in2="BackgroundImageFix" result="shape"/>
                                                            <feColorMatrix in="SourceAlpha" type="matrix"
                                                                           values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                                           result="hardAlpha"/>
                                                            <feMorphology radius="1" operator="dilate" in="SourceAlpha"
                                                                          result="effect1_innerShadow_44_2"/>
                                                            <feOffset/>
                                                            <feGaussianBlur stdDeviation="3"/>
                                                            <feComposite in2="hardAlpha" operator="arithmetic" k2="-1"
                                                                         k3="1"/>
                                                            <feColorMatrix type="matrix"
                                                                           values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
                                                            <feBlend mode="normal" in2="shape"
                                                                     result="effect1_innerShadow_44_2"/>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>

                                        <h2>
                                            ناهار
                                        </h2>
                                        <span>
                                جمع مقدار کالری:
                                <i>
                                    25,000 K.Cal
                                </i>
                            </span>
                                    </div>
                                    <div class="diet-day-part-body">
                                    @if($pure_plan !== false)
                                        <!-- items -->
                                        @foreach($pure_plan[$day]['lunch'] as $item_id => $item)
                                            @include('panel.orders.standalone.loop.box-item')
                                        @endforeach
                                        <!-- items -->
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="diet-days-part-cont" data-diet-day-part="midmeal-2">
                                <div class="diet-day-part">
                                    <div class="diet-day-part-head">

                                        <div class="diet-day-part-select">
                                            <div class="select-tick">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.91746 12.9071L1.34498 8.8881C1.27183 8.8058 1.36441 8.68462 1.46237 8.7349C2.32416 9.17719 4.12294 10.1229 4.5 10.5C4.77616 10.7761 5.22384 10.7761 5.5 10.5C5.91739 10.0826 11.2127 3.74202 12.9512 1.65816C13.0272 1.56697 13.1099 1.6255 13.0439 1.7242C11.3547 4.24893 5.7549 11.9612 5.06905 12.905C5.03152 12.9567 4.95987 12.9549 4.91746 12.9071Z"
                                                        fill="#96F188" stroke="#96F188" stroke-width="1.5"
                                                        stroke-linecap="round"/>
                                                </svg>
                                            </div>
                                            <div class="select-box">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_i_44_2)">
                                                        <rect width="20" height="20" rx="5" fill="white"/>
                                                    </g>
                                                    <defs>
                                                        <filter id="filter0_i_44_2" x="0" y="0" width="20" height="20"
                                                                filterUnits="userSpaceOnUse"
                                                                color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                            <feBlend mode="normal" in="SourceGraphic"
                                                                     in2="BackgroundImageFix" result="shape"/>
                                                            <feColorMatrix in="SourceAlpha" type="matrix"
                                                                           values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                                           result="hardAlpha"/>
                                                            <feMorphology radius="1" operator="dilate" in="SourceAlpha"
                                                                          result="effect1_innerShadow_44_2"/>
                                                            <feOffset/>
                                                            <feGaussianBlur stdDeviation="3"/>
                                                            <feComposite in2="hardAlpha" operator="arithmetic" k2="-1"
                                                                         k3="1"/>
                                                            <feColorMatrix type="matrix"
                                                                           values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
                                                            <feBlend mode="normal" in2="shape"
                                                                     result="effect1_innerShadow_44_2"/>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>

                                        <h2>
                                            میان وعده دوم
                                        </h2>
                                        <span>
                                جمع مقدار کالری:
                                <i>
                                    25,000 K.Cal
                                </i>
                            </span>
                                    </div>
                                    <div class="diet-day-part-body">
                                    @if($pure_plan !== false)
                                        <!-- items -->
                                        @foreach($pure_plan[$day]['midmeal-2'] as $item_id => $item)
                                            @include('panel.orders.standalone.loop.box-item')
                                        @endforeach
                                        <!-- items -->
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="diet-days-part-cont" data-diet-day-part="dinner">
                                <div class="diet-day-part">
                                    <div class="diet-day-part-head">

                                        <div class="diet-day-part-select">
                                            <div class="select-tick">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.91746 12.9071L1.34498 8.8881C1.27183 8.8058 1.36441 8.68462 1.46237 8.7349C2.32416 9.17719 4.12294 10.1229 4.5 10.5C4.77616 10.7761 5.22384 10.7761 5.5 10.5C5.91739 10.0826 11.2127 3.74202 12.9512 1.65816C13.0272 1.56697 13.1099 1.6255 13.0439 1.7242C11.3547 4.24893 5.7549 11.9612 5.06905 12.905C5.03152 12.9567 4.95987 12.9549 4.91746 12.9071Z"
                                                        fill="#96F188" stroke="#96F188" stroke-width="1.5"
                                                        stroke-linecap="round"/>
                                                </svg>
                                            </div>
                                            <div class="select-box">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_i_44_2)">
                                                        <rect width="20" height="20" rx="5" fill="white"/>
                                                    </g>
                                                    <defs>
                                                        <filter id="filter0_i_44_2" x="0" y="0" width="20" height="20"
                                                                filterUnits="userSpaceOnUse"
                                                                color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                            <feBlend mode="normal" in="SourceGraphic"
                                                                     in2="BackgroundImageFix" result="shape"/>
                                                            <feColorMatrix in="SourceAlpha" type="matrix"
                                                                           values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                                           result="hardAlpha"/>
                                                            <feMorphology radius="1" operator="dilate" in="SourceAlpha"
                                                                          result="effect1_innerShadow_44_2"/>
                                                            <feOffset/>
                                                            <feGaussianBlur stdDeviation="3"/>
                                                            <feComposite in2="hardAlpha" operator="arithmetic" k2="-1"
                                                                         k3="1"/>
                                                            <feColorMatrix type="matrix"
                                                                           values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
                                                            <feBlend mode="normal" in2="shape"
                                                                     result="effect1_innerShadow_44_2"/>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>

                                        <h2>
                                            شام
                                        </h2>
                                        <span>
                                جمع مقدار کالری:
                                <i>
                                    25,000 K.Cal
                                </i>
                            </span>
                                    </div>
                                    <div class="diet-day-part-body">
                                    @if($pure_plan !== false)
                                        <!-- items -->
                                        @foreach($pure_plan[$day]['dinner'] as $item_id => $item)
                                            @include('panel.orders.standalone.loop.box-item')
                                        @endforeach
                                        <!-- items -->
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="diet-days-part-cont" data-diet-day-part="sport">
                                <div class="diet-day-part">
                                    <div class="diet-day-part-head">

                                        <div class="diet-day-part-select">
                                            <div class="select-tick">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.91746 12.9071L1.34498 8.8881C1.27183 8.8058 1.36441 8.68462 1.46237 8.7349C2.32416 9.17719 4.12294 10.1229 4.5 10.5C4.77616 10.7761 5.22384 10.7761 5.5 10.5C5.91739 10.0826 11.2127 3.74202 12.9512 1.65816C13.0272 1.56697 13.1099 1.6255 13.0439 1.7242C11.3547 4.24893 5.7549 11.9612 5.06905 12.905C5.03152 12.9567 4.95987 12.9549 4.91746 12.9071Z"
                                                        fill="#96F188" stroke="#96F188" stroke-width="1.5"
                                                        stroke-linecap="round"/>
                                                </svg>
                                            </div>
                                            <div class="select-box">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_i_44_2)">
                                                        <rect width="20" height="20" rx="5" fill="white"/>
                                                    </g>
                                                    <defs>
                                                        <filter id="filter0_i_44_2" x="0" y="0" width="20" height="20"
                                                                filterUnits="userSpaceOnUse"
                                                                color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                            <feBlend mode="normal" in="SourceGraphic"
                                                                     in2="BackgroundImageFix" result="shape"/>
                                                            <feColorMatrix in="SourceAlpha" type="matrix"
                                                                           values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                                           result="hardAlpha"/>
                                                            <feMorphology radius="1" operator="dilate" in="SourceAlpha"
                                                                          result="effect1_innerShadow_44_2"/>
                                                            <feOffset/>
                                                            <feGaussianBlur stdDeviation="3"/>
                                                            <feComposite in2="hardAlpha" operator="arithmetic" k2="-1"
                                                                         k3="1"/>
                                                            <feColorMatrix type="matrix"
                                                                           values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
                                                            <feBlend mode="normal" in2="shape"
                                                                     result="effect1_innerShadow_44_2"/>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>

                                        <h2>
                                            ورزش
                                        </h2>
                                        <span>
                                            جمع مقدار کالری:
                                            <i>
                                                25,000 K.Cal
                                            </i>
                                        </span>
                                    </div>
                                    <div class="diet-day-part-body">
                                    @if($pure_plan !== false)
                                        <!-- items -->
                                        @foreach($pure_plan[$day]['sport'] as $item_id => $item)
                                            @include('panel.orders.standalone.loop.sport-item')
                                        @endforeach
                                        <!-- items -->
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
            @endforeach
            <!-- dev foreach $diet->days -->
            </div>
        </div>

    </div>


    <div class="lightbox-overlay"></div>
    <div class="lightbox-message-cont">
        <div class="lightbox-message">
            <div class="lightbox-message-icon">
                <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M27.9994 51.3337C40.8327 51.3337 51.3327 40.8337 51.3327 28.0003C51.3327 15.167 40.8327 4.66699 27.9994 4.66699C15.166 4.66699 4.66602 15.167 4.66602 28.0003C4.66602 40.8337 15.166 51.3337 27.9994 51.3337Z"
                        stroke="#D95858" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M21.3965 34.6032L34.6032 21.3965" stroke="#D95858" stroke-width="3.5"
                          stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M34.6032 34.6032L21.3965 21.3965" stroke="#D95858" stroke-width="3.5"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="lightbox-message-title">
                <h2>
                    شما قسمتی رو انتخاب نکردید
                </h2>
            </div>
            <div class="lightbox-message-desc">
                <p>
                    لطفا یک قسمت از روز رو برای اضافه کردن آیتم های رژیم انتخاب کنید.
                </p>
            </div>
            <div class="lightbox-message-btn">
                <p>
                    باشه
                </p>
            </div>
        </div>
    </div>

    <script>


        /*********************************************************************
         **********************************************************************
         **                 declaration of Statements:                       **
         **  Diet Item = Food, Workout or Anything that User Needs to Do     **
         **  Diet Day = The Day Number of the Diet Program                   **
         **  Diet Day Part = The Meal of any Day in Diet Program             **
         **********************************************************************
         **********************************************************************/



        function adding() {
            let item_btn = document.querySelectorAll(".diet-toolkit-box-body-item");
            item_btn.forEach(element => {

                // let data_att = element.querySelector("span[data-btn-role]");

                element.addEventListener("click", () => {
                    add_to_day_part(element);
                });

            });
        }

        adding();


        function save_diet_program() {

            let save_btn = document.querySelector(".save_diet_program");
            let diet_porgram = {};


            save_btn.addEventListener("click", () => {

                let diet_days = document.querySelectorAll(".diet-parts-cont");

                diet_days.forEach(element => {

                    let diet_day = element.getAttribute("data-day");
                    diet_porgram[diet_day] = {}

                    diet_day_parts = element.querySelectorAll(".diet-days-part-cont");
                    diet_day_parts.forEach(element => {
                        let diet_day_part = element.getAttribute("data-diet-day-part");
                        diet_porgram[diet_day][diet_day_part] = {};

                        if (element.querySelector(".diet-day-part-body-item") != null) {
                            let diet_items = element.querySelectorAll(".diet-day-part-body-item");

                            let item_c = 1;

                            diet_items.forEach(element => {

                                let diet_item_id = element.getAttribute("data-diet-item-id");
                                let diet_item_title = element.querySelector(".item-title h3").innerHTML;
                                let diet_item_desc = element.querySelector(".item-title p").innerHTML;
                                let diet_item_cal = element.querySelector(".item-cal p").innerHTML;
                                let diet_item_count = element.querySelector(".item-count p").innerHTML;

                                let diet_item_obj = {};
                                diet_item_obj.id = diet_item_id;
                                diet_item_obj.title = sanitizeString(diet_item_title);
                                diet_item_obj.desc = diet_item_desc;
                                diet_item_obj.count = diet_item_count;
                                diet_item_obj.cal_unit = diet_item_cal;

                                diet_porgram[diet_day][diet_day_part][item_c] = {};
                                diet_porgram[diet_day][diet_day_part][item_c] = diet_item_obj;
                                item_c++;

                            });

                        }
                    });
                });

                console.log(diet_porgram);
                console.table(diet_porgram);
                StorePlan(diet_porgram);

            });
        }

        save_diet_program();


        function json_add_to_list(diet_item) {

        }


        function add_to_day_part(item) {

            if (document.querySelector(".diet-days-part-cont[data-selecting-day-part]") == null) {
                show_message();
                return;
            }


            if (item.getAttribute("data-diet-item-type") == "sport"
                && document.querySelector(".diet-days-part-cont[data-selecting-day-part]").getAttribute("data-diet-day-part") != "sport") {
                show_message("خطای ورزش", "شما نمیتوانید یک آیتم ورزشی رو در جایی غیر از باکس ورزش اضافه کنید.");
                return;
            }

            if (item.getAttribute("data-diet-item-type") != "sport"
                && document.querySelector(".diet-days-part-cont[data-selecting-day-part]").getAttribute("data-diet-day-part") == "sport") {
                show_message("خطای ورزش", "شما نمیتوانید یک آیتم غذایی رو در باکس ورزشی اضافه کنید.");
                return;
            }

            let day_part = document.querySelector(".diet-days-part-cont[data-selecting-day-part]");
            let day_part_body = day_part.querySelector(".diet-day-part-body");

            let item_title = item.querySelector(".toolkit-item-name").innerHTML;
            let item_desc = item.getAttribute("data-diet-item-des");
            let item_cal = item.getAttribute("data-diet-item-cal");
            let item_id = item.getAttribute("data-diet-item-id");


            // AutoIncrement List Number
            let item_list_num = 1;
            if (day_part_body.querySelectorAll(".diet-day-part-body-item") != null) {
                let item_list = day_part_body.querySelectorAll(".diet-day-part-body-item");
                item_list_num = item_list.length;
            }


            // Item
            let diet_item_node = document.createElement("div");
            diet_item_node.classList.add("diet-day-part-body-item");
            diet_item_node.setAttribute("data-diet-item-cal", item_cal);
            diet_item_node.setAttribute("data-diet-item-id", item_id);

            // Num Item
            let diet_item_num_node = document.createElement("div");
            diet_item_num_node.classList.add("item-num");

            // Num P Item
            let diet_item_num_node_p = document.createElement("p");
            diet_item_num_node_p.textContent = item_list_num + 1 + ".";

            // Title item
            let diet_item_title_node = document.createElement("div");
            diet_item_title_node.classList.add("item-title");

            // Title H3 Item
            let diet_item_title_h3 = document.createElement("h3");
            // let diet_item_title_h3_txt = document.createTextNode(item_title);
            diet_item_title_h3.textContent = item_title;

            // Title P Item
            let diet_item_title_p = document.createElement("p");
            // let diet_item_title_h3_txt = document.createTextNode(item_desc);
            diet_item_title_p.textContent = item_desc;

            // Cal Item
            let diet_item_cal_node = document.createElement("div");
            diet_item_cal_node.classList.add("item-cal");

            // Cal P Item
            let diet_item_cal_node_p = document.createElement("p");
            diet_item_cal_node_p.textContent = item_cal;

            // Count Item
            let diet_item_count_node = document.createElement("div");
            diet_item_count_node.classList.add("item-count");

            // count i P i Item
            let item_count_html = "<i>" +
                "<svg width=\"14\" height=\"2\" viewBox=\"0 0 14 2\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">" +
                "   <path d=\"M1 1H13\" stroke=\"#ABABAB\" stroke-width=\"1.22474\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>" +
                "</svg>" +
                "</i>" +
                "<p>" +
                "1" +
                "</p>" +
                "<i>" +
                "<svg width=\"14\" height=\"14\" viewBox=\"0 0 14 14\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">" +
                "    <path d=\"M1 7H13\" stroke=\"#ABABAB\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>" +
                "    <path d=\"M7 13V1\" stroke=\"#ABABAB\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>" +
                "</svg>" +
                "</i>";
            diet_item_count_node.innerHTML = item_count_html;

            // the Delete node
            let diet_item_del_node = document.createElement("div");
            diet_item_del_node.classList.add("item-delete");

            // Delete Item
            let delete_svg = "<svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">" +
                "<path d=\"M7.75781 7.75781L16.2431 16.2431\" stroke=\"#292D32\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>" +
                "<path d=\"M7.75691 16.2431L16.2422 7.75781\" stroke=\"#292D32\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>" +
                "</svg>";
            diet_item_del_node.innerHTML = delete_svg;


            // Appending HTML Nodes
            diet_item_num_node.appendChild(diet_item_num_node_p);

            diet_item_cal_node.appendChild(diet_item_cal_node_p);

            diet_item_title_node.appendChild(diet_item_title_h3);
            diet_item_title_node.appendChild(diet_item_title_p);

            // adding diet item Row nodes
            diet_item_node.appendChild(diet_item_num_node);
            diet_item_node.appendChild(diet_item_title_node);
            diet_item_node.appendChild(diet_item_count_node);
            diet_item_node.appendChild(diet_item_cal_node);
            diet_item_node.appendChild(diet_item_del_node);

            // adding Diet Row to daypart
            day_part_body.appendChild(diet_item_node);


            // food counter for new diet items
            food_counter();

            cal_calc();

            remove_item();
        }


        // This is the search through diet items
        function search_diets() {
            let toolkit_boxes = document.querySelectorAll(".diet-toolkit-box");


            toolkit_boxes.forEach(element => {
                if (element.querySelector("input.diet-toolkit-box-input") != null) {
                    let search_input = element.querySelector("input.diet-toolkit-box-input");

                    search_input.addEventListener("keyup", () => {
                        let search_str = search_input.value;
                        let toolkit_box_items = element.querySelectorAll(".diet-toolkit-box-body-item");
                        toolkit_box_items.forEach(element => {
                            let diet_title = element.querySelector(".toolkit-item-name").getAttribute("data-diet-item-title");

                            let title_str = diet_title;
                            console.log(title_str);
                            console.log(search_str);

                            if (search_str.length > 1 && search_str != "") {
                                if (title_str.search(search_str) > -1) {
                                    element.style.display = "flex";
                                } else {
                                    element.style.display = "none";
                                }
                            } else {
                                element.style.display = "flex";
                            }
                        });

                    });
                }
            });
        }

        search_diets();

        function handle_pagination(){
            let next_btn = document.querySelector(".diet-pagination .nxt-btn");
            let prev_btn = document.querySelector(".diet-pagination .prv-btn");

            let toolkit_nxt_btn = document.querySelector(".diet-toolkit-control .toolkit-nxt-btn");
            let toolkit_prv_btn = document.querySelector(".diet-toolkit-control .toolkit-prv-btn");



            next_btn.addEventListener("click" , ()=>{
                next_page();
            });

            prev_btn.addEventListener("click" , ()=>{
                prev_page();
            });

            toolkit_nxt_btn.addEventListener("click" , ()=>{
                next_page();
            });

            toolkit_prv_btn.addEventListener("click" , ()=>{
                prev_page();
            });



            function next_page(){
                let current_page = document.querySelector(".pagination div.active");
                let current_page_number = current_page.getAttribute("data-day-number");
                let current_diet_page = document.querySelector(".diet div.active");

                let all_pages = document.querySelectorAll(".pagination div.pagination-icon");
                let pages_length = all_pages.length;

                if(current_page_number != pages_length){
                    current_page.classList.remove("active");
                    current_page.nextElementSibling.classList.add("active");
                    // document.querySelector(".pagination div.pagination-icon[data-day-number="+(current_page_number+1)+"]").classList.add("active");

                    current_diet_page.classList.remove("active");
                    current_diet_page.nextElementSibling.classList.add("active");
                }else{
                    return;
                }
            }

            function prev_page(){
                let current_page = document.querySelector(".pagination div.active");
                let current_page_number = current_page.getAttribute("data-day-number");
                let current_diet_page = document.querySelector(".diet div.active");

                if(current_page_number != 1){
                    current_page.classList.remove("active");
                    current_page.previousElementSibling.classList.add("active");
                    // document.querySelector(".pagination div.pagination-icon[data-day-number="+(current_page_number+1)+"]").classList.add("active");

                    current_diet_page.classList.remove("active");
                    current_diet_page.previousElementSibling.classList.add("active");
                }else{
                    return;
                }
            }
        }

        handle_pagination();

        // This Is How We select a day
        function day_selecting() {
            let days_pagination = document.querySelectorAll(".pagination-icon");
            let days_parts = document.querySelectorAll(".diet-parts-cont");

            days_pagination.forEach(element => {
                element.addEventListener("click", () => {
                    days_pagination.forEach(element => {
                        element.classList.remove("active");
                    });
                    element.classList.add("active");

                    let day = element.getAttribute("data-day-number");
                    days_parts.forEach(element => {
                        if (element.getAttribute("data-day") == day) {
                            days_parts.forEach(element => {
                                element.classList.remove("active");
                            });
                            element.classList.add("active");
                        }
                    });

                });
            });
        }

        day_selecting();


        // Removing a row Food Item
        function remove_item() {
            let day_parts = document.querySelectorAll(".diet-day-part-body");
            day_parts.forEach(element => {
                if (element.querySelector(".diet-day-part-body-item") != null) {
                    let items = element.querySelectorAll(".diet-day-part-body-item");
                    items.forEach(element => {
                        let rem_item = element.querySelector(".item-delete");
                        rem_item.addEventListener("click", () => {
                            // animation remove
                            element.style.opacity = 0;
                            element.style.transform = "translateX(200px)";
                            // element.style.transform = "translateY(-100%)";
                            // element.style.overflow = "hidden";
                            // element.style.maxHeight = "0px";
                            setTimeout(() => {
                                element.remove();
                                cal_calc();
                            }, 300);

                            // instant remove
                            // element.remove();
                        });
                    });
                }
            });

        }

        remove_item();

        function remove_item_2(a) {
            a.addEventListener("click", () => {
                a.parentNode.remove();
            });
        }


        // Cal Calculator
        // This Is How we Calculate Callories
        function cal_calc() {
            let day_part_diet_items = document.querySelectorAll(".diet-day-part-body-item");

            day_part_diet_items.forEach(element => {
                let diet_item_cal = element.querySelector(".item-cal p");
                let diet_item_count = element.querySelector(".item-count p");
                let diet_item_cal_single = element.getAttribute("data-diet-item-cal");

                diet_item_cal.innerHTML = parseInt(diet_item_cal_single) * parseInt(diet_item_count.innerHTML);
            });


            let day_parts = document.querySelectorAll(".diet-days-part-cont");
            day_parts.forEach(element => {
                let item_cals = element.querySelectorAll(".diet-day-part-body-item .item-cal p")
                let cal_sum = 0;
                item_cals.forEach(element => {
                    cal_sum = parseInt(cal_sum) + parseInt(element.innerHTML);

                });
                let head_cal = element.querySelector(".diet-day-part-head span i");
                head_cal.innerHTML = cal_sum;
            });
        }

        cal_calc();


        function food_counter() {
            let food_item_counter = document.querySelectorAll(".diet-day-part-body-item .item-count");
            food_item_counter.forEach(element => {
                if (element.querySelector("i:last-child") != null &&
                    element.querySelector("i:first-child") != null) {

                    if (element.getAttribute("data-listener") == null) {
                        element.setAttribute("data-listener", "");

                        let counter = element.querySelector("p");
                        let i_plus = element.querySelector("i:last-child");
                        let i_minus = element.querySelector("i:first-child");

                        i_plus.addEventListener("click", () => {
                            counter.innerHTML = parseInt(counter.innerHTML) + 1;

                            // Changing Cal after changing Counter
                            cal_calc();
                        }, {capture: false});
                        i_minus.addEventListener("click", () => {
                            counter.innerHTML = parseInt(counter.innerHTML) - 1;
                            if (counter.innerHTML < 1) {
                                counter.innerHTML = 1;
                            }

                            // Changing Cal after changing Counter
                            cal_calc();
                        });
                    }
                }
            });
        }

        food_counter();


        // This is How U Select a DayPart To add Diet Items to
        function selecting_day_part() {
            let day_parts = document.querySelectorAll(".diet-days-part-cont");
            day_parts.forEach(element => {

                let select_box = element.querySelector(".diet-day-part-select");
                select_box.addEventListener("click", () => {

                    if (element.getAttribute("data-selecting-day-part") == null) {
                        day_parts.forEach(element => {
                            let select_box = element.querySelector(".diet-day-part-select");
                            select_box.classList.remove("active");

                            element.removeAttribute("data-selecting-day-part");
                        });
                    }
                    element.toggleAttribute("data-selecting-day-part");
                    select_box.classList.toggle("active");
                });
            });
        }

        selecting_day_part();


        // This is a message Light Box handler
        function show_message(msg_title, msg_desc) {
            let light_box_overlay = document.querySelector(".lightbox-overlay");
            let light_box = document.querySelector(".lightbox-message-cont");
            let light_box_btn = document.querySelector(".lightbox-message-btn");

            if (msg_title != null) {
                light_box.querySelector(".lightbox-message-title h2").innerHTML = msg_title;
            }
            if (msg_desc != null) {
                light_box.querySelector(".lightbox-message-desc p").innerHTML = msg_desc;
            }

            light_box_overlay.classList.add("lightbox-active");
            light_box.classList.add("lightbox-message-active");
            light_box_btn.addEventListener("click", () => {
                light_box_overlay.classList.remove("lightbox-active");
                light_box.classList.remove("lightbox-message-active");
            });
        }


        function sanitizeString(str) {
            // str = str.replace(/[^a-z0-9áéíóúñü \.,_-]/gim,"");
            return str.trim();
        }


        //To Persian Numeric  Function
        function to_persian_num(number) {
            let persian_numbers_v2 = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
            let persian_num = "";
            let num = number.toString();
            for (let i = 0; i < num.length; i++) {
                let num_num = num.substr(i, 1);
                persian_num += persian_numbers_v2[num_num];
            }
            return persian_num;
        }


        //Copy version
        String.prototype.toPersianDigits = function () {
            var id = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            return this.replace(/[0-9]/g, function (w) {
                return id[+w];
            });
        }
    </script>

    <script>
        function StorePlan(input) {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function () {
                if (xhttp.status === 200) {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toastr-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };

                    toastr.success(JSON.parse(this.responseText).message, 'ثبت شد.');
                } else {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toastr-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };

                    console.log(input);
                    toastr.error('دوباره تلاش کنید و یا به پشتیبان سامانه اطلاع دهید.', 'خطایی رخ داده است');
                }
            }
            xhttp.open("POST", "{{ route('panel.orders.store-json-daily-plan', $order->id) }}");
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhttp.send("json=" + JSON.stringify(input));
        }
    </script>
</div>
