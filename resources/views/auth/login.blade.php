@extends('layouts.auth')

@section('page_title', 'Sign In')

@section("styles")

<style>
    /* cyrillic-ext */
@font-face {
  font-family: 'Caveat';
  font-style: normal;
  font-weight: 400 700;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/caveat/v18/Wnz6HAc5bAfYB2Q7azYYmg8.woff2) format('woff2');
  unicode-range: U+0460-052F, U+1C80-1C8A, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
}
/* cyrillic */
@font-face {
  font-family: 'Caveat';
  font-style: normal;
  font-weight: 400 700;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/caveat/v18/Wnz6HAc5bAfYB2Q7YjYYmg8.woff2) format('woff2');
  unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
}
/* latin-ext */
@font-face {
  font-family: 'Caveat';
  font-style: normal;
  font-weight: 400 700;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/caveat/v18/Wnz6HAc5bAfYB2Q7aDYYmg8.woff2) format('woff2');
  unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Caveat';
  font-style: normal;
  font-weight: 400 700;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/caveat/v18/Wnz6HAc5bAfYB2Q7ZjYY.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
      .ndako {
        font-family: 'Caveat', cursive;
        font-size: 22px;
        font-size: 2rem;
        font-style: normal;
        color: #017E84;
      }
</style>
@endsection

@section('page_content')
<div class="overflow-x-hidden page page-center">
    <div class="row align-items-center g-4">
        <div class="col-lg">
            <div class="container py-4 container-tight">
                <div class="card card-md">
                <div class="card-body">
                    <div class="mt-0 mb-2 text-center">
                        <a href="#" class="navbar-brand navbar-brand-autodark">
                            <img src="{{ asset('assets/images/logo/logo-black.png') }}" width="130" height="52" alt="Tabler" class="navbar-brand-image">
                        </a>
                    </div>
                    <h2 class="mb-4 text-center h2">Login to your account</h2>
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <form method="POST" action="{{ route('login') }}" id="login">
                        @csrf

                        @if ($errors->has('message'))
                            <span class="text-danger">{{ $errors->first('message') }}</span>
                        @endif
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                        @endif

                        <div class="mb-3">
                            <label class="form-label" for="email">Email address</label>
                            <input type="email" class="form-control" placeholder="eg. ardenbouet@koverae.com" id="email" name="email" value="{{ old('email') }}" required>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="password">
                            Password
                            @if (Route::has('password.request'))
                            <span class="form-label-description">
                                <a href="{{ route('password.request') }}">I forgot password</a>
                            </span>
                            @endif
                            </label>
                            <div class="input-group input-group-flat">
                            <input type="password" class="form-control"  placeholder="Your password" id="password" name="password"  autocomplete="off">
                            <span class="input-group-text">
                                <span  onclick="togglePassword()" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://koverae-icons.io/i/eye -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                </span>
                            </span>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="mb-2">
                            <label class="form-check" for="remember_me">
                            <input type="checkbox" id="remember_me" name="remember" class="form-check-input"/>
                            <span class="form-check-label">Remember me on this device</span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">Sign in</button>
                        </div>
                    </form>
                </div>
                <div class="hr-text">or</div>
                <div class="p-3 card-body">
                    <div class="row">
                        <div class="mt-2 col-md-12 col-12">
                            <a href="{{ route('auth.google.redirect') }}" class="btn w-100">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-google"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.945 11a9 9 0 1 1 -3.284 -5.997l-2.655 2.392a5.5 5.5 0 1 0 2.119 6.605h-4.125v-3h7.945z" /></svg>
                                {{ __('Sign in with Google') }}
                            </a>
                        </div>
                    </div>
                    <div class="mt-4 text-center text-secondary">
                        Powered by <a class="ndako" target="_blank" href="https://ndako.koverae.com/?utm=on-premise">Ndako</a>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')

@if(env('GOOGLE_RECAPTCHA_KEY'))
<script type="text/javascript">
    $('#login').submit(function(event) {
        event.preventDefault();

        grecaptcha.ready(function() {
            grecaptcha.execute("{{ env('GOOGLE_RECAPTCHA_KEY') }}", {action: 'subscribe_newsletter'}).then(function(token) {
                $('#login').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
                $('#login').unbind('submit').submit();
            });
        });
    });
</script>
@endif

@endsection
