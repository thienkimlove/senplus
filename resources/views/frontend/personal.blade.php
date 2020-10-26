@extends('frontend.layout_home')

@section('content')
    
    <main>
        <div class="sortInfoBlock">
            <div class="fixCen">
                <div class="avatar">
                    <img src="{{ \App\Helpers::getCustomerAvatar($customer) }}" alt="" class="imgFull">
                </div>
                <div class="txt">
                    {{ $customer->name }}
                </div>
            </div>
        </div>
        <div class="editInfoBlock editBlock">
            <div class="fixCen">
                <h2 class="title">Thông tin tài khoản</h2>
                @if ($customer->id == auth()->user()->id)
                    <a href="javascript:void(0)" class="btnEdit btnEditHomeUser" data-edit="#CorInfo" title="Chỉnh sửa">
                        <span>Chỉnh sửa</span>
                        <img src="/frontend/assets/img/i_pen.png" alt="" class="imgFull">
                    </a>
                @endif
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
                                <label><input type="checkbox" name="gender" {{  $customer->gender == 'male' ? 'checked' : '' }} value="male" class="male">Nam</label>
                                <label><input type="checkbox" name="gender" {{  $customer->gender == 'female' ? 'checked' : '' }}  value="female" class="female">Nữ</label>
                            </div>
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
                        @if ($customer->id == auth()->user()->id)
                        <div class="form-group">
                            <label class="left" for="password">* Mật khẩu</label>
                            <input type="password" name="password" class="right" id="password" value="" disabled>
                        </div>
                        @endif
                        <div class="form-group">
                            <button type="button" onclick="window.location.reload(); return false;">Bỏ qua</button>
                            <button type="button" class="myBtn btnSave">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
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
