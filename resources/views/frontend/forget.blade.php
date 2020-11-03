@extends('frontend.layout')

@section('after_head')
    <title data-react-helmet="true">Quên mật khẩu</title>
@endsection


@section('content')
    <div class="wrapper">
        <div class="contain pa">
            <div class="box loginBox">
                <form action="{{ route('frontend.post_forget') }}" id="forgetForm" method="POST" class="active">
                    {{ csrf_field() }}
                    <div class="topForm">
                        <h1 class="smLogo"><img src="/frontend/assets/img/logo-sm.png" alt="" class="imgFull"></h1>
                        <div class="txt">Hệ thống đánh giá văn hóa doanh nghiệp</div>
                    </div>
                    <br><br>
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
                    <div class="form-group">
                        <div class="txtBlue">Nhập mật khẩu mới</div>
                    </div>
                    <div class="form-group">
                        {{--<div class="txtNote">Nhập mật khẩu mới</div>--}}
                        <input type="password" placeholder="Mật khẩu mới" class="password" name="password" id="password">
                        <input type="hidden" name="forget_token" value="{{ $token }}">
                    </div>

                    <div class="form-group">
                        {{--<div class="txtNote">Nhập lại mật khẩu mới</div>--}}
                        <input type="password" placeholder="Nhập lại mật khẩu mới" class="password" name="password_confirm" id="password_confirm">
                    </div>
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
    </div>
@endsection


@section('after_scripts')

    <script>
        $(function(){
            $('#btnSend').click(function(){
                let pass = $('#password').val();
                let passConfirm = $('#password_confirm').val();
                let errorEle = $('#error');

                if (!pass || !passConfirm || (pass !== passConfirm)) {
                    errorEle.html('Xin kiểm tra lại thông tin nhập vào!')
                        .removeClass('showWarning')
                        .addClass('showWarning');
                    return false;
                }

                $('form#forgetForm').submit();

                return false;
            });
        });
    </script>
@endsection