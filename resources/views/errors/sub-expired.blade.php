<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.ico')}}">
    <title>{{ current_company()->name }} - Your subscription has expired!</title>

    <!-- CSS -->
    <link href="{{asset('assets/css/koverae.css?'.time())}}" rel="stylesheet"/>
    <link href="{{asset('assets/css/koverae-flags.min.css?'.time())}}" rel="stylesheet"/>
    <!-- CSS -->

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/de3e85d402.js" crossorigin="anonymous"></script>
    <!-- Font Awesome -->

    <!-- Libs JS -->
    <script src="{{asset('assets/libs/list.js/dist/list.min.js')}}" data-navigate-track ></script>
    <!-- Libs JS -->
    @yield('styles')

</head>
<body>
    <script src="{{asset('assets/js/demo-theme.min.js')}}" data-navigate-track></script>
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="card card-md">
          <div class="card-body">
            <div class="mt-0 mb-2 text-center">
                <a href="#" class="navbar-brand navbar-brand-autodark">
                    <img src="{{ asset('assets/images/logo/logo-black.png') }}" width="130" height="52" alt="Tabler" class="navbar-brand-image">
                </a>
            </div>
            <h2 class="mb-3 text-center">Your free trial period has expired!</h2>
            <p class="mb-2 fs-3">
                Your access to Ndako has been temporarily paused because your subscription ended on <b>{{ current_company()->team->subscription('main')->ends_at->format('M d, Y') }}</b>.

            </p>
            <p class="mb-4 fs-3">
                Renew your subscription now to regain full access and keep managing your properties smoothly without interruptions.
                <br>
                Click below to renew and get back on track!
            </p>

            <div class="my-4">
              <a href="{{ route('subscribe', ['renew' => true]) }}" class="btn btn-primary text-uppercase w-100 fs-3">
                Renew Subscription
              </a>
            </div>
            <p class="text-secondary">
                Need help renewing your subscription? <a href="https://ndako.koverae.com/contact-us?utm=app" class=" underline" target="__blank">Contact us</a> for assistance!
            </p>
          </div>
        </div>
      </div>
    </div>


    <script src="{{ asset('assets/js/koverae.js?'.time())}}" data-navigate-track></script>
</body>

</html>
