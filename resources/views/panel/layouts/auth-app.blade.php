<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->
<head>
    <base href="{{ url('/') }}">
    <meta charset="utf-8" />
    <title>AzShanbe</title>
    <meta name="description" content="Login page example">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Page Custom Styles(used by this page) -->
    <link href="{{ asset("panel-assets/template/assets/css/pages/login/login-1.css") }}" rel="stylesheet" type="text/css" />

    <!--end::Page Custom Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{ asset("panel-assets/template/assets/plugins/global/plugins.bundle.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("panel-assets/template/assets/css/style.bundle.css") }}" rel="stylesheet" type="text/css" />

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{ asset("panel-assets/template/assets/css/skins/header/base/light.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("panel-assets/template/assets/css/skins/header/menu/light.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("panel-assets/template/assets/css/skins/brand/dark.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("panel-assets/template/assets/css/skins/aside/dark.css") }}" rel="stylesheet" type="text/css" />

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{ asset("panel-assets/template/assets/media/logos/favicon.ico") }}" />
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root">
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v1" id="kt_login">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">

            <!--begin::Aside-->
            <div class="kt-grid__item kt-grid__item--order-tablet-and-mobile-2 kt-grid kt-grid--hor kt-login__aside" style="background-image: url(panel-assets/template/assets/media/bg/bg-4.jpg);">
                <div class="kt-grid__item">
                    <a href="#" class="kt-login__logo">
                        <img src="{{ asset("panel-assets/template/assets/media/logos/logo-4.png") }}">
                    </a>
                </div>
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver">
                    <div class="kt-grid__item kt-grid__item--middle">
                        <h3 class="kt-login__title">Welcome to Az Shanbe!</h3>
                        <h4 class="kt-login__subtitle">That's it. Let's get back to work</h4>
                    </div>
                </div>
                <div class="kt-grid__item">
                    <div class="kt-login__info">
                        <div class="kt-login__copyright">
                            &copy 2020 Azshanbe
                        </div>
                        <div class="kt-login__menu">
                            <a href="#" class="kt-link">Privacy</a>
                            <a href="#" class="kt-link">Legal</a>
                            <a href="#" class="kt-link">Contact</a>
                        </div>
                    </div>
                </div>
            </div>

            <!--begin::Aside-->

            <!--begin::Content-->
            <div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">

                <!--begin::Body-->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
                <!--end::Body-->
            </div>

            <!--end::Content-->
        </div>
    </div>
</div>

<!-- end:: Page -->

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": [
                    "#c5cbe3",
                    "#a1a8c3",
                    "#3d4465",
                    "#3e4466"
                ],
                "shape": [
                    "#f0f3ff",
                    "#d9dffa",
                    "#afb4d4",
                    "#646c9a"
                ]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="{{ asset("panel-assets/template/assets/plugins/global/plugins.bundle.js") }}" type="text/javascript"></script>
<script src="{{ asset("panel-assets/template/assets/js/scripts.bundle.js") }}" type="text/javascript"></script>

<!--end::Global Theme Bundle -->


</body>

<!-- end::Body -->
</html>
