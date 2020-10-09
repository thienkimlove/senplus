<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="content-language" content="vi"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=5"/>

    <meta name="robots" content="noindex">

    <meta name="googlebot" content="noindex">

    <link rel="shortcut icon" href="/frontend/assets/img/favicon.png"/>
    <link rel="icon" href="/frontend/assets/img/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="/frontend/assets/img/favicon.png" type="image/vnd.microsoft.icon"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    @yield('before_header')

</head>
@include('frontend.flash-message')
@yield('content')
@yield('after_scripts')
</html>