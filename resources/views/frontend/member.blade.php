@extends('frontend.layout')

@section('before_header')
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrapv4.5.min.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap-select.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleSurveyAction.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleSurveyAction.css">

    <title data-react-helmet="true">Danh sách thành viên</title>

    <script src="/frontend/assets/js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/page_all.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/page_result.js" type="text/javascript"></script>
@endsection    

@section('content')
    <body class="bodyHomeUser">
    @include('frontend.header_user')

    <main>
        <div class="sortInfoBlock">
            <div class="fixCen">
                <div class="avatar">
                    <img src="{{ $company->logo ? url($company->logo) : '/frontend/assets/img/demo-logo1.jpg' }}" alt="" class="imgFull">
                </div>
                <div class="txt">
                    {{ $company->name }}
                </div>
            </div>
        </div>
        <div class="topBlock">
            <div class="fixCen hasBefore" id="filterMember">
                <h2 class="title">Danh sách thành viên</h2>
                <a href="javascript:void(0)" class="myBtn addNewUser" title="Thêm mới">+ Thêm mới</a>
                <form action="{{ route('frontend.member') }}" method="GET" class="searchUser">
                    <input type="text" name="q" placeholder="Tên/email" id="inputSearchDemo">
                </form>
            </div>
        </div>
        <div class="editSurveyBlock editBlock">
            <div class="fixCen">
                <div class="box">
                    <table class="tableList tableListMember">
                        <thead>
                        <tr>
                            <td>STT</td>
                            <td>
                                Tên <a href="javascript:void(0)" class="btnSort" title="Sắp xếp"></a>
                            </td>
                            <td>Email</td>
                            <td>
                                <select name="" multiple class="multiSeclect" id="seclectDepartment">
                                    <option class="option" value="0">Bộ phận</option>
                                    <option class="option" value="1">Kinh doanh</option>
                                    <option class="option" value="2">Nội chính</option>
                                    <option class="option" value="3">Tất cả</option>
                                </select>
                            </td>
                            <td>
                                <select name="" multiple class="multiSeclect" id="seclectPosition">
                                    <option class="option" value="0">Vị trí</option>
                                    <option class="option" value="1">Giám đốc</option>
                                    <option class="option" value="2">Trưởng phòng</option>
                                    <option class="option" value="3">Nhân viên</option>
                                </select>
                            </td>
                            <td>
                                <select name="" multiple class="multiSeclect" id="seclectSeniority">
                                    <option class="option" value="0">Thâm niên</option>
                                    <option class="option" value="1">< 1 năm</option>
                                    <option class="option" value="2">< 3 năm</option>
                                    <option class="option" value="3">> 5 năm </option>
                                </select>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($customers as $index => $customer)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>
                                <a href="{{ route('frontend.personal').'?id='.$customer->id }}" class="link" title="Tên thành viên">
                                    {{ $customer->name }}
                                </a>
                                <a href="{{ route('frontend.detail').'?id='.$customer->id }}" class="btnEditMember" title="Sửa thông tin"></a>
                            </td>
                            <td>{{ $customer->email }}</td>
                            <td>Kinh doanh</td>
                            <td>Nhân viên</td>
                            <td>1 -3 </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @include('frontend.pagination', ['paginate' => $customers])
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
                $('#CorInfo').submit();
                return false;
            });
        });
    </script>
@endsection