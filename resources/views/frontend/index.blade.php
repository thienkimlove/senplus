@extends('frontend.layout')

@section('after_head')
    <title data-react-helmet="true">Home</title>
@endsection


@section('content')
    <div class="wrapper">
        <div class="contain pa">


            <div class="box loginBox">
                <form action="{{ route('frontend.post_login') }}" method="POST" id="loginForm" class="active">
                    {{ csrf_field() }}
                    <div class="topForm">
                        <h1 class="smLogo"><img src="/frontend/assets/img/logo-sm.png" alt="" class="imgFull"></h1>
                        <div class="txt">Hệ thống đánh giá văn hóa doanh nghiệp</div>
                    </div>

                    <div class="btnGroup twoBtn">
                        <div class="txtBlue">Đăng nhập tài khoản nhanh</div>
                        <a href="{{ route('frontend.login_facebook') }}" class="btnFb" title="Đăng nhập bằng Facebook" aria-label="Đăng nhập bằng Facebook">
                            <img src="/frontend/assets/img/i_fb_blue.png" alt="" class="imgFull">
                        </a>
                        <a href="{{ route('frontend.login_google') }}" class="btnGG" title="Đăng nhập bằng Google" aria-label="Đăng nhập bằng Google">
                            <img src="/frontend/assets/img/i_gg.png" alt="" class="imgFull">
                        </a>
                    </div>

                    <div id="error" class="warning {{ count($errors) ? 'showWarning' : '' }}">
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
                        <input type="email" placeholder="Email" class="email" name="email" value="{{ old('email') }}" id="email">
                    </div>
                    <div class="form-group">
                        <input type="password" placeholder="Mật khẩu 6 kí tự" class="password" name="password" id="password">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" class="checkbox" checked> Duy trì đăng nhập
                        <a href="{{ route('frontend.forgot_pass') }}" class="forgetPass" title="Quên mật khẩu" aria-label="Forget Password">Quên mật khẩu?</a>
                    </div>
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
                    <img src="/frontend/assets/img/btn_plus.png" alt="" class="imgFull"></a>
                <a href="javascript:void(0)" class="closeBtn pa showHidePopup" title="Đóng lại" aria-label="Close">
                    <img src="/frontend/assets/img/i_x.png" alt="" class="imgFull">
                </a>
                <div class="title">HỆ THỐNG ĐÁNH GIÁ <br> VĂN HOÁ DOANH NGHIỆP</div>
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
@endsection


@section('after_scripts')
    <script>
        $(function(){
            $('#btnLogin').click(function(){
                let email = $('#email').val();
                let pass = $('#password').val();
                let errorEle = $('#error');

                if (!email || !pass) {
                    errorEle.html('Xin kiểm tra lại thông tin nhập vào!')
                        .removeClass('showWarning')
                        .addClass('showWarning');
                    return false;
                }

                $('form#loginForm').submit();

                return false;
            });
        });
    </script>
@endsection