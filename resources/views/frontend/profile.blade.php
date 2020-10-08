@extends('frontend.layout')

@section('before_header')
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap.min2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap-datetimepicker2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleHomeUser.css">

    <title data-react-helmet="true">Home User</title>

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
                    <img src="/frontend/assets//img/demo-logo1.jpg" alt="" class="imgFull">
                </div>
                <div class="txt">
                    {{ auth()->user()->company->name }}
                </div>
            </div>
        </div>
        <div class="editInfoBlock editBlock">
            <div class="fixCen">
                <h2 class="title">Thông tin doanh nghiệp</h2>
                <a href="{{ route('frontend.edit_profile') }}" class="btnEdit" data-edit="#CorInfo" title="Chỉnh sửa"><span>Chỉnh sửa</span>
                    <img src="/frontend/assets//img/i_pen.png" alt="" class="imgFull">
                </a>
                <div class="box">
                    <form action="" id="CorInfo">
                        <div class="form-group">
                            <label class="left" for="nameOfCor">* Tên doanh nghiệp</label>
                            <input type="text" class="right" id="nameOfCor" value="Công ty cổ phần ABC" disabled style="font-weight: bold;">
                        </div>
                        <div class="form-group">
                            <label class="left" for="nameOfBrand">Tên thương hiệu</label>
                            <input type="text" class="right" id="nameOfBrand" value="Công ty cổ phần ABC" disabled>
                        </div>
                        <div class="form-group">
                            <label class="left" for="mainOffice">Trụ sở chính</label>
                            <input type="text" class="right" id="mainOffice" value="Địa chỉ đầy đỉ" disabled>
                        </div>
                        <div class="form-group">
                            <label class="left" for="phoneNumber">* Số điện thoại</label>
                            <input type="tel" class="right" id="phoneNumber" value="0903xxxxxx" disabled>
                        </div>
                        <div class="form-group db">
                            <div class="current">
                                <label class="left" for="logoOfCor">* Logo</label>
                                <div class="imgThumb right">
                                    <img src="/frontend/assets//img/logo3.png">
                                </div>
                            </div>
                            <div class="edit disabled" id="editLogoCor">
                                <label class="left" for="uploadBlock">* Logo</label>
                                <div id="uploadBlock" class="right">
                                    <p><strong>Cập nhật logo doanh nghiệp</strong></p>
                                    <p>
                                        Logo sẽ hiển thị với tất cả mọi người, <br>Logo được hiển thị trên các hồ sơ của doanh nghiệp
                                    </p>
                                    <p>
                                        <input type="file" id="btnEditImg" name="btnEditImg"/>
                                        <span>File ảnh không quá 1mb</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="left" for="businessSector">* Lĩnh vực kinh doanh</label>
                            <select type="text" class="right" id="businessSector" value="Công ty cổ phần ABC" disabled>
                                <option value="0">Lĩnh vực thông tin và truyền thông</option>
                                <option value="1">Lĩnh vực ngân hàng</option>
                                <option value="2">Lĩnh vực y tế</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="left" for="numberOfStaff">* Số lượng nhân viên</label>
                            <select type="text" class="right" id="numberOfStaff" disabled>
                                <option value="0">50 - 100</option>
                                <option value="1">100 - 500</option>
                                <option value="2">500 - 1000</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="left" for="averageRevenue">Doanh thu bình quân năm</label>
                            <select type="text" class="right" id="averageRevenue" disabled>
                                <option value="0"><= 3 tỷ</option>
                                <option value="1">trên 3 tỷ và <= 10 tỷ</option>
                                <option value="1">trên 10 tỷ và <= 50 tỷ</option>
                                <option value="1">trên 50 tỷ và <= 100 tỷ</option>
                                <option value="1">trên 100 tỷ và <= 200 tỷ</option>
                                <option value="1">trên 200 tỷ và <= 300 tỷ</option>
                                <option value="1">trên 300 tỷ</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="left" for="totalResources">Tổng nguồn vốn</label>
                            <select type="text" class="right" id="totalResources" disabled>
                                <option value="0"><= 3 tỷ</option>
                                <option value="1">trên 3 tỷ và <= 20 tỷ</option>
                                <option value="1">trên 20 tỷ và <= 50 tỷ</option>
                                <option value="1">trên 50 tỷ và <= 100 tỷ</option>
                                <option value="1">trên 100 tỷ</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="left" for="totalResources">Phân loại doanh nghiệp</label>
                            <input type="text" class="right" value="Tự động theo công thức" disabled>
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
    @include('frontend.footer_user')
    </body>
@endsection