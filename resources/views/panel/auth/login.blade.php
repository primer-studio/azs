@extends('panel.layouts.auth-app')

@section('content')
    <div class="kt-login__body">

        <!--begin::Signin-->
        <div class="kt-login__form">
            <div class="kt-login__title">
                <h3>Sign In</h3>
            </div>

            <!--begin::Form-->
            <form class="kt-form"  method="POST" action="{{ route('admin-login') }}" novalidate="novalidate" id="kt_login_form">
                @csrf
                <div class="form-group @error('email') validate is-invalid @enderror">
                    <input class="form-control" type="text"  placeholder="Email" name="email">
                    @error('email')
                        <div  class="error invalid-feedback" style=""><strong>{{ $message }}</strong></div>
                    @enderror
                </div>
                <div class="form-group @error('password') validate is-invalid @enderror">
                    <input class="form-control" type="password" placeholder="Password" name="password"  >
                    @error('password')
                        <div  class="error invalid-feedback" style=""><strong>{{ $message }}</strong></div>
                    @enderror
                </div>

                <!--begin::Action-->
                <div class="kt-login__actions">
                    @if (Route::has('password.request'))
                        <a class="kt-link kt-login__link-forgot" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                    <button id="kt_login_signin_submit" class="btn btn-primary btn-elevate kt-login__btn-primary">Sign In</button>
                </div>

                <!--end::Action-->
            </form>

            <!--end::Form-->
        </div>

        <!--end::Signin-->
    </div>
@endsection
