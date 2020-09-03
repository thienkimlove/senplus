<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>SenPlus | Đăng nhập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SenPlus, nền tảng khảo sát online. Cung cấp giải pháp cho doanh nghiệp và cá nhân. Được phát triển bởi SenPlus">
    <meta name="author" content="SenPlus">

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
    <link rel="stylesheet" href="{{ url('frontend/css/login-v3.default.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/style.bundle.css') }}">
</head>

<body class="kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
    <!-- begin:: Page -->
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3" id="kt_login">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url({{ url('frontend/images/bg-3.jpg') }});">
                <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                    <div class="kt-login__container">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('frontend/vendor/jquery/jquery.min.js') }}"></script>
    <!-- end:: Page -->
</body>

</html>