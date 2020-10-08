@extends('frontend_store.layout')

@section('content')
    <div class="wrapper flex-between">
        <header>
            <h1 class="logo"><img src="{{ url('frontend/assets/img/logo5.png') }}" alt=""></h1>
        </header>
        <div class="leftSide">
            <h3 class="title">HỆ THỐNG ĐÁNH GIÁ VĂN HOÁ DOANH NGHIỆP</h3>
            <div class="content">
                <p><strong>CAS (Culture Assement System)</strong> - Hệ thống mạnh mẽ với tính năng linh hoạt cao giúp doanh nghiệp đo lường và củng cố văn hoá riêng biệt.</p>
                <p>Hệ thống tích hợp sẵn các bộ quy chuẩn cho việc quản trị linh hoạt theo các mô hình đa dạng của từng công ty, là công cụ hỗ trợ hiệu quả của các CEO trong việc xây dựng văn hóa phù hợp và đạt được sự đồng thuận cao cho doanh nghiệp của mình.</p>
                <p>Nhanh chóng và thực chiến - Cung cấp góc nhìn đa chiều trong việc nhận diện và thống nhất ý chí - Giải pháp hiệu quả.</p>
                <p>Chúng tôi kỳ vọng đưa sản phẩm này đến với cộng đồng thương hiệu Việt uy tín, giúp họ tạo lập được lợi thế cạnh tranh và nâng cao hiệu quả hoạt động của mình.</p>
                <p>Để trong một cộng đồng khoẻ mạnh, bạn sẽ trở nên ưu tú hơn!</p>
            </div>
        </div>
        <div class="rightSide">
            <h3 class="title">
                <a href="javascript:void(0)" class="tab tabLogin active" title="Đăng nhập" data-content="#loginForm">Đăng nhập</a> | <a href="javascript:void(0)" class="tab tabRegister" title="Đăng ký" data-content="#registerForm">Đăng Ký</a>
            </h3>
            <form action="{{ route('frontend.post_login') }}"
                  method="POST"
                  id="loginForm"
                  class="{{ $showReg ? '' : 'active' }}">
                <div class="form-group">
                    <input id="login_email" name="login" type="text" placeholder="Nhập tài khoản">
                    {{ csrf_field() }}
                </div>
                <div class="form-group">
                    <input id="login_pass" name="password" type="password" placeholder="Nhập mật khẩu">
                </div>
                <div id="login_error" style="display: {{ count($errors) ? 'visible' : 'hidden' }}" class="error">* Cần nhập đầy đủ thông tin</div>
                <a id="btnLogin" href="javascript:void(0)">Đăng nhập</a>
                {{--<div>--}}
                    {{--@if (count($errors))--}}
                        {{--<ul>--}}
                            {{--@foreach($errors->all() as $error)--}}
                                {{--<li>{{ $error }}</li>--}}
                            {{--@endforeach--}}
                        {{--</ul>--}}
                    {{--@endif--}}
                {{--</div>--}}
            </form>
            <form action="{{ route('frontend.post_reg') }}"
                  method="POST"
                  id="registerForm"
                  class="{{ $showReg ? 'active' : '' }}">
                <div class="form-group">
                    <input type="text" name="name" id="reg_name" placeholder="Nhập họ và tên">
                </div>
                <div class="form-group">
                    {{ csrf_field() }}
                    <input type="email" name="login" id="reg_email" placeholder="Nhập tài khoản (Email/Username)">
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="reg_pass" placeholder="Nhập mật khẩu">
                </div>
                <div id="reg_error" style="display: {{ count($errors) ? 'visible' : 'hidden' }}" class="error">* Cần nhập đầy đủ thông tin</div>

                <a id="btnRegister" href="javascript:void(0)" title="Đăng ký">Đăng ký</a>
            </form>
        </div>
    </div>
@endsection

@section('after_scripts')
    <script>
        $(function(){
            $('#btnLogin').click(function(){
                let email = $('#login_email').val();
                let pass = $('#login_pass').val();
                let errorEle = $('#login_error');

                if (!email || !pass) {
                    errorEle.show();
                    return false;
                }

                $('form#loginForm').submit();

                return false;
            });
            $('#btnRegister').click(function(){
                let name = $('#reg_name').val();
                let email = $('#reg_email').val();
                let pass = $('#reg_pass').val();
                let errorEle = $('#reg_error');

                if (!email || !pass || !name) {
                    errorEle.show();
                    return false;
                }

                $('form#registerForm').submit();

                return false;
            });
        });
    </script>
@endsection
