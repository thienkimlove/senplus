@extends('frontend.layout')

@section('before_header')
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrapv4.5.min.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleIndex.css">
    <title data-react-helmet="true">Đăng ký</title>

    <script src="/frontend/assets/js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/bootstrap4.5.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/page_all.js" type="text/javascript"></script>
@endsection

@section('content')
    <body class="bodyIndex">

    <div class="wrapper" style="background: url('/frontend/assets/img/bg.jpg') center top no-repeat;background-size: 100%;">
        <div class="box loginBox">
            <form action="{{ route('frontend.post_reg') }}" method="POST" id="registerForm" class="active">
                {{ csrf_field() }}
                <div class="topForm">
                    <h1 class="smLogo"><img src="/frontend/assets/img/logo-sm.png" alt="" class="imgFull"></h1>
                    <div class="txt">Hệ thống đánh giá văn hóa doanh nghiệp</div>
                </div>
                <div class="btnGroup twoBtn">
                    <div class="txtBlue">Tạo tài khoản nhanh</div>
                    <a href="javascript:void(0)" class="btnFb" title="Đăng ký bằng Facebook" aria-label="Đăng ký bằng Facebook">
                        <img src="/frontend/assets/img/i_fb_blue.png" alt="" class="imgFull">
                    </a>
                    <a href="javascript:void(0)" class="btnGG" title="Đăng ký bằng Google" aria-label="Đăng ký bằng Google">
                        <img src="/frontend/assets/img/i_gg.png" alt="" class="imgFull">
                    </a>
                </div>
                <div class="hr"><span>hoặc</span></div>
                <!--Khi cần show lỗi thì anh add class showWarning vào div warning dưới đây, ko cần thì bỏ-->
                <div id="reg_error" class="warning {{ count($errors) ? 'showWarning' : '' }}">Email hoặc Mật khẩu không đúng!</div>
                <div class="form-group">
                    <input type="text" placeholder="Họ và tên" class="username" id="reg_name" name="name">
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Tài Khoản" class="email" id="reg_email" name="login">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Mật khẩu 6 kí tự" class="password" id="reg_pass" name="password" autocomplete="new-password">
                </div>
                <div class="form-group fz13px">
                    <input type="checkbox" class="checkbox" checked> Đồng ý với
                    <a href="javascript:void(0)"
                       class="blue"
                       title="Điều khoản"
                       aria-label="Điều khoản"
                       rel="noreferrer">Điều khoản
                    </a> và
                    <a href="javascript:void(0)"
                       class="blue"
                       title="Chính sách bảo mật"
                       aria-label="Chính sách bảo mật"
                       rel="noreferrer">Chính sách bảo mật
                    </a>
                </div>
                <div class="form-group">
                    <div class="noAccount">
                        Đã có tài khoản? <a href="{{ url('/') }}" class="registerLink" title="Đăng nhập" aria-label="Login">Đăng nhập</a>
                    </div>
                    <button id="btnRegister" type="button">Đăng Ký</button>
                </div>
            </form>
        </div>
    </div>


    </body>
@endsection

@section('after_scripts')
    <script>
        $(function(){
            $('#btnRegister').click(function(){
                let name = $('#reg_name').val();
                let email = $('#reg_email').val();
                let pass = $('#reg_pass').val();
                let errorEle = $('#reg_error');

                if (!email || !pass || !name) {
                    errorEle.removeClass('showWarning').addClass('showWarning');
                    return false;
                }

                $('form#registerForm').submit();

                return false;
            });
        });
    </script>
@endsection