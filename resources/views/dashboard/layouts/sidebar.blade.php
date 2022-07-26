<ul class="tab-title">
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
    <li class="cursor-pointer pos-relative @if(Request::is('dashboard/my-profiles*') && !Request::is('dashboard/my-profiles/current-profile*')) active @endif" data-tab="editProfile">
        <a class="pos-absolute" href="{{ route('dashboard.my-profiles.index')  }}"></a>
        <span class="menuItemIcon icon icon-user"></span>
        <div class="menuItem">

            @lang('general.profiles')

            <span class="icon icon-forward whiteColor"></span>
        </div>
    </li>

    <li class="cursor-pointer pos-relative @if(Request::is('dashboard/orders*')) active @endif" data-tab="editProfile">
        <a class="pos-absolute" href="{{ route('dashboard.orders.index') }}"></a>
        <span class="menuItemIcon icon icon-apple2"></span>
        <div class="menuItem">

            رژیم من

            <span class="icon icon-forward whiteColor"></span>
        </div>
    </li>

    <li class="cursor-pointer pos-relative @if(Request::is('dashboard/my-profiles/current-profile*')) active @endif" data-tab="editProfile">
        <a class="pos-absolute" href="{{ route('dashboard.my-profiles.current-profile') }}"></a>
        <span class="menuItemIcon icon icon-user2"></span>
        <div class="menuItem">

            وضعیت من

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

    <li class="cursor-pointer pos-relative notif @if(Request::is('dashboard/notifications*')) active @endif" data-tab="notifications">
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
