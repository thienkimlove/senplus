<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="content-language" content="vi"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=5"/>

    <link rel="shortcut icon" href="/frontend/cas/assets/img/favicon.png"/>
    <link rel="icon" href="/frontend/cas/assets/img/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="/frontend/cas/assets/img/favicon.png" type="image/vnd.microsoft.icon"/>

    <title data-react-helmet="true">{{ isset($title)? $title : 'Khảo sát và đánh giá môi trường Văn hoá doanh nghiệp' }}</title>

    <link rel="stylesheet" type="text/css" href="/frontend/cas/assets/css/bootstrap.min2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/cas/assets/css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="/frontend/cas/assets/css/styleIndex.css">

</head>
<body class="">

@include('frontend.cas.partials.header')

@yield('content')


@include('frontend.cas.partials.footer')
@include('frontend.cas.partials.popup')

<script src="/frontend/cas/assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="/frontend/cas/assets/js/owl.carousel.js" type="text/javascript"></script>
<script src="/frontend/cas/assets/js/index.js" type="text/javascript"></script>

<script>
    $(function(){
        $('#submitRegisterForm').click(function(){

            let name = $('#name');
            let phone = $('#phone');
            let email = $('#email');
            let option = $('#option');
            let position = $('#position');

            let error = $('#error');

            if (name.val() === '' || phone.val() === '' || email.val() ===
                '' || option.val() === '' || position.val() === '') {
                error.show();
            } else {
                error.hide();
                $('#registerForm').submit();
            }

            return false;
        });
    });
</script>

@yield('after_scripts')

</body>
</html>