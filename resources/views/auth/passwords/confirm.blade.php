<!doctype html>
<html class="no-js" lang>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Association des Transporteurs des Personnes au Rwanda</title>
    <meta name="description" content>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico' )}}" />

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css' )}}" />

    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css' )}}" />

    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.css' )}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.css' )}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl.transitions.css' )}}" />

    <link rel="stylesheet" href="{{ asset('assets/css/animate.css' )}}" />

    <link rel="stylesheet" href="{{ asset('assets/css/normalize.css' )}}" />

    <link rel="stylesheet" href="{{ asset('assets/css/scrollbar/jquery.mCustomScrollbar.min.css' )}}">

    <link rel="stylesheet" href="{{ asset('assets/css/wave/waves.min.css' )}}" />

    <link rel="stylesheet" href="{{ asset('assets/css/notika-custom-icon.css' )}}" />

    <link rel="stylesheet" href="{{ asset('assets/css/main.css' )}}" />

    <link rel="stylesheet" href="{{ asset('assets/style.css' )}}" />

    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css' )}}" />

    <script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js' )}}"></script>
    <meta name="robots" content="noindex, nofollow">

<body>


    <div class="login-content">

        <div class="nk-block toggled" id="l-login">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Confirm Password') }}
                        </button>

                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script src="{{ asset('assets/js/vendor/jquery-1.12.4.min.js')}}"></script>

    <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>

    <script src="{{ asset('assets/js/wow.min.js')}}"></script>

    <script src="{{ asset('assets/js/jquery-price-slider.js')}}"></script>

    <script src="{{ asset('assets/js/owl.carousel.min.js')}}"></script>

    <script src="{{ asset('assets/js/jquery.scrollUp.min.js')}}"></script>

    <script src="{{ asset('assets/js/meanmenu/jquery.meanmenu.js')}}"></script>

    <script src="{{ asset('assets/js/counterup/jquery.counterup.min.js')}}"></script>
    <script src="{{ asset('assets/js/counterup/waypoints.min.js')}}"></script>
    <script src="{{ asset('assets/js/counterup/counterup-active.js')}}"></script>

    <script src="{{ asset('assets/js/scrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>

    <script src="{{ asset('assets/js/sparkline/jquery.sparkline.min.js')}}"></script>
    <script src="{{ asset('assets/js/sparkline/sparkline-active.js')}}"></script>

    <script src="{{ asset('assets/js/flot/jquery.flot.js')}}"></script>
    <script src="{{ asset('assets/js/flot/jquery.flot.resize.js')}}"></script>
    <script src="{{ asset('assets/js/flot/flot-active.js')}}"></script>

    <script src="{{ asset('assets/js/knob/jquery.knob.js')}}"></script>
    <script src="{{ asset('assets/js/knob/jquery.appear.js')}}"></script>
    <script src="{{ asset('assets/js/knob/knob-active.js')}}"></script>

    <script src="{{ asset('assets/js/chat/jquery.chat.js')}}"></script>

    <script src="{{ asset('assets/js/wave/waves.min.js')}}"></script>
    <script src="{{ asset('assets/js/wave/wave-active.js')}}"></script>

    <script src="{{ asset('assets/js/icheck/icheck.min.js')}}"></script>
    <script src="{{ asset('assets/js/icheck/icheck-active.js')}}"></script>

    <script src="{{ asset('assets/js/todo/jquery.todo.js')}}"></script>

    <script src="{{ asset('assets/js/login/login-action.js')}}"></script>

    <script src="{{ asset('assets/js/plugins.js')}}"></script>

    <script src="{{ asset('assets/js/main.js')}}"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v55bfa2fee65d44688e90c00735ed189a1713218998793" integrity="sha512-FIKRFRxgD20moAo96hkZQy/5QojZDAbyx0mQ17jEGHCJc/vi0G2HXLtofwD7Q3NmivvP9at5EVgbRqOaOQb+Rg==" data-cf-beacon='{"rayId":"877ec9f8ae989e94","version":"2024.3.0","token":"cd0b4b3a733644fc843ef0b185f98241"}' crossorigin="anonymous"></script>
</body>

</html>