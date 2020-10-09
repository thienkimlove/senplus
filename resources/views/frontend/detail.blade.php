@extends('frontend.layout')

@section('before_header')
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap.min2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap-datetimepicker2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleHomeUser.css">

    <title data-react-helmet="true">Dữ liệu người dùng</title>

    <script src="/frontend/assets/js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/bootstrap.min2.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/moment.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/bootstrap-datetimepicker.min2.js" type="text/javascript"></script>

    <script src="/frontend/assets/js/page_all.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/page_homeUser.js" type="text/javascript"></script>
@endsection    

@section('content')
    <body class="bodyHomeUser">
    @include('frontend.header_user')

    <main>
        <div class="sortInfoBlock">
            <div class="fixCen">
                <div class="avatar">
                    <img src="/frontend/assets/img/demo-logo1.jpg" alt="" class="imgFull">
                </div>
                <div class="txt">
                    Tên doanh nghiệp
                </div>
            </div>
        </div>
        <div class="searchBlock">
            <div class="fixCen hasBefore">
                <a href="javascript;void(0)" class="myBtn addNewUser" title="Thêm mới">+ Thêm mới</a>
                <a href="javascript:void(0)" class="btnEdit" data-edit="#userData" title="Chỉnh sửa"><span>Chỉnh sửa</span>
                    <img src="/frontend/assets/img/i_pen.png" alt="" class="imgFull">
                </a>
                <form action="" class="searchUser">
                    <input type="text" placeholder="Tìm kiếm" id="inputSearchDemo">
                    <div id="searchUserBlock">
                        <p><strong>Tìm kiếm theo</strong></p>
                        <div class="selectGroup">
                            <select name="selectDepartment" id="selectDepartment">
                                <option value="0">Bộ phận/ phòng ban</option>
                                <option value="1">Bộ phận/ phòng ban</option>
                                <option value="2">Bộ phận/ phòng ban</option>
                                <option value="3">Bộ phận/ phòng ban</option>
                            </select>
                            <select name="selectPosition" id="selectPosition">
                                <option value="0">Vị trí/ chức vụ</option>
                                <option value="1">Bộ phận/ phòng ban</option>
                                <option value="2">Bộ phận/ phòng ban</option>
                                <option value="3">Bộ phận/ phòng ban</option>
                            </select>
                            <select name="selectSeniority" id="selectSeniority">
                                <option value="0">Thâm niên</option>
                                <option value="1">Bộ phận/ phòng ban</option>
                                <option value="2">Bộ phận/ phòng ban</option>
                                <option value="3">Bộ phận/ phòng ban</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="editInfoBlock editBlock">
            <div class="fixCen">
                <div class="box">
                    <form action="{{ route('frontend.post_detail') }}" method="POST" id="userData">
                        {{ csrf_field() }}
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}" />
                        <div class="form-group">
                            <label class="left" for="userName">Họ tên</label>
                            <input type="text" name="name" class="right" id="userName" value="{{ $customer->name }}" disabled style="font-weight: bold;">
                        </div>
                        <div class="form-group">
                            <label class="left" for="gender">Giới tính</label>
                            <input type="text" class="right" id="showGender" value="{{ $customer->gender ? \App\Helpers::getGenders()[$customer->gender] : "" }}" disabled>
                            <div class="right checkBoxGroup disabled" id="gender" data-show="#showGender">
                                <label><input type="checkbox" name="gender" value="male" class="male">Nam</label>
                                <label><input type="checkbox" name="gender" value="female" class="female">Nữ</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="left" for="email">Email</label>
                            <input type="text" name="email" class="right" id="email" value="{{ $customer->email }}" disabled>
                        </div>

                        <div class="form-group">
                            <label class="left" for="showPermission">Phân quyền</label>
                            <input type="text" class="right" id="showPermission" value=" {{ \App\Helpers::mapLevel()[$customer->level] }}" disabled>
                            <div class="right checkBoxGroup disabled" id="permission" data-show="#showPermission">
                                <label><input type="checkbox" name="level" value="{{ \App\Helpers::FRONTEND_USER_LEVEL }}" class="female">Nhân viên</label>
                                <label><input type="checkbox" name="level" value="{{ \App\Helpers::FRONTEND_MANAGER_LEVEL }}" class="male">Quản lý</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button">Bỏ qua</button>
                            <button type="button" class="myBtn btnSave">Lưu / Tạo mới</button>
                        </div>
                    </form>
                </div>
                <div class="campaignSurvey pr hasBefore">
                    <h2 class="title">Danh sách khảo sát</h2>
                    <nav class="menuBar">
                        <ul>
                            <li>Tổng số khảo sát: <span class="number black">{{ $countTotal }}</span></li>
                            <li>Hoàn thành: <span class="number blue">{{ $countCompleted }}</span></li>
                            <li>Chưa thực hiện: <span class="number red">{{ $countNotCompleted }}</span></li>
                        </ul>
                    </nav>
                    <div class="campaignList">
                        <ul>
                            @foreach ($surveys as $survey)
                                <li>
                                    <a href="javascript:void(0)" class="titleCampaign" title="{{ $survey->name }}" aria-label="Chiến dịch VHDN Celadon">{{ $survey->name }} ({{ $survey->created_at->format('d/m/Y') }})</a>

                                    @if (\App\Helpers::checkIfSurveyHaveResultForUser($survey, $customer->id))
                                        <a href="{{ route('frontend.result').'?id='.$survey->id }}" class="btnWait" title="Xem" aria-label="Xem">Xem</a>
                                    @else

                                    <a href="javascript:void(0)" class="btnWait" title="Chờ" aria-label="Wait">Chờ</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('frontend.footer_user')
    </body>
@endsection

@section('after_scripts')
    <script>
        $(function(){
            $('.btnSave').click(function(){
                $('#userData').submit();
                return false;
            });
        });
    </script>
@endsection