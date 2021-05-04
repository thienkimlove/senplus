@extends('frontend.cas.layout')


@section('content')
    <main>
        <section class="section pr productPage" id="section1">
            <div class="fixCen">
                <div class="leftContent">
                    <quote>Khảo sát Mô hình cạnh tranh</quote>
                    <div class="description">
                        Được phát triển từ các học thuyết về khung năng lực cạnh tranh đang được ứng dụng tại hơn 10.000 doanh nghiệp toàn cầu, khảo sát Mô hình cạnh tranh giúp nhà quản lý:
                    </div>
                    <ul class="listHelp">
                        <li>Nhận diện mô hình cạnh tranh hiện tại</li>
                        <li>Xác định mô hình cạnh tranh trong tương lai</li>
                        <li>Nền tảng xây dựng chiến lược truyền thông nội bộ</li>
                    </ul>
                    <a href="https://casonline.vn/" class="btnSurvey" title="Khảo sát miễn phí" aria-label="Free Survey">Khảo sát miễn phí</a>
                    <a href="javascript:void(0)" class="myBtn" title="Đăng ký" data-popup="#popupRegister" onclick="showPopup($(this))">Đăng ký</a>
                </div>
                <div class="rightContent">
                    <img src="/frontend/cas/assets/img/chart.jpg" alt="" class="imgFull">
                </div>
            </div>
        </section>
        <section class="section pr productPage" id="section4">
            <div class="fixCen">
                <div class="content content2">
                    <div class="banner"><img src="/frontend/cas/assets/img/banner4.jpg" alt="" class="imgFull"></div>
                    <div class="items" id="effect2">
                        <div class="item card4">
                            <div class="card">
                                <a href="javascript:void(0)" class="title" title="Chủ doanh nghiệp">Được xác định theo 2 trục</a>
                                <ul>
                                    <li>Trục Hướng nội - Hướng ngoại</li>
                                    <li>Trục Ổn định - Linh hoạt</li>
                                </ul>
                            </div>
                        </div>
                        <div class="item card5">
                            <div class="card">
                                <a href="javascript:void(0)" class="title" title="Theo 4 mô hình cơ bản">Theo 4 mô hình cơ bản</a>
                                <ul>
                                    <li>Đội nhóm</li>
                                    <li>Tiên phong</li>
                                    <li>Thị trường</li>
                                    <li>Kiểm soát</li>
                                </ul>
                            </div>
                        </div>
                        <div class="item card6">
                            <div class="card">
                                <a href="javascript:void(0)" class="title" title="Loại bỏ mọi đánh giá cảm tính">Loại bỏ mọi đánh giá cảm tính</a>
                                <p>Với các thuật toán được phát triển bởi nhóm nghiên cứu CAS và dữ liệu trả lời từ người dùng, khảo sát sẽ mang đến những
                                    <span style="color: #62d7dd;" class="fwb">số liệu trực quan, chính xác</span> nhất về năng lực cạnh tranh cốt lõi của văn hóa doanh nghiệp</p>
                            </div>
                        </div>
                    </div>
                    <h2 class="title">Năng lực cạnh tranh của mỗi doanh nghiệp</h2>
                </div>
            </div>
        </section>
        <section class="section pr productPage" id="section5">
            <div class="fixCen">
                <h2 class="title hasBd tt">Các gói sản phẩm</h2>
                <div class="content">
                    <div class="item">
                        <h3 class="title" title="Free">Free</h3>
                        <div class="sum">
                            <ul>
                                <li>Khách hàng cá nhân</li>
                                <li>01 tài khoản thường</li>
                                <li>01 lần khảo sát</li>
                            </ul>
                        </div>
                        <div class="fee">Miễn phí</div>
                        <a href="https://casonline.vn/inspire" class="myBtn" title="Khảo sát ngay">Khảo sát ngay</a>
                    </div>
                    <div class="item">
                        <h3 class="title" title="CAS 25">CAS 25</h3>
                        <div class="sum">
                            <ul>
                                <li>Phù hợp doanh nghiệp <= 25 người</li>
                                <li>Miễn phí khởi tạo 01 tài khoản admin</li>
                                <li>Tài khoản thường <= 25</li>
                                <li>Thiết lập hệ thống khảo sát chuyên biệt theo cơ cấu tổ chức</li>
                                <li>Đầy đủ tính năng</li>
                                <li>Kết quả lưu trữ trọn đời</li>
                                <li>Đào tạo toàn diện về văn hóa doanh nghiệp và cách thức thực hiện khảo sát</li>
                                <li>Tư vấn chiến lược văn hóa doanh nghiệp với toàn hệ thống</li>
                                <li>Số lần khảo sát: không giới hạn</li>
                            </ul>
                        </div>
                        <div class="fee">20.000.000 <span>vnđ</span></div>
                        <a href="javascript:void(0)" class="myBtn" title="Đăng ký" data-popup="#popupRegister" onclick="showPopup($(this))">Đăng ký</a>
                    </div>
                    <div class="item">
                        <h3 class="title" title="CAS 50">CAS 50</h3>
                        <div class="sum">
                            <ul>
                                <li>Phù hợp doanh nghiệp <= 50 người</li>
                                <li>Miễn phí khởi tạo 01 tài khoản admin</li>
                                <li>Tài khoản thường <= 50</li>
                                <li>Thiết lập hệ thống khảo sát chuyên biệt theo cơ cấu tổ chức</li>
                                <li>Đầy đủ tính năng</li>
                                <li>Kết quả lưu trữ trọn đời</li>
                                <li>Đào tạo toàn diện về văn hóa doanh nghiệp và cách thức thực hiện khảo sát</li>
                                <li>Tư vấn chiến lược văn hóa doanh nghiệp với toàn hệ thống</li>
                                <li>Số lần khảo sát: không giới hạn</li>
                            </ul>
                        </div>
                        <div class="fee">35.000.000 <span>vnđ</span></div>
                        <a href="javascript:void(0)" class="myBtn" title="Đăng ký" data-popup="#popupRegister" onclick="showPopup($(this))">Đăng ký</a>
                    </div>
                    <div class="item">
                        <h3 class="title" title="CAS Preimium">CAS Preimium</h3>
                        <div class="sum">
                            <ul>
                                <li>Phù hợp doanh nghiệp > 50 người</li>
                                <li>Miễn phí khởi tạo 01 tài khoản admin</li>
                                <li>Tài khoản thường <= 50</li>
                                <li>Thiết lập hệ thống khảo sát chuyên biệt theo cơ cấu tổ chức</li>
                                <li>Đầy đủ tính năng</li>
                                <li>Kết quả lưu trữ trọn đời</li>
                                <li>Đào tạo toàn diện về văn hóa doanh nghiệp và cách thức thực hiện khảo sát</li>
                                <li>Tư vấn chiến lược văn hóa doanh nghiệp với toàn hệ thống</li>
                                <li>Số lần khảo sát: không giới hạn</li>
                            </ul>
                        </div>
                        <div class="fee">Liên hệ</div>
                        <a href="javascript:void(0)" class="myBtn" title="Đăng ký" data-popup="#popupRegister" onclick="showPopup($(this))">Đăng ký</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection