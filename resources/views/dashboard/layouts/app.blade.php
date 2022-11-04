<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-143066024-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-143066024-1');
        gtag('config', 'AW-632997514');
    </script>
        <!-- sanjagh push code -->
            <script>!function(e,t,n,s){var a=t.createElement("script"),r=new Date;a.src="https://cdn.sanjagh.com/assets/sdk/notif.js?t="+r.getFullYear().toString()+r.getMonth()+r.getDate()+r.getHours(),a.async=!0,a.defer=!0,e.snj_notif={publisher_id:"5e47fafc0a27c9320b2ffae3",delay:5};var i=t.getElementsByTagName("script")[0];i.parentNode.insertBefore(a,i)}(window,document);</script>
		<!-- ./sanjagh push code -->


    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WXSK7CB');</script>
    <!-- End Google Tag Manager -->

    <meta charset="UTF-8">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
    $default_title = "ازشنبه - رژیم غذایی آنلاین و رژیم درمانی";
    if (Request::is('/')) {
    $title = $default_title;
    }

    if (empty($title)) {
    if (Request::is('dashboard*')) {
    $title_section = "داشبورد";
    }

    if (Request::is('dashboard/invoices*')) {
    $title_section = "صورت حساب";
    }

    if (Request::is('dashboard/my-profiles*')) {
    $title_section = "پروفایل";
    }

    if (Request::is('dashboard/my-profiles/current-profile*')) {
    $title_section = "وضعیت من";
    }

    if (Request::is('dashboard/orders*')) {
    $title_section = "رژیم من";
    }

    if (Request::is('dashboard/proforma-invoice')) {
    $title_section = "پیش فاکتور";
    }

    if (Request::is('dashboard/offline-payment*')) {
    $title_section = "پرداخت آفلاین";
    }

    if (Request::is('dashboard/notifications*')) {
    $title_section = "اعلان";
    }

    if (Request::is('dashboard/diets*')) {
    $title_section = "رژیم جدید";
    }

    if (Request::is('login*')) {
    $title_section = "ورود";
    }

    if (Request::is('contact*')) {
    $title_section = "تماس با ما ";
    }

    if (Request::is('about*')) {
    $title_section = "درباره ما";
    }

    if (Request::is('terms*')) {
    $title_section = "قوانین و مقررات";
    }

    if (Request::is('terms*')) {
    $title_section = "قوانین و مقررات";
    }

    $title = !empty($title_section) ? ($title_section . " | ازشنبه") : $default_title;
    }
    @endphp

    <title>{{ isset($page_title) ? $page_title : $title }}</title>

    <base href="{{ url('dashboard-assets') }}/">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{  asset('/dashboard-assets/css/styles.css?v=1.0.94') }}">
    <link rel="stylesheet" href="{{  asset('/dashboard-assets/css/circle.css?v=1.0.2') }}">
    <link rel="stylesheet" href="{{  asset('/dashboard-assets/third-party/toastr-master/toastr.min.css') }}">
    <link rel="stylesheet" href="{{  asset('/dashboard-assets/css/rtop.videoPlayer.1.0.1.min.css') }}" />

    <link rel="stylesheet" href=" {{ asset('/dashboard-assets/css/filepond.css') }}">
    <link rel="stylesheet" href=" {{ asset('/dashboard-assets/css/filepond-plugin-image-preview.css') }}">
    @stack('styles')
</head>

<body class="whiteBackColor">
@if(env('APP_ENG') == 'local')
    <div style="width: 100%; padding: 1%; margin-bottom: 2px; background: #721c24; color: white; text-align: center; font-family: Courier New, Courier, monospace">
        <p>you are in local/dev server</p>
    </div>
    @endif

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WXSK7CB"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!--begin::main-->
    @yield('body')
    <!--end::main-->

    <!--begin::Global JS variables -->
    <script>
        var not_found = "{{ __('general.not_found') }}";
        var there_was_a_problem = "{{ __('general.there_was_a_problem') }}";
        var processing = "{{ __('general.processing') }}";
        var please_wait = "{{ __('general.please_wait') }}";
        var sending = "{{ __('general.sending') }}";
        var remove = "{{ __('general.remove') }}";
    </script>
    <!--end::Global JS variables -->

    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/swiper.min.js"></script>
    <script type="text/javascript" src="js/circle-progress.min.js"></script>
    <script type="text/javascript" src="{{  asset('/dashboard-assets/third-party/toastr-master/toastr.min.js') }}"></script>
    <!-- required video player js source -->
	<script type="text/javascript" src="js/rtop.videoPlayer.1.0.1.min.js"></script>
    <script type="text/javascript" src="js/main.js?v=1.0.34"></script>

    <script src="{{ asset('/js/functions.js') }}"></script>
    <script src="{{ asset('/dashboard-assets/js/functions.js') }}"></script>
    {{-- <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="428ab99a-3fe5-444a-b10c-746e55f64547";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script> --}}

    @stack('scripts')

    {{-- success_message  --}}
    @if (\Session::has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var message = '{!! \Session::get("success") !!}';
            addSuccessNotification(message);
        })
    </script>
    @endif
    {{-- success_message  --}}

    {{-- error_message  --}}
    @if (\Session::has('errors'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach(\Session::pull("errors") as $error)
            var message = '{!! $error !!}';
            addErrorNotification(message);
            @endforeach
        })
    </script>
    @endif
    {{-- error_message  --}}

    {{--begin::larave validation error message (by redirect back)--}}
    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach($errors-> all() as $error)
            var message = '{!! $error !!}';
            addErrorNotification(message);
            @endforeach
        })
    </script>
    @endif
    {{--end::larave validation error message (by redirect back)--}}

<script type="module" src="{{ asset('/dashboard-assets/js/ionicons.esm.js') }}"></script>
<script src="{{ asset('/dashboard-assets/js/ionicons.js') }}"></script>

<script src="{{ asset('/dashboard-assets/js/filepond-plugin-image-preview.js') }}"></script>
<script src="{{ asset('/dashboard-assets/js/filepond-plugin-file-validate-type.js') }}"></script>
<script src="{{ asset('/dashboard-assets/js/filepond.js') }}"></script>
<script>
    FilePond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview
    );
    // const pond = FilePond.parse(document.body);

    FilePond.setOptions({
        acceptedFileTypes: ['image/*', 'video/*'],
        labelIdle: '.<span class="filepond--label-action"> انتخاب کنید </span> فایل را رها کنید و یا',
        labelFileProcessing: '... در حال آپلود',
        labelInvalidField: '.فرمت غیر مجاز است',
        labelFileProcessingComplete: '.با موفقیت آپلود شد',
        labelTapToCancel: 'برای لغو کلیک کنید',
        labelTapToRetry: '؟تلاش مجدد',
        allowRemove: true,
        allowRevert: false,

        // plugin imagePreview settings
        allowImagePreview: true,
        imagePreviewMarkupShow: true,

        server:{
            url: '{{ route('dashboard.assets.upload') }}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            method: 'POST',
        }
    });
    const inputElement = document.querySelector('input[type="file"]');
    const pond = FilePond.create( inputElement );
    pond.on('processfiles', (error, file) => {
        if (error) {
            console.log(error);
        } else {
            window.location.reload();
        }
    });
</script>
</body>

</html>
