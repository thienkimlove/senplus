@extends('frontend_store_2.layout')

@section('before_header')
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrapv4.5.min.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleIndex.css">
    <title data-react-helmet="true">Quên mật khẩu</title>

    <script src="/frontend/assets/js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/bootstrap4.5.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/page_all.js" type="text/javascript"></script>
@endsection

@section('content')
    <body class="bodyIndex">

    <div class="wrapper" style="background: url('/frontend/assets/img/bg.jpg') center top no-repeat;background-size: 100%;">
        <div class="box loginBox">
            <form action="{{ route('frontend.post_forgot') }}" id="forgotForm" method="POST" class="active">
                {{ csrf_field() }}
                <div class="topForm">
                    <h1 class="smLogo"><img src="/frontend/assets/img/logo-sm.png" alt="" class="imgFull"></h1>
                    <div class="txt">Hệ thống đánh giá văn hóa doanh nghiệp</div>
                </div>
                <!--Khi cần show lỗi thì anh add class showWarning vào div warning dưới đây-->
                <div id="forgot_error" class="warning {{ count($errors) ? 'showWarning' : '' }}">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <div class="txtBlue"><a href="{{ route('frontend.index') }}">Đăng nhập</a></div>
                    <div class="txtBlue"><a href="{{ route('frontend.register') }}">Đăng Ký</a></div>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Email" class="email" id="login_email" name="email" value="{{ old('email') }}">
                </div>
                <div class="txtNote">Nhập email đã đăng kí để nhận mật khẩu mới</div>
                <div class="form-group">
                    <button id="btnSend" type="button">Gửi</button>
                </div>
            </form>
            <div class="btnGroup">
                <a href="javascript:void(0)" class="btnFb" title="Fanpage" aria-label="Fanpage"><img src="/frontend/assets/img/i_fb.png" alt="" class="imgFull"></a>
                <a href="javascript:void(0)" class="btnFb" title="Messenger" aria-label="Messenger"><img src="/frontend/assets/img/i_mes.png" alt="" class="imgFull"></a>
                <a href="javascript:void(0)" class="btnFb" title="Youtube" aria-label="Youtube"><img src="/frontend/assets/img/i_youtube.png" alt="" class="imgFull"></a>
            </div>
        </div>
    </div>


    </body>
@endsection

@section('after_scripts')
    <script>
        $(function(){
            $('#btnSend').click(function(){
                let email = $('#login_email').val();
                let errorEle = $('#forgot_error');

                if (!email) {
                    errorEle.html('Xin kiểm tra lại thông tin nhập vào!')
                        .removeClass('showWarning')
                        .addClass('showWarning');
                    return false;
                }

                $('form#forgotForm').submit();

                return false;
            });
        });
    </script>
@endsection