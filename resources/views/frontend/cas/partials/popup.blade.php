<div id="popupProfile" class="px">
    <div class="topInfo bdb">
        <a href="javascript:void(0)" class="closePopup pa" title="Đóng" aria-label="Close"><img src="/frontend/cas/assets/img/i_x.png" alt="" class="imgFull"></a>
        <div class="avatar">
            <img src="/frontend/cas/assets/img/demo-logo1.jpg" alt="" class="imgFull">
        </div>
        <div class="userName">Phan Linh Giang</div>
        <div class="email">email@xxx.com</div>
    </div>
    <a href="feedback.html" class="link bdb" title="Góp ý cải thiện sản phẩm" aria-label="Suggestions for product improvement">Góp ý cải thiện sản phẩm</a>
    <a href="thong-tin-tai-khoan.html" class="link" title="Thông tin tài khoản" aria-label="Profile"><strong>Thông tin tài khoản</strong></a>
    <a href="javascript:void(0)" class="btnLogout" title="Đăng xuất" aria-label="Logout">Đăng xuất</a>
    <div class="bottomInfo bdt">
        <a href="javascript:void(0)" class="link" title="Chính sách bảo mật" aria-label="Privacy policy">Chính sách bảo mật</a>
        <a href="javascript:void(0)" class="link" title="Điều khoản sử dụng" aria-label="Terms of use">Điều khoản sử dụng</a>
    </div>
</div>
<div id="popupCorporateCulture" class="px">
    <a href="javascript:void(0)" class="closePopup pa" title="Đóng" aria-label="Close"><img src="/frontend/cas/assets/img/i_x.png" alt="" class="imgFull"></a>
    <div class="logoSM bdb">
        <img src="/frontend/cas/assets/img/logo.svg" alt="" class="imgFull">
    </div>
    <a href="javascript:void(0)" class="link hasBg" title="Hệ thống đánh giá văn hóa doanh nghiệp" aria-label="CAS"><strong>Hệ thống đánh giá văn hóa doanh nghiệp</strong></a>
    <a href="javascript:void(0)" class="link bdt" title="Giới thiệu" aria-label="Introduce">Giới thiệu</a>
    <a href="home-user.html" class="link bdt" title="Tên công ty" aria-label="Home page"><strong>Tên công ty (?)</strong></a>
    <a href="ho-so-doanh-nghiep.html" class="link bdt" title="Hồ sơ doanh nghiêp" aria-label="Corporate Profile">Hồ sơ doanh nghiêp</a>
    <a href="danh-sach-thanh-vien.html" class="link" title="Dữ liệu người dùng" aria-label="User Data">Dữ liệu người dùng</a>
    <a href="danh-sach-chien-dich.html" class="link bdb" aria-label="Survey Campaign" title="Danh sách khảo sát">Danh sách khảo sát</a>
    <a href="javascript:void(0)" class="link hasBg bdb showOnMb" title="Blog" aria-label="Blog">Blog</a>
    <a href="javascript:void(0)" class="link hasBg bdb showOnMb" title="Các sản phẩm" aria-label="Products">Các sản phẩm</a>
    <a href="javascript:void(0)" class="link hasBg bdb showOnMb" title="Về chúng tôi" aria-label="About us">Về chúng tôi</a>
    <div class="bottomInfo">
        <div class="txt">Đăng nhập để thực hiện khảo sát</div>
        <a href="javascript:void(0)" class="btnLogin" title="Đăng nhập" aria-label="Login">Đăng nhập</a>
    </div>
</div>
<div class="popup px" id="popupRegister">
    <div class="bg_drop pa"></div>
    <div class="popupContent pa">
        <a href="javascript:void(0)" class="closePopup pa" title="Đóng" aria-label="Close"><img src="/frontend/cas/assets/img/btn_close.jpg" alt="" class="imgFull"></a>
        <div class="topForm">
            <h1 class="smLogo"><img src="/frontend/cas/assets/img/logo.svg" alt="" class="imgFull"></h1>
            <div class="txt">CÔNG CỤ KHẢO SÁT VÀ ĐÁNH GIÁ <br>MÔI TRƯỜNG VĂN HÓA DOANH NGHIỆP</div>
        </div>
        <form action="{{ route('frontend.post_register') }}" method="POST" id="registerForm" class="active">
            {{ csrf_field() }}
            <div id="error" class="warning showWarning" style="display: none">Bạn chưa nhập đủ thông tin yêu cầu !</div>
            <div class="form-group">
                <input type="text" placeholder="Họ và tên *" name="name" id="name">
            </div>
            <div class="form-group">
                <input type="text" placeholder="Số điện thoại *" name="phone" id="phone">
            </div>
            <div class="form-group">
                <input type="email" placeholder="Email *" name="email" id="email">
            </div>
            <div class="form-group">
                <select name="position" id="position">
                    <option value="">Vị trí công việc hiện tại *</option>
                    @foreach (\App\Helpers::REG_POSITIONS as $key =>  $val)
                        <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="option" id="option">
                    <option value="">Bạn muốn đăng ký dịch vụ *</option>
                    @foreach (\App\Helpers::REG_OPTIONS as $key =>  $val)
                        <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group acception">
                <input type="checkbox" class="checkbox" checked> Bạn đã đọc <a href="javascript:void(0)"  class="blue" title="Chính sách bảo mật" aria-label="Chính sách bảo mật" target="_blank" rel="noreferrer">Chính sách bảo mật</a>
                và <a href="javascript:void(0)" class="blue" title="Điều khoản dịch vụ" aria-label="Điều khoản dịch vụ" target="_blank" rel="noreferrer">Điều khoản dịch vụ</a> của chúng tôi.
                <br> Hỗ trọ hotline <a href="tel:0967573573">0967 573 573</a>
            </div>
            <div class="form-group">
                <button id="submitRegisterForm" type="button">Gửi đăng Ký</button>
            </div>
        </form>
    </div>
</div>
<div class="popup px popupNotify">
    <div class="bg_drop pa"></div>
    <div class="popupContent pa">
        <a href="javascript:void(0)" class="closePopup pa" title="Đóng lại" aria-label="Close"><img src="/frontend/cas/assets/img/btn_close.jpg" alt="" class="imgFull"></a>
        <h1 class="smLogo"><img src="/frontend/cas/assets/img/logo.svg" alt="" class="imgFull"></h1>
        <div class="message">
            Đăng ký được gửi về hòm thư của bạn <br>
            Cảm ơn bạn đã đăng ký sử dụng dịch vụ của CAS Online!
        </div>
    </div>
</div>