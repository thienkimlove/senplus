<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="content-language" content="vi"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=5"/>
    @if (!isset($isStyleBlog))
        <title data-react-helmet="true">{{ isset($title)? $title : 'Khảo sát và đánh giá môi trường Văn hoá doanh nghiệp' }}</title>
    @endif
    <link rel="shortcut icon" href="/frontend/assets/img/favicon.png"/>
    <link rel="icon" href="/frontend/assets/img/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="/frontend/assets/img/favicon.png" type="image/vnd.microsoft.icon"/>
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap.min2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap-datetimepicker2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap-select.css">
    @if (isset($isStyleSurvey) && $isStyleSurvey)
        <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleSurveyAction.css">
    @elseif (isset($isStyleBlog) && $isStyleBlog)
        <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleArticleDetail.css">
    @else
        <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleHomeUser.css">
    @endif

    @yield('after_styles')

    @yield('after_head')

</head>
<body class="">

@include('frontend.partials.home_header')

@if (isset($isStyleBlog) && $isStyleBlog)
    @include('frontend.partials.blog_second_menu')
@else
    @include('frontend.partials.second_menu')
@endif

@include('frontend.flash-message')
@yield('content')
@include('frontend.partials.home_footer')
@if (isset($isStyleBlog) && $isStyleBlog)
    @include('frontend.partials.home_popup')
@else
    @include('frontend.partials.home_popup')
@endif
<script src="/frontend/assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="/frontend/assets/js/bootstrap.min2.js" type="text/javascript"></script>
<script src="/frontend/assets/js/moment.js" type="text/javascript"></script>
<script src="/frontend/assets/js/bootstrap-datetimepicker.min2.js" type="text/javascript"></script>
<script src="/frontend/assets/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="/frontend/assets/js/Chart.min.js"></script>
<script src="/frontend/assets/js/page_all.js?v=2" type="text/javascript"></script>
<script src="/frontend/assets/js/index.js?v=2" type="text/javascript"></script>
@yield('after_scripts')
</body>
</html>