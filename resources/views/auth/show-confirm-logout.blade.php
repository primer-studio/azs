<!doctype html>
{{-- TODO[check-view]: these codes are temporary to test, re-write UI with proper codes, set validation errors (check controller validate too), set old data, ... --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-4">
            {{-- TODO[fix-label]: fix label/message --}}
            the requested operation will logout you as {{ $type }}<br>
            {{--
                NOTICE: the form action is not important to be a individual method for this form
                1. it must be in LoginController
                2. it must support POST method
                3. it must mention to the login method for the user $type (for users: LoginController@login for admins: LoginController@adminLogin )
                4. the handle() method in RedirectIfAuthenticated midlleware will mange the operation
            --}}
            <form action="{{ ($type == 'user') ? url('/login') : route('admin-login') }}" method="post">
                @csrf
                <input name="type" type="hidden" value="{{$type}}">
                <button type="submit">I confirm to logout as {{ $type }}</button> or
                <a href="{{ ($type == 'user') ? url('/login') : route('admin-login') }}">go back to home</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
