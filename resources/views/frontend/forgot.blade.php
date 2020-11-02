@extends('frontend.layout')

@section('after_head')
    <title data-react-helmet="true">Quên mật khẩu</title>
@endsection


@section('content')
    <div class="wrapper">
        <div class="contain pa">
            <div class="box loginBox">
                <form action="{{ route('frontend.post_forgot') }}" id="forgotForm" method="POST" class="active">
                    {{ csrf_field() }}
                    <div class="topForm">
                        <h1 class="smLogo"><img src="/frontend/assets/img/logo-sm.png" alt="" class="imgFull"></h1>
                        <div class="txt">Hệ thống đánh giá văn hóa doanh nghiệp</div>
                    </div>
                    <br>
                    <br>
                    <div id="error" class="warning {{ count($errors) ? 'showWarning' : '' }}" style="margin-top: 0;height: 19px;">
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
                    {{--<div class="form-group">--}}
                        {{--<div class="txtBlue"><a href="{{ route('frontend.index') }}">Đăng nhập</a></div>--}}
                        {{--<div class="txtBlue"><a href="{{ route('frontend.register') }}">Đăng ký</a></div>--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <div class="txtBlue">Quên mật khẩu ?</div>
                    </div>
                    <div class="form-group">
                        <input type="email" placeholder="Email" class="email" name="email" id="email" value="{{ old('email') }}">
                    </div>
                    <div class="txtNote">Nhập email đã đăng kí để nhận mật khẩu mới</div>
                    <div class="form-group">
                        <button id="btnSend" type="button">Gửi</button>
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
        </div>
    </div>
@endsection


@section('after_scripts')
    <script>
        $(function(){
            $('#btnSend').click(function(){
                let email = $('#email').val();
                let errorEle = $('#error');

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