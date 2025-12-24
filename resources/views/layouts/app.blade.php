<!DOCTYPE html>
<html lang="zxx" class="js">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
  <meta charset="utf-8">
  <meta name="author" content="Softnio">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description"
    content="#">
  <link rel="shortcut icon" href="../../images/favicon.png">
  <title>@yield('title') | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/dashlitee1e3.css?ver=3.2.4') }}">
  <link id="skin-default" rel="stylesheet" href="{{ asset('/assets/css/themee1e3.css?ver=3.2.4') }}">
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-91615293-4"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-91615293-4');
  </script>
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
  <div class="nk-app-root">
    <div class="nk-main ">
      @include('layouts.sidebar')
      <div class="nk-wrap ">
        @include('layouts.header')
        <!-- End Header Top Area -->
        @include('sweetalert::alert')
        <!-- Main Menu area End-->
        <div class="nk-content ">
          @yield('content')
        </div>
        <!-- Start Footer area-->

        @include('layouts.footer')
        <!-- End Footer area-->
      </div>
    </div>
  </div>
  <script src="{{ asset('/assets/js/bundlee1e3.js?ver=3.2.4') }}"></script>
  <script src="{{ asset('/assets/js/scriptse1e3.js?ver=3.2.4') }}"></script>
  <script src="{{ asset('/assets/js/demo-settingse1e3.js?ver=3.2.4') }}"></script>
  <script src="{{ asset('/assets/js/libs/datatable-btnse1e3.js?ver=3.2.4') }}"></script>

</body>

</html>