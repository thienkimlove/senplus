<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="content-language" content="vi"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=5"/>

    <link rel="shortcut icon" href="{{ url('frontend/assets/img/favicon.png') }}"/>
    <link rel="icon" href="{{ url('frontend/assets/img/favicon.png') }}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{ url('frontend/assets/img/favicon.png') }}" type="image/vnd.microsoft.icon"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ url('frontend/assets/css/bootstrapv4.5.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/assets/css/styleIndex.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title data-react-helmet="true">Index</title>

    <script src="{{ url('frontend/assets/js/jquery-3.5.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('frontend/assets/js/bootstrap4.5.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('frontend/assets/js/page_all.js') }}" type="text/javascript"></script>

</head>
<body class="">

@yield('content')

@yield('after_scripts')
</body>
</html>