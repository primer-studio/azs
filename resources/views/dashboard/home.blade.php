<style>
    .flex-grid {
        /*display: flex;*/
    }

    .col {
        flex: 1;
    }

    @media (max-width: 410px) {
        .flex-grid {
            display: block;
        }
    }

    .flex-grid-thirds {
        display: flex;
        justify-content: space-between;
    }

    .flex-grid-thirds .col {
        width: 32%;
    }

    .col p {
        font-weight: 900;
    }

    .flex-grid .col {
        margin: 1%;
        padding: 3%;
        border-radius: 5px;
        background: white;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }

    hr {
        display: block;
        width: 100%;
        /*border-color: #6a6a6a14;*/
        border-color: #ffffff00;
    }

    .boxed {
        border-radius: 5px;
        padding: 5%;
        margin: 3% auto;
        /*box-shadow: rgb(149 157 165 / 20%) 0px 0px 3px 0px;*/
    }
    .boxed p {
        font-weight: 600;
    }

    .background-green {
        background-color: #50cd89 !important;
        color: white;
    }

    .background-red {
        background-color: #f1416c !important;
        /*background: rgb(241,65,108);*/
        /*background: linear-gradient(45deg, rgba(241,65,108,1) 44%, rgba(255,255,255,1) 100%);*/
        color: white;
    }

    .helperBox {
        padding: 10px!important;
        text-align: right !important;
        width: auto;
        /*margin: 0 auto !important;*/
    }

    .helperBox p {
        font-weight: 900;
        /*margin-top: 5%;*/
        color: white;
        /*padding: 1% !important;*/
    }

    .icon-img {
        max-width: 50px;
        /*background: white;*/
        border-radius: 5px;
        padding: 2%;
        margin-right: -10%;
        margin-top: -28px;
    }
    .instagram {
        background: url('{{ asset('dashboard-assets/img/instagram-overlay.jpg') }}');
        background-repeat: no-repeat;
    }
    .support {
        background: url("{{ asset('dashboard-assets/img/support-overlay.jpg') }}");
        background-repeat: no-repeat;

    }
    .actionBtn {
        background: #eaf5f2;
        color: #50cd89;
        padding: 3px 11px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 800 !important;
        vertical-align: middle;
        float: left;
        margin-top: 4%;
    }
    .iteration {
        font-weight: 700;
        font-size: 20px;
    }
    .seprator {
        width: 5px;
        height: 5px;
        background: #eaf5f2;
        border-radius: 5px;
    }
</style>

<div class="w-100 whiteBackColor border-radius-10 px-4 pt-4 pb-3">

    <div class="flex-grid">
        <div class="col">
            <p class="rightFloat" style="margin-bottom: 3%">
                <span style="vertical-align: middle; color: #50cd89" class="menuItemIcon icon icon-apple2"></span>
                آخرین رژیم‌ها
            </p>
            <hr>
            @if(count($orders))
                @foreach($orders as $order)
                    <div class="boxed">
                    <p style="font-weight: 400 !important; text-align: right; display: block">
                        <span class="iteration">
                            {{ $loop->iteration }}
                        </span>
                        <span class="seprator"></span>
                        {{ $order->invoiceItem->diet_registered_data->title }}
                        <a class="actionBtn" href="{{ route('dashboard.orders.show', $order->id) }}">نمایش</a>
                    </p>
                    </div>
                @endforeach
                <span class="seprator"></span>
                <span class="seprator"></span>
                <span class="seprator"></span>
            @else
                <p class="">رژیمی ثبت
                    نکرده‌اید!</p>
            @endif
        </div>
        <div class="col">
            <p class="rightFloat" style="margin-bottom: 3%">
                <span style="vertical-align: middle; color: #50cd89" class="menuItemIcon icon icon-user"></span>
                دسترسی سریع
            </p>
            <hr>
            <a href="tel:+989352230154">
                <div class="boxed background-green helperBox support">
                    <p>
    {{--                    <img class="icon-img" src="{{ asset('dashboard-assets/img/contact.png') }}" alt="">--}}
                        <span>تماس با پشتیبان</span>
                    </p>
                    <p style="text-align: left !important; ">09352230154</p>
                </div>
            </a>
            <a href="https://www.instagram.com/azshanbe.me/" target="_blank">
                <div class="boxed background-red helperBox instagram">
                    <p>
    {{--                    <img class="icon-img" src="{{ asset('dashboard-assets/img/instagram-3d.png') }}" alt="">--}}
                        <span>اینستاگرام ازشنبه</span>
                    </p>
                    <p style="text-align: left !important; ">azshanbe.me</p>
                </div>
            </a>
            <span class="seprator"></span>
            <span class="seprator"></span>
            <span class="seprator"></span>
        </div>
    </div>

</div>
