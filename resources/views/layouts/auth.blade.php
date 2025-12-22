<!DOCTYPE html>
<html lang="zxx" class="js">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/dashlitee1e3.css?ver=3.2.4') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/themee1e3.css?ver=3.2.4') }}">
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

<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content ">
                    <div class="nk-split nk-split-page nk-split-lg">
                        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                            <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                                <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo">
                                    <em class="icon ni ni-info"></em>
                                </a>
                            </div>

                            @yield('content')

                            <div class="nk-block nk-auth-footer">
                                <div class="nk-block-between">
                                    <ul class="nav nav-sm">
                                        <li class="nav-item"><a class="link link-primary fw-normal py-2 px-3"
                                                href="#">Terms & Condition</a></li>
                                        <li class="nav-item"><a class="link link-primary fw-normal py-2 px-3"
                                                href="#">Privacy Policy</a></li>
                                        <li class="nav-item"><a class="link link-primary fw-normal py-2 px-3"
                                                href="#">Help</a></li>

                                    </ul>
                                </div>
                                <div class="mt-3">
                                    <p>&copy; 2024 DashLite. All Rights Reserved.</p>
                                </div>
                            </div>
                        </div>
                        <div class="nk-split-content nk-split-stretch bg-lighter d-flex toggle-break-lg toggle-slide toggle-slide-right"
                            data-toggle-body="true" data-content="athPromo" data-toggle-screen="lg"
                            data-toggle-overlay="true">
                            <div class="slider-wrap w-100 w-max-550px p-3 p-sm-5 m-auto">
                                <div class="slider-init" data-slick='{"dots":true, "arrows":false}'>
                                    <div class="slider-item">
                                        <div class="nk-feature nk-feature-center">
                                            <div class="nk-feature-img"><img class="round"
                                                    src="../../images/slides/promo-a.png"
                                                    srcset="/demo1/images/slides/promo-a2x.png 2x" alt=""></div>
                                            <div class="nk-feature-content py-4 p-sm-5">
                                                <h4>Dashlite</h4>
                                                <p>You can start to create your products easily with its user-friendly
                                                    design & most completed responsive layout.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slider-item">
                                        <div class="nk-feature nk-feature-center">
                                            <div class="nk-feature-img"><img class="round"
                                                    src="../../images/slides/promo-b.png"
                                                    srcset="/demo1/images/slides/promo-b2x.png 2x" alt=""></div>
                                            <div class="nk-feature-content py-4 p-sm-5">
                                                <h4>Dashlite</h4>
                                                <p>You can start to create your products easily with its user-friendly
                                                    design & most completed responsive layout.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slider-item">
                                        <div class="nk-feature nk-feature-center">
                                            <div class="nk-feature-img"><img class="round"
                                                    src="../../images/slides/promo-c.png"
                                                    srcset="/demo1/images/slides/promo-c2x.png 2x" alt=""></div>
                                            <div class="nk-feature-content py-4 p-sm-5">
                                                <h4>Dashlite</h4>
                                                <p>You can start to create your products easily with its user-friendly
                                                    design & most completed responsive layout.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slider-dots"></div>
                                <div class="slider-arrows"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('/assets/js/bundlee1e3.js?ver=3.2.4')}}"></script>
    <script src="{{ asset('/assets/js/scriptse1e3.js?ver=3.2.4')}}"></script>
    <script src="{{ asset('/assets/js/demo-settingse1e3.js?ver=3.2.4')}}"></script>
</body>

</html>