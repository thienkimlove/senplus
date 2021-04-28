<div class="btnFixs">
    <div class="quick-alo-phone quick-alo-green quick-alo-show" id="quick-alo-phoneIcon">
        <a href="tel:0967573573" id="btnHotline" title="Hotline">
            <div class="quick-alo-ph-circle bgBlue"></div>
            <div class="quick-alo-ph-circle-fill bgBlue"></div>
            <div class="quick-alo-ph-img-circle"></div>
        </a>
    </div>
    <div class="quick-alo-phone quick-alo-green quick-alo-show">
        <a href="javascript:void(0)" id="btnChat" title="Messenger">
            <div class="quick-alo-ph-circle bgPurple"></div>
            <div class="quick-alo-ph-circle-fill quick-alo-chat bgPurple"></div>
            <div class="quick-alo-ph-img-circle quick-alo-chat"></div>
        </a>
    </div>
</div>
<div id="onTop"></div>
<header>
    <div class="fixCen">
        <h1 class="logo">
            <a href="{{ route('frontend.index') }}" title="CAS" aria-label="CAS">
                <img src="/frontend/cas/assets/img/logo.svg" alt="" class="imgFull">
            </a>
        </h1>
        <nav id="topMenu">
            <ul class="navi">
                <li class="hideOnMobile"><a href="{{ route('frontend.index') }}" title="Về chúng tôi" aria-label="About us">Về chúng tôi</a></li>
                <li class="hideOnMobile"><a href="{{ route('frontend.product') }}" title="Sản phẩm" aria-label="Products">Sản phẩm</a>
                    <ol class="subMenu">
                        <li><a href="{{ route('frontend.product') }}" title="Khảo sát mô hình cạnh tranh">Khảo sát mô hình cạnh tranh</a></li>
                        <li><a href="{{ route('frontend.product') }}" title="Đo lường hiệu quả văn hóa doanh nghiệp">Đo lường hiệu quả văn hóa doanh nghiệp</a></li>
                        <li><a href="{{ route('frontend.product') }}" title="Dịch vụ bổ trợ">Dịch vụ bổ trợ</a></li>
                    </ol>
                </li>
                <li class="hideOnMobile"><a href="{{ route('frontend.index') }}/blog" title="Blog" aria-label="Blog">Blog</a></li>
                <li class="hideOnMobile"><a href="{{ route('frontend.contact') }}" title="Liên hệ" aria-label="Contact">Liên hệ</a></li>
                <li>
                    <a href="{{ route('frontend.inspire')  }}" class="btnSurvey" title="Khảo sát miễn phí" aria-label="Free Survey">Khảo sát miễn phí</a>
                </li>
            </ul>
            <div class="btnGroup flxc">
                <form action="{{ route('frontend.search') }}" method="GET" class="formSearchTop">
                    <input type="text" name="q" id="searchInput" placeholder="Tìm kiếm">
                    <button id="btnSearchTop">
                        <img src="/frontend/cas/assets/img/i_search.png" alt="Menu" class="imgFull">
                    </button>
                </form>
                <a href="javascript:void(0)" id="btnShowMainMenu" title="Menu">
                    <img src="/frontend/cas/assets/img/btn_menu.png" alt="Menu" class="imgFull">
                </a>
            </div>
            @if (auth()->check())
                <div class="userBlock">
                    <div class="avatar">
                        <img src="{{ \App\Helpers::getLoginCustomerAvatar() }}" alt="" class="imgFull">
                    </div>
                    <div class="userName">{{ auth()->user()->name }}</div>
                </div>
            @endif

        </nav>
    </div>
</header>