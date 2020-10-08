@extends('frontend.layout')

@section('before_header')
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrapv4.5.min.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleIndex.css">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title data-react-helmet="true">Index</title>

    <script src="/frontend/assets/js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/bootstrap4.5.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/page_all.js" type="text/javascript"></script>
@endsection

@section('content')
    <body class="bodyIndex">
    <div class="wrapper">
        <div class="contain pa">
            <div class="box loginBox">
                <form action="{{ route('frontend.post_login') }}" method="POST" id="loginForm" class="active">
                    {{ csrf_field() }}
                    <div class="topForm">
                        <h1 class="smLogo"><img src="/frontend/assets/img/logo-sm.png" alt="" class="imgFull"></h1>
                        <div class="txt">Hệ thống đánh giá văn hóa doanh nghiệp</div>
                    </div>
                    <!--Khi cần show lỗi thì anh add class showWarning vào div warning dưới đây-->
                    <div id="login_error" class="warning {{ count($errors) ? 'showWarning' : '' }}">
                        Email hoặc Mật khẩu không đúng!
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Tài khoản" class="email" id="login_email" name="login">
                    </div>
                    <div class="form-group">
                        <input type="password" placeholder="Mật khẩu 6 kí tự" class="password" id="login_pass" name="password">
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<input type="checkbox" class="checkbox" checked /> Duy trì đăng nhập--}}
                        {{--<a href="{{ route('frontend.forgot_pass') }}" class="forgetPass" title="Quên mật khẩu" aria-label="Forget Password">Quên mật khẩu?</a>--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <div class="noAccount">Chưa có tài khoản? <a href="{{ route('frontend.register') }}" class="registerLink" title="Đăng ký" aria-label="Register">Đăng ký</a></div>
                        <button id="btnLogin" type="button">Đăng nhập</button>
                    </div>
                </form>
                <div class="btnGroup">
                    <a href="javascript:void(0)" class="btnFb" title="Fanpage" aria-label="Fanpage">
                        <img src="/frontend/assets/img/i_fb.png" alt="" class="imgFull">
                    </a>
                    <a href="javascript:void(0)" class="btnFb" title="Messenger" aria-label="Messenger">
                        <img src="/frontend/assets/img/i_mes.png" alt="" class="imgFull">
                    </a>
                    <a href="javascript:void(0)" class="btnFb" title="Youtube" aria-label="Youtube">
                        <img src="/frontend/assets/img/i_youtube.png" alt="" class="imgFull">
                    </a>
                </div>
            </div>
            <div class="box box_right">
                <a href="javascript:void(0)" class="openBtn pa showHidePopup" title="" aria-label="Open">
                    <img src="/frontend/assets/img/btn_plus.png" alt="" class="imgFull">
                </a>
                <a href="javascript:void(0)" class="closeBtn pa showHidePopup" title="Đóng lại" aria-label="Close">
                    <img src="/frontend/assets/img/i_x.png" alt="" class="imgFull">
                </a>
                <div class="title">HỆ THỐNG ĐÁNH GIÁ VĂN HOÁ DOANH NGHIỆP</div>
                <div class="txt_intro">
                    <strong>CAS (Culture Assement System)</strong> - Hệ thống mạnh mẽ với tính năng linh hoạt cao giúp doanh nghiệp đo lường và củng cố văn hoá riêng biệt.
                    <br>
                    Tích hợp sẵn các bộ quy chuẩn cho việc quản trị linh hoạt theo các mô hình đa dạng của từng công ty, lCAS là công cụ hỗ trợ hiệu quả của các CEO trong việc xây dựng văn hóa phù hợp và đạt được sự đồng thuận cao cho doanh nghiệp của mình.
                    <br>
                    <ul>
                        <li>
                            Nhanh chóng và thực chiến
                        </li>
                        <li>
                            Góc nhìn đa chiều cho nhận diện và thống nhất ý chí
                        </li>
                        <li>
                            Giải pháp hiệu quả.
                        </li>
                    </ul>
                    Chúng tôi kỳ vọng đưa sản phẩm này đến với cộng đồng thương hiệu Việt uy tín, giúp họ tạo lập được lợi thế cạnh tranh và nâng cao hiệu quả hoạt động của mình.
                    <br>
                    <p>
                        <strong><i>Để trong một cộng đồng khoẻ mạnh,</i></strong> <br>
                        <strong><i>bạn sẽ trở nên ưu tú hơn!</i></strong>
                    </p>
                </div>
                <div class="bottom">
                    <div class="leftInfo">
                        <div class="icon">
                            <img src="/frontend/assets/img/favicon_grey.png" alt="" class="imgFull">
                        </div>
                        Sản phẩm phát triển bởi Senplus
                    </div>
                    <div class="rightInfo">
                        <strong>0902 088 246</strong>
                        Gọi ngay để trải nghiệm
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
@endsection

@section('after_scripts')
    <script>
        $(function(){
            $('#btnLogin').click(function(){
                let email = $('#login_email').val();
                let pass = $('#login_pass').val();
                let errorEle = $('#login_error');

                if (!email || !pass) {
                    errorEle.removeClass('showWarning').addClass('showWarning');
                    return false;
                }

                $('form#loginForm').submit();

                return false;
            });
        });
    </script>
@endsection