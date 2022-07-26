{{-- TODO[check-view]: these codes are temporary to test, re-write UI with proper codes, set validation errors (check controller validate too), set old data, ... --}}

@if (session('CheckUserIsValid'))
    <div class="alert alert-warning" role="alert">
        {{ session('CheckUserIsValid') }}
    </div>
@endif
@UserAjaxForm(['form_id' => 'verify-account', 'is_update' => false ])@endUserAjaxForm
<div>
    <form method="post" id="verify-account" action="{{ route('set-verification-code') }}">
        @csrf

        <div class="form-group">
            <label for="name">name</label>
            <input name="name" type="text" class="form-control" id="name" value="{{ old('name', isset($profile->name) ? $profile->name : "") }}">
        </div>

        <div class="form-group">
            <label for="mobile_number">mobile number</label>
            <input name="mobile_number" type="text" class="form-control" id="mobile_number" value="09115441688">
        </div>

        {{--  TODO[fornt-end]: add the remaning feilds --}}
        <button type="button" class="submit-button btn btn-primary">Submit</button>
    </form>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    {{-- login by password -- start --}}
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                    {{-- login by password -- end --}}
                    <hr>
                    {{-- get verification code -- start --}}
                    <form method="POST" action="{{ route('set-verification-code') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="mobile_number" class="col-md-4 col-form-label text-md-right">{{ __('Mobile number') }}</label>

                            <div class="col-md-6">
                                <input id="mobile_number" type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" value="09115441688" required autocomplete="mobile_number" autofocus>

                                @error('mobile_number')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('get code') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    {{-- get verification code -- end --}}
                    <hr>
                    {{-- login by verification code -- start --}}
                    <form method="POST" action="{{ route('verification-code-login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="mobile_number" class="col-md-4 col-form-label text-md-right">{{ __('Mobile number') }}</label>

                            <div class="col-md-6">
                                <input id="mobile_number" type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" value="09115441688" required autocomplete="mobile_number" autofocus>

                                @error('mobile_number')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="verification_code" class="col-md-4 col-form-label text-md-right">{{ __('Verification Code') }}</label>

                            <div class="col-md-6">
                                <input id="verification_code" type="text" class="form-control @error('verification_code') is-invalid @enderror" name="verification_code" required autocomplete="current-verification_code">

                                @error('verification_code')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                    {{-- login by verification code -- end --}}
                </div>
            </div>
        </div>
    </div>
</div>

