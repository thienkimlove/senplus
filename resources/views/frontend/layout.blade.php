<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SenPlus, nền tảng khảo sát online. Cung cấp giải pháp cho doanh nghiệp và cá nhân. Được phát triển bởi SenPlus">
    <meta name="author" content="SenPlus">

    <title>SenPlus | Nền tảng khảo sát online</title>

    <!--begin::Fonts -->
    <script src="{{ url('frontend/js/webfont.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                "families": ['Open Sans:300,400,500,600,700', 'Roboto:300,400,500,600,700']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Fonts -->

    <!--begin::Global Theme Styles -->
    <link rel="stylesheet" href="{{ url('frontend/css/base/style.bundle.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/base/azstyle.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/skins/header/base/light.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/skins/header/menu/light.css') }}">
    <!--end::Global Theme Styles -->
</head>

<body class="kt-header--fixed kt-footer--fixed">

    <!-- begin:: Page -->
    <div class="kt-grid kt-grid--hor kt-grid--root">
        <!-- begin:: Wrapper -->
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

            <!-- begin:: Header -->
            <div id="kt_header" class="kt-header kt-grid__item kt-header--fixed">

                <div class="flex-jc-sb mw12 mx-auto">
                    <!-- begin:: Header Menu -->
                    <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
                    <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
                        <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">
                            <ul class="kt-menu__nav ">
                                <li class="kt-menu__item  kt-menu__item--rel"><a href="{{ session()->has(\App\Helpers::SESSION_NAME) ? route('frontend.home') : route('frontend.index') }}" class="kt-menu__link"><span class="kt-menu__link-text">Trang chủ</span></a></li>
                                <li class="kt-menu__item  kt-menu__item--rel"><a href="{{ route('frontend.home') }}" class="kt-menu__link"><span class="kt-menu__link-text">Thành viên</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- end:: Header Menu -->

                    @if (session()->has(\App\Helpers::SESSION_NAME))
                    <!-- begin:: Header Topbar -->
                    <div class="kt-header__topbar">
                        <!--begin: User Bar -->
                        <div class="kt-header__topbar-item kt-header__topbar-item--user">
                            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
                                <div class="kt-header__topbar-user">
                                    <span class="kt-header__topbar-welcome kt-hidden-mobile">Xin chào,</span>
                                    <span class="kt-header__topbar-username kt-hidden-mobile">{{ session()->get(\App\Helpers::SESSION_NAME)->name }}</span>

                                    <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                    <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold">{{ \Illuminate\Support\Str::limit(session()->get(\App\Helpers::SESSION_NAME)->name, 1, '') }}</span>
                                </div>
                            </div>
                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">

                                <!--begin: Head -->
                                <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url({{ url('frontend/images/bg-1.jpg') }})">
                                    <div class="kt-user-card__avatar">
                                        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                        <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">{{Str::limit(\App\Helpers::getCookieLogin(), 1, '')}}</span>
                                    </div>
                                    <div class="kt-user-card__name">
                                        {{ \App\Helpers::getCookieLogin() }}
                                    </div>
                                    <div class="kt-user-card__badge">
                                        <span class="btn btn-success btn-sm btn-bold btn-font-md">{{(now()->hour < 13) ? 'Chào buổi sáng' : (now()->hour < 18) ? 'Chào buổi chiều' : 'Chào buổi tối'}}</span>
                                    </div>
                                </div>

                                <!--end: Head -->

                                <!--begin: Navigation -->
                                <div class="kt-notification">
                                    <div class="kt-notification__custom">
                                        <a href="{{ route('frontend.logout') }}" class="btn btn-label-brand btn-sm btn-bold">Thoát</a>
                                    </div>
                                </div>

                                <!--end: Navigation -->
                            </div>
                        </div>

                        <!--end: User Bar -->
                    </div>
                    <!-- end:: Header Topbar -->
                    @endif

                </div>

            </div>
            <!-- end:: Header -->

            @if (session('general_message'))
                <div class="alert alert-info">{{session('general_message')}}</div>
            @endif

            <!-- begin:: Main Content -->
            @yield('content')
            <!-- begin:: Main Content -->

            <!-- begin:: Footer -->
            <div class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop">
                <div class="flex-jc-sb mw12 mx-auto">
                    <div class="kt-footer__copyright">
                        2020&nbsp;©&nbsp;<a href="{{ url('/') }}" target="_blank" class="kt-link">SenPlus</a>
                    </div>
                    <div class="kt-footer__menu">
                        <a href="#" target="_blank" class="kt-footer__menu-link kt-link">Power by SenPlus</a>
                        <a href="#" target="_blank" class="kt-footer__menu-link kt-link">Team</a>
                        <a href="#" target="_blank" class="kt-footer__menu-link kt-link">Contact</a>
                    </div>
                </div>
            </div>
            <!-- end:: Footer -->

        </div>
        <!-- end:: Wrapper -->

    </div>
    <!-- end:: Page -->
    <script src="{{ url('heroic/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('heroic/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    @yield('after_scripts')
</body>


</html>