@extends('frontend_store_2.layout')

@section('before_header')
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrapv4.5.min.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap-datetimepicker2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleHomeUser.css">

    <title data-react-helmet="true">Thông tin tài khoản</title>

    <script src="/frontend/assets/js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/moment.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/bootstrap-datetimepicker.min2.js" type="text/javascript"></script>

    <script src="/frontend/assets/js/page_all.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/page_homeUser.js" type="text/javascript"></script>
@endsection    

@section('content')
    <body class="bodyHomeUser">
    @include('frontend_store_2.header_user')
    <main>
        <div class="sortInfoBlock">
            <div class="fixCen">
                <div class="avatar">
                    <img src="{{ $customer->avatar? url($customer->avatar) : '/frontend/assets/img/demo-logo1.jpg' }}" alt="" class="imgFull">
                </div>
                <div class="txt">
                    {{ $customer->name }}
                </div>
            </div>
        </div>
        <div class="editInfoBlock editBlock">
            <div class="fixCen">
                <h2 class="title">Thông tin tài khoản</h2>
                <a href="javascript:void(0)" class="btnEdit" data-edit="#CorInfo" title="Chỉnh sửa"><span>Chỉnh sửa</span>
                    <img src="/frontend/assets/img/i_pen.png" alt="" class="imgFull">
                </a>
                <div class="box">
                    <form action="{{ route('frontend.post_personal') }}" method="POST" id="CorInfo" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}" />
                        <div class="form-group">
                            <label class="left" for="nameOfCor">* Tên </label>
                            <input type="text" name="name" class="right" id="nameOfCor" value="{{ $customer->name }}" disabled style="font-weight: bold;">
                        </div>
                        <div class="form-group">
                            <label class="left" for="gender">Giới tính</label>
                            <input type="text" class="right" id="showGender" value="{{ $customer->gender ? \App\Helpers::getGenders()[$customer->gender] : "" }}" disabled>
                            <div class="right checkBoxGroup disabled" id="gender" data-show="#showGender">
                                <label><input type="checkbox" name="gender" value="male" class="male">Nam</label>
                                <label><input type="checkbox" name="gender" class="female">Nữ</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="left" for="email">* Email</label>
                            <input type="email" class="right" name="email" id="email" value="{{ $customer->email }}" disabled>
                        </div>
                        <div class="form-group db">
                            <div class="current">
                                <label class="left" for="logoOfCor">* Avatar</label>
                                <div class="imgThumb right">
                                    <img src="{{ $customer->avatar? url($customer->avatar) : '/frontend/assets/img/logo3.png' }}">
                                </div>
                            </div>
                            <div class="edit disabled" id="editLogoCor">
                                <label class="left" for="uploadBlock">* Avatar</label>
                                <div id="uploadBlock" class="right">
                                    <p><strong>Cập nhật avatar</strong></p>
                                    <p>
                                        <input name="avatar" type="file" id="btnEditImg"/>
                                        <span>File ảnh không quá 1mb</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="left" for="phoneNumber">* Số điện thoại</label>
                            <input type="tel" name="phone" class="right" id="phoneNumber" value="{{ $customer->phone }}" disabled>
                        </div>

                        <div class="form-group">
                            <button type="button">Bỏ qua</button>
                            <button type="button" class="myBtn btnSave">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    @include('frontend_store_2.footer_user')
    </body>
@endsection

@section('after_scripts')
    <script>
        $(function(){
            $('.btnSave').click(function(){
                $('#CorInfo').submit();
                return false;
            });
        });
    </script>
@endsection