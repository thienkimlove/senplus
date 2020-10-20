@extends('frontend_store_2.layout')

@section('before_header')
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap.min2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap-datetimepicker2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleHomeUser.css">

    <title data-react-helmet="true">Hồ sơ doanh nghiệp</title>

    <script src="/frontend/assets/js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/bootstrap.min2.js" type="text/javascript"></script>
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
                    <img src="{{ $company->logo ? url($company->logo) : '/frontend/assets/img/demo-logo1.jpg' }}" alt="" class="imgFull">
                </div>
                <div class="txt">
                    {{ $company->name }}
                </div>
            </div>
        </div>
        <div class="editInfoBlock editBlock">
            <div class="fixCen">
                <h2 class="title">Thông tin doanh nghiệp</h2>
                <a href="javascript:void(0)" class="btnEdit" data-edit="#CorInfo" title="Chỉnh sửa"><span>Chỉnh sửa</span>
                    <img src="/frontend/assets/img/i_pen.png" alt="" class="imgFull">
                </a>
                <div class="box">
                    <form action="{{ route('frontend.post_profile') }}" method="POST" id="CorInfo" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company->id }}" />
                        <div class="form-group">
                            <label class="left" for="nameOfCor">* Tên doanh nghiệp</label>
                            <input type="text" name="name" class="right" id="nameOfCor" value="{{ $company->name }}" disabled style="font-weight: bold;">
                        </div>
                        <div class="form-group">
                            <label class="left" for="nameOfBrand">Tên thương hiệu</label>
                            <input type="text" name="brand_name" class="right" id="nameOfBrand" value="{{ $company->brand_name }}" disabled>
                        </div>
                        <div class="form-group">
                            <label class="left" for="mainOffice">Trụ sở chính</label>
                            <input type="text" name="main_address" class="right" id="mainOffice" value="{{ $company->main_address }}" disabled>
                        </div>
                        <div class="form-group">
                            <label class="left" for="phoneNumber">* Số điện thoại</label>
                            <input type="tel" name="contact_phone" class="right" id="phoneNumber" value="{{ $company->contact_phone }}" disabled>
                        </div>
                        <div class="form-group db">
                            <div class="current">
                                <label class="left" for="logoOfCor">* Logo</label>
                                @if ($company->logo)
                                    <div class="imgThumb right">
                                        <img src="{{ url($company->logo) }}" />
                                    </div>
                                @endif
                            </div>
                            <div class="edit disabled" id="editLogoCor">
                                <label class="left" for="uploadBlock">* Logo</label>
                                <div id="uploadBlock" class="right">
                                    <p><strong>Cập nhật logo doanh nghiệp</strong></p>
                                    <p>
                                        Logo sẽ hiển thị với tất cả mọi người, <br>Logo được hiển thị trên các hồ sơ của doanh nghiệp
                                    </p>
                                    <p>
                                        <input type="file" id="btnEditImg" name="logo"/>
                                        <span>File ảnh không quá 1mb</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="left" for="businessSector">* Lĩnh vực kinh doanh</label>
                            <select type="text" name="business_field_id" class="right" id="businessSector" disabled>
                                @foreach (\App\Models\Business::all() as $content)
                                    <option value="{{ $content->id }}">{{ $content->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="left" for="numberOfStaff">* Số lượng nhân viên</label>
                            <select type="text" name="employee_number_id" class="right" id="numberOfStaff" disabled>
                                @foreach (\App\Models\Employee::all() as $content)
                                    <option value="{{ $content->id }}">{{ $content->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="left" for="averageRevenue">Doanh thu bình quân năm</label>
                            <select type="text" name="average_income_id" class="right" id="averageRevenue" disabled>
                                @foreach (\App\Models\Income::all() as $content)
                                    <option value="{{ $content->id }}">{{ $content->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="left" for="totalResources">Tổng nguồn vốn</label>
                            <select type="text" id="total_fund_id" class="right" id="totalResources" disabled>
                                @foreach (\App\Models\Fund::all() as $content)
                                    <option value="{{ $content->id }}">{{ $content->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{--<div class="form-group">--}}
                            {{--<label class="left" for="totalResources">Phân loại doanh nghiệp</label>--}}
                            {{--<input type="text" class="right" value="Tự động theo công thức" disabled>--}}
                        {{--</div>--}}
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