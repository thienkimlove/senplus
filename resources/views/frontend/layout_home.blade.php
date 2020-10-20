<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="content-language" content="vi"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=5"/>

    <link rel="shortcut icon" href="/frontend/assets/img/favicon.png"/>
    <link rel="icon" href="/frontend/assets/img/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="/frontend/assets/img/favicon.png" type="image/vnd.microsoft.icon"/>
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap.min2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap-datetimepicker2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleHomeUser.css">
    @yield('after_head')

</head>
<body class="">
@include('frontend.partials.home_header')
@include('frontend.partials.second_menu')
@include('frontend.flash-message')
@yield('content')
@include('frontend.partials.home_footer')
@include('frontend.partials.home_popup')
<script src="/frontend/assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="/frontend/assets/js/bootstrap.min2.js" type="text/javascript"></script>
<script src="/frontend/assets/js/moment.js" type="text/javascript"></script>
<script src="/frontend/assets/js/bootstrap-datetimepicker.min2.js" type="text/javascript"></script>
<script src="/frontend/assets/js/page_all.js" type="text/javascript"></script>
<script src="/frontend/assets/js/page_homeUser.js" type="text/javascript"></script>
@yield('after_scripts')
</body>
</html>