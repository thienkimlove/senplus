@extends('frontend.layout')

@section('after_head')
    <title data-react-helmet="true">Đăng ký</title>
@endsection


@section('content')
    <div class="wrapper">
        <div class="contain pa">
            <div class="box loginBox">
                <form action="{{ route('frontend.post_reg') }}" id="registerForm" method="POST" class="active">
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
                        <a href="{{ route('frontend.login_google') }}" class="btnGG" title="Đăng ký bằng Google" aria-label="Đăng ký bằng Google">
                            <img src="/frontend/assets/img/i_gg.png" alt="" class="imgFull">
                        </a>
                    </div>
                    <div class="hr"><span>hoặc</span></div>
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
                        <input type="text" placeholder="Họ và tên" class="username" name="name" id="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <input type="email" placeholder="Email" class="email" name="email" id="email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <input type="password" placeholder="Mật khẩu 6 kí tự" class="password" name="password" id="password">
                    </div>
                    <div class="form-group fz13px">
                        <input type="checkbox" class="checkbox" checked> Đồng ý với
                        <a href="javascript:void(0)" class="blue" title="Điều khoản" aria-label="Điều khoản" target="_blank" rel="noreferrer">Điều khoản</a> và
                        <a href="javascript:void(0)"  class="blue" title="Chính sách bảo mật" aria-label="Chính sách bảo mật" target="_blank" rel="noreferrer">Chính sách bảo mật</a>
                    </div>
                    <div class="form-group">
                        <div class="noAccount">Chưa đã tài khoản? <a href="{{ url('/') }}" class="registerLink" title="Đăng nhập" aria-label="Login">Đăng nhập</a></div>
                        <button id="btnRegister" type="button">Đăng Ký</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('after_scripts')
    <script>
        $(function(){
            $('#btnRegister').click(function(){
                let name = $('#name').val();
                let email = $('#email').val();
                let pass = $('#password').val();
                let errorEle = $('#error');

                if (!email || !pass || !name) {
                    errorEle.html('Xin kiểm tra lại thông tin nhập vào!')
                        .removeClass('showWarning')
                        .addClass('showWarning');
                    return false;
                }

                $('form#registerForm').submit();

                return false;
            });
        });
    </script>
@endsection