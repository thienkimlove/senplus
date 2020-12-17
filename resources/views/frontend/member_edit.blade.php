@extends('frontend.layout_home')

@section('content')
    <main>
        @include('frontend.partials.sort_block')
        <div class="searchBlock">
            <div class="fixCen hasBefore">
                @if (\App\Helpers::currentFrontendUserIsManager())                
                    <a href="{{ route('frontend.member_create') }}" class="myBtn addNewUser" title="Thêm mới">+ Thêm mới</a>
                @endif
                <form action="" class="searchUser">
                    <input type="text" placeholder="Tìm kiếm" id="inputSearchDemo">
                </form>
            </div>
        </div>
        <div class="editInfoBlock editBlock">
            <div class="fixCen">
                <div class="box">
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
                    <form action="{{ route('frontend.post_member_edit') }}" method="POST" id="userData">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $customer->id }}" name="customer_id">
                        <div class="form-group">
                            <label class="left" for="userName">Họ tên</label>
                            <input type="text" class="right" name="name" id="userName" value="{{ $customer->name }}" style="font-weight: bold;">
                        </div>
                        <div class="form-group">
                            <label class="left" for="gender">Giới tính</label>
                            <div class="right checkBoxGroup" id="gender" data-show="#showGender">
                                <label><input type="radio" name="gender" {{  $customer->gender == 'male' ? 'checked' : '' }} value="male" class="male">Nam</label>
                                <label><input type="radio" name="gender" {{  $customer->gender == 'female' ? 'checked' : '' }} value="female" class="female">Nữ</label>
                            </div>
                        </div>

                        @if ($company->filters)
                            @foreach ($company->filters as $filter)
                                <div class="form-group">
                                    <label class="left" for="filter_{{ $filter->id }}">{{ $filter->name }}</label>
                                    <select class="right" name="filter_{{ $filter->id }}" id="filter_{{ $filter->id }}">
                                        @foreach ($filter->options as $option)
                                            <option {{ \App\Helpers::getCustomerFilterValue($customer, $filter) == $option['attr_value'] ? 'selected' : '' }} value="{{ $option['attr_value'] }}">{{ $option['attr_value'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        @endif

                        @if ($customer->level != \App\Helpers::FRONTEND_ADMIN_LEVEL)

                        <div class="form-group">
                            <label class="left" for="showPermission">Phân quyền</label>
                            <div class="right checkBoxGroup" id="permission" data-show="#showPermission">
                                <label><input type="radio" {{  $customer->level == \App\Helpers::FRONTEND_USER_LEVEL ? 'checked' : '' }} name="level" value="{{ \App\Helpers::FRONTEND_USER_LEVEL }}" class="female">Nhân viên</label>
                                <label><input type="radio" name="level" {{  $customer->level == \App\Helpers::FRONTEND_MANAGER_LEVEL ? 'checked' : '' }} value="{{ \App\Helpers::FRONTEND_MANAGER_LEVEL }}" class="male">Quản lý</label>
                            </div>
                        </div>
                        @endif
                        <div class="form-group showBtn">
                            <button type="button" id="cancelForm" data-url="{{ route('frontend.member_detail').'?id='.$customer->id }}">Bỏ qua</button>
                            <button type="button" id="submitForm" class="myBtn btnSave">Lưu</button>
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
            $('#cancelForm').click(function(){
                window.location.href =  $(this).attr('data-url');
            });

            $('#submitForm').click(function(){
                $('#userData').submit();
                return false;
            });
        });
    </script>
@endsection
