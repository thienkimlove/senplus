<div id="popupProfile" class="px">
    <div class="topInfo bdb">
        <a href="javascript:void(0)" class="closePopup pa" title="Đóng" aria-label="Close">
            <img src="/frontend/assets/img/i_x.png" alt="" class="imgFull">
        </a>
        <div class="avatar">
            <img src="/frontend/assets/img/demo-logo1.jpg" alt="" class="imgFull">
        </div>
        <div class="userName">{{ auth()->user()->name }}</div>
        <div class="email">{{ auth()->user()->email }}</div>
    </div>
    <a href="javascript:void(0)" class="link bdb" title="Góp ý cải thiện sản phẩm" aria-label="Suggestions for product improvement">Góp ý cải thiện sản phẩm</a>
    <a href="javascript:void(0)" class="link" title="Thông tin tài khoản" aria-label="Profile"><strong>Thông tin tài khoản</strong></a>
    <a href="javascript:void(0)" class="btnLogout" title="Đăng xuất" aria-label="Logout">Đăng xuất</a>
    <div class="bottomInfo bdt">
        <a href="javascript:void(0)" class="link" title="Chính sách bảo mật" aria-label="Privacy policy">Chính sách bảo mật</a>
        <a href="javascript:void(0)" class="link" title="Điều khoản sử dụng" aria-label="Terms of use">Điều khoản sử dụng</a>
    </div>
</div>
<div id="popupCorporateCulture" class="px">
    <a href="javascript:void(0)" class="closePopup pa" title="Đóng" aria-label="Close">
        <img src="/frontend/assets/img/i_x.png" alt="" class="imgFull">
    </a>
    <div class="logoSM bdb">
        <img src="/frontend/assets/img/logo-sm.png" alt="" class="imgFull">
    </div>
    <a href="javascript:void(0)" class="link" title="Hệ thống đánh giá văn hóa doanh nghiệp" aria-label="CAS"><strong>Hệ thống đánh giá văn hóa doanh nghiệp</strong></a>
    <a href="javascript:void(0)" class="link bdt" title="Giới thiệu" aria-label="Introduce">Giới thiệu</a>
    <a href="javascript:void(0)" class="link" title="Hướng dẫn sử dụng" aria-label="Guiding">Hướng dẫn sử dụng</a>
    <a href="javascript:void(0)" class="link bdt" title="Trang chủ" aria-label="Home page"><strong>Trang chủ (?)</strong></a>
    <a href="javascript:void(0)" class="link bdt" title="Hồ sơ doanh nghiêp" aria-label="Corporate Profile">Hồ sơ doanh nghiêp</a>
    <a href="javascript:void(0)" class="link" title="Dữ liệu người dùng" aria-label="User Data">Dữ liệu người dùng</a>
    <a href="javascript:void(0)" class="link bdb" aria-label="Survey Campaign" title="Danh sách khảo sát">Danh sách khảo sát</a>

</div>
<header>
    <div class="fixCen">
        <h1 class="logo">
            <a href="{{ url('/') }}" title="CAS" aria-label="CAS">
                <img src="/frontend/assets/img/logo-sm.png" alt="" class="imgFull">
            </a>
        </h1>
        <nav id="topMenu">
            <ul>
                <li><a href="javascript:void(0)" title="Về chúng tôi" aria-label="About us">Về chúng tôi</a></li>
                <li><a href="javascript:void(0)" title="Các sản phẩm" aria-label="Products">Các sản phẩm</a></li>
                <li><a href="javascript:void(0)" title="Văn hóa doanh nghiệp" aria-label="Corporate Culture">Các sản phẩm</a></li>
                <li><a href="javascript:void(0)" title="Blog" aria-label="Blog">Blog</a></li>
            </ul>
            <div class="userBlock">
                <div class="avatar">
                    <img src="/frontend/assets/img/demo-logo1.jpg" alt="" class="imgFull">
                </div>
                <div class="userName">{{ auth()->user()->username }}</div>
            </div>
        </nav>
    </div>
</header>

<div id="secondMenu">
    <div class="fixCen">
        <div class="leftSide leftMenu">
            <a href="javascript:void(0)" id="btnShowMainMenu" title="Menu">
                <img src="/frontend/assets/img/btn-menu.png" alt="Menu" class="imgFull">
            </a>
            <div class="txt breadcrumb" itemprop="name">Hệ thống đánh giá Văn hoá doanh nghiệp</div>
        </div>
        <div class="rightSide rightMenu">
            <form action="" class="formSearchTop">
                <input type="text" id="searchInput" placeholder="Tìm kiếm">
                <button id="btnSearchTop">
                    <img src="/frontend/assets/img/i_search.jpg" alt="Menu" class="imgFull">
                </button>
            </form>
            <div class="btnGroup">
                <img src="/frontend/assets/img/btn-more.jpg" alt="Menu" class="imgFull">
                <!--<a href="javascript:void(0)" class="btn_question" title="Xem thêm"></a>-->
                <!--<a href="javascript:void(0)" class="btn_question" title="Liên hệ"></a>-->
            </div>
        </div>
    </div>
</div>