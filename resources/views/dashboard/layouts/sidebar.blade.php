<ul class="tab-title">
    <li>
{{--        @if(!\Facades\App\Libraries\ProfileHelper::DoesUserSetRealName($profile->id))--}}
{{--            <style>--}}
{{--                .blink {--}}
{{--                    animation: blink-animation 1s steps(5, start) infinite;--}}
{{--                    -webkit-animation: blink-animation 1s steps(5, start) infinite;--}}
{{--                }--}}

{{--                @keyframes blink-animation {--}}
{{--                    to {--}}
{{--                        visibility: hidden;--}}
{{--                    }--}}
{{--                }--}}

{{--                @-webkit-keyframes blink-animation {--}}
{{--                    to {--}}
{{--                        visibility: hidden;--}}
{{--                    }--}}
{{--                }--}}
{{--            </style>--}}
{{--            <a href="{{ route('dashboard.my-profiles.edit', \Facades\App\Libraries\ProfileHelper::getCurrentProfile()->id) }}">--}}
{{--                <p--}}
{{--                    style="--}}
{{--                    /*background: #ffc700;*/--}}
{{--                    color: #f1416c;--}}
{{--                    padding: 1.25rem !important;--}}
{{--                    border-radius: 3px;--}}
{{--                    /*color: white;*/--}}
{{--                    font-weight: 800;--}}
{{--                    width: 70%;--}}
{{--                    margin: 0px auto;--}}
{{--                "--}}
{{--                    class="font-size-14 boldFont ">--}}
{{--                    <span class="icon icon-danger font-size-16 rightFloat" style="margin-left: 3%"></span>--}}
{{--                    بروزرسانی پروفایل--}}
{{--                </p>--}}
{{--            </a>--}}
{{--        @endif--}}
    </li>
    <li class="cursor-pointer pos-relative @if(Request::is('dashboard')) active @endif" data-tab="dietDashbord">
        <a class="pos-absolute" href="{{ route('dashboard.home')  }}"></a>
        <span class="menuItemIcon icon icon-dash"></span>
        <div class="menuItem">

            @lang('general.dashboard')

            <span class="icon icon-forward whiteColor"></span>
        </div>
    </li>

    <li class="cursor-pointer pos-relative @if(Request::is('dashboard/invoices*')) active @endif" data-tab="diets">
        <a class="pos-absolute" href="{{ route('dashboard.invoices.index')  }}"></a>
        <span class="menuItemIcon icon icon-cart"></span>
        <div class="menuItem">

            @lang('general.invoices')

            <span class="icon icon-forward whiteColor"></span>
        </div>
    </li>
{{--    <li class="cursor-pointer pos-relative @if(Request::is('dashboard/my-profiles*') && !Request::is('dashboard/my-profiles/current-profile*')) active @endif"--}}
{{--        data-tab="editProfile">--}}
{{--        <a class="pos-absolute" href="{{ route('dashboard.my-profiles.index')  }}"></a>--}}
{{--        <span class="menuItemIcon icon icon-user"></span>--}}
{{--        <div class="menuItem">--}}

{{--            @lang('general.profiles')--}}

{{--            <span class="icon icon-forward whiteColor"></span>--}}
{{--        </div>--}}
{{--    </li>--}}

    <li class="cursor-pointer pos-relative @if(Request::is('dashboard/orders*')) active @endif" data-tab="editProfile">
        <a class="pos-absolute" href="{{ route('dashboard.orders.index') }}"></a>
        <span class="menuItemIcon icon icon-apple2"></span>
        <div class="menuItem">

            رژیم من

            <span class="icon icon-forward whiteColor"></span>
        </div>
    </li>

    <li class="cursor-pointer pos-relative @if(Request::is('dashboard/assets*')) active @endif" data-tab="assets">
        <a class="pos-absolute" href="{{ route('dashboard.assets', 'list') }}"></a>
{{--        <span class="menuItemIcon icon icon-apple"></span>--}}

        <ion-icon style="font-size: 20px; @if(Request::is('dashboard/assets*')) color: darkseagreen @endif" name="document-outline"></ion-icon>
        <div class="menuItem">

            فایل‌ها

            <span class="icon icon-forward whiteColor"></span>
        </div>
    </li>

    <li class="cursor-pointer pos-relative @if(Request::is('dashboard/my-profiles/current-profile*')) active @endif"
        data-tab="editProfile">
        <a class="pos-absolute" href="{{ route('dashboard.my-profiles.current-profile') }}"></a>
        <span class="menuItemIcon icon icon-user2"></span>
        <div class="menuItem">

            ویرایش پروفایل

            <span class="icon icon-forward whiteColor"></span>
        </div>
    </li>

    <li class="cursor-pointer pos-relative @if(Request::is('dashboard/diets*')) active @endif" data-tab="editProfile">
        <a class="pos-absolute" href="{{ route('dashboard.diets') }}"></a>
        <span class="menuItemIcon icon icon-heart2"></span>
        <div class="menuItem">

            رژیم جدید

            <span class="icon icon-forward whiteColor"></span>
        </div>
    </li>

    <li class="cursor-pointer pos-relative notif @if(Request::is('dashboard/notifications*')) active @endif"
        data-tab="notifications">
        <a class="pos-absolute" href="{{ route('dashboard.notifications') }}"></a>
        <span class="menuItemIcon icon icon-bell"></span>
        @php
            $unread_notifications_count = \Facades\App\Libraries\ProfileHelper::getCurrentProfile()->unreadNotifications()->count();
        @endphp
        <div class="menuItem">
            اعلان ها
            @if($unread_notifications_count)
                <span class="notifNumber">
                {{ $unread_notifications_count  }}
            </span>
            @endif
        </div>
    </li>
    <li class="cursor-pointer pos-relative">
        <span class="menuItemIcon icon icon-sign-out"></span>
        <div class="menuItem">

            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                خروج از حساب
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <span class="icon icon-forward whiteColor"></span>
        </div>
    </li>
</ul>
