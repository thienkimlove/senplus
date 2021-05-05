<div id="popupProfile" class="px">
    @if (auth()->check())
    <div class="topInfo bdb">
        <a href="javascript:void(0)" class="closePopup pa" title="Đóng" aria-label="Close">
            <img src="/frontend/cas/assets/img/i_x.png" alt="" class="imgFull">
        </a>
        <div class="avatar">
            <img src="{{ \App\Helpers::getLoginCustomerAvatar() }}" alt="" class="imgFull">
        </div>

        <div class="userName">{{ auth()->user()->name }}</div>

    </div>

    <a href="{{ route('frontend.contact') }}" class="link bdb" title="Góp ý cải thiện sản phẩm" aria-label="Suggestions for product improvement">
        Góp ý cải thiện sản phẩm
    </a>
    <a href="{{ route('frontend.personal') }}" class="link" title="Thông tin tài khoản" aria-label="Profile">
        <strong>Thông tin tài khoản</strong>
    </a>
    <a href="{{ route('frontend.logout') }}" class="btnLogout" title="Đăng xuất" aria-label="Logout">Đăng xuất</a>

    @endif

    <div class="bottomInfo bdt">
        <a href="javascript:void(0)" class="link" title="Chính sách bảo mật" aria-label="Privacy policy">Chính sách bảo mật</a>
        <a href="javascript:void(0)" class="link" title="Điều khoản sử dụng" aria-label="Terms of use">Điều khoản sử dụng</a>
    </div>
</div>
<div id="popupCorporateCulture" class="px menuHomePage">
    <a href="javascript:void(0)" class="closePopup pa" title="Đóng" aria-label="Close"><img src="/frontend/cas/assets/img/i_x.png" alt="" class="imgFull"></a>
    <div class="logoSM bdb">
        @if (auth()->check())
            <img src="{{ \App\Helpers::getLoginCompanyLogo() }}" alt="" class="imgFull">
        @endif
    </div>
    <a href="{{  route('frontend.home') }}" class="link" title="Hệ thống đánh giá văn hóa doanh nghiệp" aria-label="CAS">
        <strong>Hệ thống đánh giá văn hóa doanh nghiệp</strong>
    </a>
    <ul class="showOnMobile">
        <li><a href="{{ route('frontend.index') }}" class="link bdt" title="Về chúng tôi" aria-label="About us">Về chúng tôi</a></li>
        <li><a href="javascript:void(0)" class="link bdt" title="Sản phẩm" aria-label="Products">Sản phẩm</a>
            <ol class="subMenu">
                <li><a href="{{ route('frontend.product') }}" title="Khảo sát mô hình cạnh tranh">Khảo sát mô hình cạnh tranh</a></li>
                <li><a href="{{ route('frontend.product') }}" title="Đo lường hiệu quả văn hóa doanh nghiệp">Đo lường hiệu quả văn hóa doanh nghiệp</a></li>
                <li><a href="{{ route('frontend.product') }}" title="Dịch vụ bổ trợ">Dịch vụ bổ trợ</a></li>
            </ol>
        </li>
        <li><a href="{{ route('frontend.index') }}/blog" class="link bdt" title="Blog" aria-label="Blog">Blog</a></li>
        <li><a href="{{ route('frontend.contact') }}" class="link bdt" title="Liên hệ" aria-label="Contact">Liên hệ</a></li>
    </ul>
    <ul>
        <li><a href="javascript:void(0)" class="link hasBg btnHelpCenter bdt bdb" title="Câu hỏi thường gặp" aria-label="Usual Questions">Câu hỏi thường gặp</a></li>
        <li><a href="javascript:void(0)" class="link" title="Hướng dẫn" aria-label="Guiding">Hướng dẫn</a>
            <ul class="subMenu">
                <li><a href="javascript:void(0)" class="link bdb" title="Hướng dẫn khảo sát">Hướng dẫn khảo sát</a></li>
                <li><a href="https://casonline.vn/quy-tac-tinh-diem-cua-khao-sat-mo-hinh-canh-tranh.html" class="link" title="Quy tắc tính điểm">Quy tắc tính điểm</a></li>
            </ul>
        </li>
    </ul>
    @if (!auth()->check())
    <div class="bottomInfo bdt">
        <div class="txt">Đăng nhập để thực hiện khảo sát</div>
        <a href="{{ route('frontend.inspire') }}" class="btnLogin" title="Đăng nhập" aria-label="Login">Đăng nhập</a>
    </div>
    @endif
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
                    @foreach (\App\Helpers::REG_POSITIONS as $key =>  $val)
                        <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="option" id="option">
                    @foreach (\App\Helpers::REG_OPTIONS as $key =>  $val)
                        <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group acception">
                <input type="checkbox" class="checkbox" checked> Bạn đã đọc <a href="javascript:void(0)"  class="blue" title="Chính sách bảo mật" aria-label="Chính sách bảo mật" target="_blank" rel="noreferrer">Chính sách bảo mật</a>
                và <a href="javascript:void(0)" class="blue" title="Điều khoản dịch vụ" aria-label="Điều khoản dịch vụ" target="_blank" rel="noreferrer">Điều khoản dịch vụ</a> của chúng tôi.
                <br> Hotline hỗ trợ <a href="tel:0967573573">0967 573 573</a>
            </div>
            <div class="form-group">
                <button id="submitRegisterForm" type="button">Gửi đăng ký</button>
            </div>
            <p style="text-align: center;">Đăng ký được gửi về hòm mail của bạn Cảm ơn bạn đã đăng ký sử dụng dịch vụ của CAS Online!</p>
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