@php
    $current_route_name = Route::currentRouteName();
@endphp

<!-- begin:: Aside Menu -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
        <ul class="kt-menu__nav ">
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">@lang('general.get_info')</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            <!-- begin: diets -->
            <li class="kt-menu__item  kt-menu__item--submenu @if(Request::is('panel/diets*'))kt-menu__item--here kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-browser-2"></i><span class="kt-menu__link-text">@lang('general.diets')</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  @if($current_route_name == 'panel.diets.index') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.diets.index') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.list', ['title' => __('general.diets')])</span></a></li>
                        @can('add_diet')
                            <li class="kt-menu__item  @if($current_route_name == 'panel.diets.create') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.diets.create') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.add', ['title' => __('general.diet')])</span></a></li>
                        @endcan
                    </ul>
                </div>
            </li>
            <!-- end: diets -->

            <!-- begin: steps -->
            @can('change_diet')
                <li class="kt-menu__item  kt-menu__item--submenu  @if(Request::is('panel/steps*'))kt-menu__item--here kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-list-2"></i><span class="kt-menu__link-text">@lang('general.steps')</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  @if($current_route_name == 'panel.steps.index') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.steps.index') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.list', ['title' => __('general.steps')])</span></a></li>
                            <li class="kt-menu__item  @if($current_route_name == 'panel.steps.create') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.steps.create') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.add', ['title' => __('general.step')])</span></a></li>
                        </ul>
                    </div>
                </li>
            @endcan
            <!-- end: steps -->

            <!-- begin: questions -->
            @can('change_diet')
                <li class="kt-menu__item  kt-menu__item--submenu @if(Request::is('panel/questions*'))kt-menu__item--here kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-list-3"></i><span class="kt-menu__link-text">@lang('general.questions')</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  @if($current_route_name == 'panel.questions.index') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.questions.index') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.list', ['title' => __('general.questions')])</span></a></li>
                            <li class="kt-menu__item  @if($current_route_name == 'panel.questions.tidy-list') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.questions.tidy-list') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.list', ['title' => __('general.questions-tidy')])</span></a></li>
                            <li class="kt-menu__item  @if($current_route_name == 'panel.questions.create') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.questions.create') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.add', ['title' => __('general.question')])</span></a></li>
                        </ul>
                    </div>
                </li>
            @endcan
            <!-- end: questions -->

            <!-- begin: foods -->
            @can('change_diet')
                <li class="kt-menu__item  kt-menu__item--submenu  @if(Request::is('panel/foods*'))kt-menu__item--here kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-list-2"></i><span class="kt-menu__link-text">@lang('general.foods')</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  @if($current_route_name == 'panel.foods.index') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.foods.index') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.list', ['title' => __('general.foods')])</span></a></li>
                            <li class="kt-menu__item  @if($current_route_name == 'panel.foods.create') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.foods.create') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.add', ['title' => __('general.food')])</span></a></li>
                        </ul>
                    </div>
                </li>
            @endcan
            <!-- end: foods -->

            <!-- begin: sports -->
            @can('change_diet')
                <li class="kt-menu__item  kt-menu__item--submenu  @if(Request::is('panel/sports*'))kt-menu__item--here kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-list-2"></i><span class="kt-menu__link-text">@lang('general.sports')</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  @if($current_route_name == 'panel.sports.index') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.sports.index') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.list', ['title' => __('general.sports')])</span></a></li>
                            <li class="kt-menu__item  @if($current_route_name == 'panel.sports.create') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.sports.create') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.add', ['title' => __('general.sport')])</span></a></li>
                        </ul>
                    </div>
                </li>
            @endcan
            <!-- end: sports -->

            <!-- begin: recommendations -->
            @can('change_diet')
            <li class="kt-menu__item  kt-menu__item--submenu  @if(Request::is('panel/recommendations*'))kt-menu__item--here kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-list-2"></i><span class="kt-menu__link-text">@lang('general.recommendations')</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  @if($current_route_name == 'panel.recommendations.index') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.recommendations.index') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.list', ['title' => __('general.recommendations')])</span></a></li>
                        <li class="kt-menu__item  @if($current_route_name == 'panel.recommendations.create') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.recommendations.create') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.add', ['title' => __('general.recommendation')])</span></a></li>
                    </ul>
                </div>
            </li>
            @endcan
            <!-- end: recommendations -->

            <!-- begin: orders -->
            @can('change_order')
                <li class="kt-menu__item  kt-menu__item--submenu  @if(Request::is('panel/orders*'))kt-menu__item--here kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-list-2"></i><span class="kt-menu__link-text">@lang('general.orders')</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  @if($current_route_name == 'panel.orders.index') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.orders.index') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.list', ['title' => __('general.orders')])</span></a></li>
                        </ul>
                    </div>
                </li>
            @endcan
            <!-- end: orders -->

            <!-- begin: invoices -->
            @can('change_invoice')
                <li class="kt-menu__item  kt-menu__item--submenu  @if(Request::is('panel/invoices*'))kt-menu__item--here kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-list-2"></i><span class="kt-menu__link-text">@lang('general.invoices')</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  @if($current_route_name == 'panel.invoices.index') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.invoices.index') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.list', ['title' => __('general.invoices')])</span></a></li>
                        </ul>
                    </div>
                </li>
            @endcan
            <!-- end: invoices -->

            <!-- begin: profiles -->
            @can('see_profiles_data')
                <li class="kt-menu__item  kt-menu__item--submenu  @if(Request::is('panel/profiles*'))kt-menu__item--here kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-list-2"></i><span class="kt-menu__link-text">@lang('general.profiles')</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  @if($current_route_name == 'panel.profiles.index') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.profiles.index') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.list', ['title' => __('general.profiles')])</span></a></li>
                            @can("change_profiles_data")
                                <li class="kt-menu__item  @if($current_route_name == 'panel.profiles.create') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.profiles.create') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.add', ['title' => __('general.profile')])</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcan
            <!-- end: profiles -->

            <!-- begin: comprehensive-report -->
            @can('see_profiles_data')
                <li class="kt-menu__item  kt-menu__item--submenu @if(Request::is('panel/comprehensive-report*'))kt-menu__item--here kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="{{ route('panel.comprehensive-report') }}" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-settings"></i><span class="kt-menu__link-text">@lang('general.comprehensive-report')</span></a></li>
            @endcan
            <!-- end: comprehensive-report -->

            <!-- begin: roles -->
            @canany(['change_profiles_data', 'change_permissions'])
                <li class="kt-menu__item  kt-menu__item--submenu  @if(Request::is('panel/roles*') || Request::is('panel/admin-roles*'))kt-menu__item--here kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-list-2"></i><span class="kt-menu__link-text">@lang('general.roles')</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            @can('change_profiles_data')
                                <!--begin::profile roles-->
                                <li class="kt-menu__item  @if($current_route_name == 'panel.roles.index') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.roles.index') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.list', ['title' => __('general.roles')]) @lang('general.profile')</span></a></li>
                                <li class="kt-menu__item  @if($current_route_name == 'panel.roles.create') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.roles.create') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.add', ['title' => __('general.role')]) @lang('general.profile')</span></a></li>
                                <!--end::profile roles-->
                            @endcan
                            @can("change_permissions")
                                <!--begin::admin roles-->
                                <li class="kt-menu__item  @if($current_route_name == 'panel.admin-roles.index') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.admin-roles.index') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.list', ['title' => __('general.roles')]) @lang('general.admin')</span></a></li>
                                <li class="kt-menu__item  @if($current_route_name == 'panel.admin-roles.create') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.admin-roles.create') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.add', ['title' => __('general.role')]) @lang('general.admin')</span></a></li>
                                <!--end::admin roles-->
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcan
            <!-- end: roles -->

            <!-- begin: cart-items -->
            @can('see_profiles_data')
                <li class="kt-menu__item  kt-menu__item--submenu @if(Request::is('panel/cart-items*'))kt-menu__item--here kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="{{ route('panel.cart-items.index') }}" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-avatar"></i><span class="kt-menu__link-text">@lang('general.cart_items')</span></a></li>
            @endcan
            <!-- end: cart-items -->

            <!-- begin: affiliation_partners -->
            @can('change_affiliation_partner')
                <li class="kt-menu__item  kt-menu__item--submenu  @if(Request::is('panel/affiliation-partners*') || Request::is('panel/affiliation-invoices*'))kt-menu__item--here kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-list-2"></i><span class="kt-menu__link-text">@lang('general.affiliation_partners')</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  @if($current_route_name == 'panel.affiliation-invoices.index') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.affiliation-invoices.index') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.affiliation_invoices')</span></a></li>
                            <li class="kt-menu__item  @if($current_route_name == 'panel.affiliation-partners.index') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.affiliation-partners.index') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.list', ['title' => __('general.affiliation_partners')])</span></a></li>
                            <li class="kt-menu__item  @if($current_route_name == 'panel.affiliation-partners.create') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.affiliation-partners.create') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.add', ['title' => __('general.affiliation_partner')])</span></a></li>
                        </ul>
                    </div>
                </li>
            @endcan
            <!-- end: affiliation_partners -->

            <!-- begin: contact_us_requests -->
            @can('change_contact_us_request')
                <li class="kt-menu__item  kt-menu__item--submenu @if(Request::is('panel/contact-us-requests*'))kt-menu__item--here kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="{{ route('panel.contact-us-requests.index') }}" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-phone"></i><span class="kt-menu__link-text">@lang('general.contact_us_requests')</span></a></li>
            @endcan
            <!-- end: contact_us_requests -->

            <!-- begin: admins -->
            @can("change_admins")
                <li class="kt-menu__item  kt-menu__item--submenu  @if(Request::is('panel/admins*'))kt-menu__item--here kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-list-2"></i><span class="kt-menu__link-text">@lang('general.admins')</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  @if($current_route_name == 'panel.admins.index') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.admins.index') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.list', ['title' => __('general.admins')])</span></a></li>
                            <li class="kt-menu__item  @if($current_route_name == 'panel.admins.create') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{ route('panel.admins.create') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">@lang('general.add', ['title' => __('general.admin')])</span></a></li>
                        </ul>
                    </div>
                </li>
            @endcan()
            <!-- end: admins -->

            <!-- begin: settings -->
            @can("change_settings")
                <li class="kt-menu__item  kt-menu__item--submenu @if(Request::is('panel/settings*'))kt-menu__item--here kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="{{ route('panel.settings.show') }}" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-settings"></i><span class="kt-menu__link-text">@lang('general.settings')</span></a></li>
            @endcan()
            <!-- end: settings -->

            <!-- begin: logout -->
            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-avatar"></i><span class="kt-menu__link-text">@lang('general.logout')</span></a></li>

            <form id="logout-form" action="{{ route('admin-logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <!-- end: logout -->

        </ul>
    </div>
</div>
<!-- end:: Aside Menu -->
