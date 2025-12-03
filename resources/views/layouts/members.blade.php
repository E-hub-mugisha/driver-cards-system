<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name', 'Association des Transporteurs des Personnes au Rwanda (ATPR).') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <!-- font awesome CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css')}}">
    <!-- owl.carousel CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.transitions.css')}}">
    <!-- meanmenu CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/meanmenu/meanmenu.min.css')}}">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css')}}">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/normalize.css')}}">
    <!-- wave CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/wave/waves.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/wave/button.css')}}">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/scrollbar/jquery.mCustomScrollbar.min.css')}}">
    <!-- Notika icon CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/notika-custom-icon.css')}}">
    <!-- Data Table JS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.dataTables.min.css')}}">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css')}}">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/style.css')}}">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css')}}">
    <!-- modernizr JS
		============================================ -->
    <script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js')}}"></script>
</head>

<body>

    <div class="header-top-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="logo-area">
                        <a href="#"><img src="{{ asset('assets/img/logo/atpr.png')}}" alt="" height="50px" /></a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="header-top-menu">
                        <ul class="nav navbar-nav notika-top-nav">

                            <li class="nav-item">
                                <a role="button" data-toggle="modal" data-target="#myModalAddDriver" class="nav-link"><span>Add Driver</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('driver.index')}}" role="button" class="nav-link"><span>Driver</span></a>
                            </li>

                            <li class="nav-item">
                                <button href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link btn-xs btn-danger danger-icon-notika waves-effect" style="margin-top: 1rem; margin-left: 1.5rem;">
                                <i class="notika-icon notika-next"></i>
                                    {{ __('Logout') }}
                                </button>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Top Area -->
    @include('sweetalert::alert')
    <!-- Main Menu area End-->
    @yield('content')
    <!-- Start Footer area-->
    <div class="footer-copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="footer-copy-right">
                        <p>Copyright © <?php echo date("Y"); ?>
                            . All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer area-->
    <!-- jquery
		============================================ -->
    <script src="{{ asset('assets/js/vendor/jquery-1.12.4.min.js')}}"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
    <!-- wow JS
		============================================ -->
    <script src="{{ asset('assets/js/wow.min.js')}}"></script>
    <!-- price-slider JS
		============================================ -->
    <script src="{{ asset('assets/js/jquery-price-slider.js')}}"></script>
    <!-- owl.carousel JS
		============================================ -->
    <script src="{{ asset('assets/js/owl.carousel.min.js')}}"></script>
    <!-- scrollUp JS
		============================================ -->
    <script src="{{ asset('assets/js/jquery.scrollUp.min.js')}}"></script>
    <!-- meanmenu JS
		============================================ -->
    <script src="{{ asset('assets/js/meanmenu/jquery.meanmenu.js')}}"></script>
    <!-- counterup JS
		============================================ -->
    <script src="{{ asset('assets/js/counterup/jquery.counterup.min.js')}}"></script>
    <script src="{{ asset('assets/js/counterup/waypoints.min.js')}}"></script>
    <script src="{{ asset('assets/js/counterup/counterup-active.js')}}"></script>
    <!-- mCustomScrollbar JS
		============================================ -->
    <script src="{{ asset('assets/js/scrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <!-- sparkline JS
		============================================ -->
    <script src="{{ asset('assets/js/sparkline/jquery.sparkline.min.js')}}"></script>
    <script src="{{ asset('assets/js/sparkline/sparkline-active.js')}}"></script>
    <!-- flot JS
		============================================ -->
    <script src="{{ asset('assets/js/flot/jquery.flot.js')}}"></script>
    <script src="{{ asset('assets/js/flot/jquery.flot.resize.js')}}"></script>
    <script src="{{ asset('assets/js/flot/flot-active.js')}}"></script>
    <!-- knob JS
		============================================ -->
    <script src="{{ asset('assets/js/knob/jquery.knob.js')}}"></script>
    <script src="{{ asset('assets/js/knob/jquery.appear.js')}}"></script>
    <script src="{{ asset('assets/js/knob/knob-active.js')}}"></script>
    <!--  Chat JS
		============================================ -->
    <script src="{{ asset('assets/js/chat/jquery.chat.js')}}"></script>
    <!--  todo JS
		============================================ -->
    <script src="{{ asset('assets/js/todo/jquery.todo.js')}}"></script>
    <!--  wave JS
		============================================ -->
    <script src="{{ asset('assets/js/wave/waves.min.js')}}"></script>
    <script src="{{ asset('assets/js/wave/wave-active.js')}}"></script>
    <!-- plugins JS
		============================================ -->
    <script src="{{ asset('assets/js/plugins.js')}}"></script>
    <!-- Data Table JS
		============================================ -->
    <script src="{{ asset('assets/js/data-table/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/js/data-table/data-table-act.js')}}"></script>
    <!-- main JS
		============================================ -->
    <script src="{{ asset('assets/js/main.js')}}"></script>
</body>

</html>