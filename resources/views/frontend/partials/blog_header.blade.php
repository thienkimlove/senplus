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
                <li class="hideOnMobile">
                    <a class="{{ (isset($page) && $page == 'index')? 'active' : '' }} }}" href="{{ route('frontend.index') }}" title="Về chúng tôi" aria-label="About us">Về chúng tôi</a>
                </li>
                <li class="hideOnMobile">
                    <a class="{{ (isset($page) && $page == 'product')? 'active' : '' }}" href="{{ route('frontend.product') }}" title="Sản phẩm" aria-label="Products">
                        Sản phẩm
                    </a>
                    <ol class="subMenu">
                        <li><a href="{{ route('frontend.product') }}" title="Khảo sát mô hình cạnh tranh">Khảo sát mô hình cạnh tranh</a></li>
                        <li><a href="{{ route('frontend.product') }}" title="Đo lường hiệu quả văn hóa doanh nghiệp">Đo lường hiệu quả văn hóa doanh nghiệp</a></li>
                        <li><a href="{{ route('frontend.product') }}" title="Dịch vụ bổ trợ">Dịch vụ bổ trợ</a></li>
                    </ol>
                </li>
                <li class="hideOnMobile">
                    <a class="{{ (isset($page) && $page == 'blog')? 'active' : '' }}" href="{{ route('frontend.blog') }}" title="Blog" aria-label="Blog">Blog</a></li>
                <li class="hideOnMobile">
                    <a class="{{ (isset($page) && $page == 'contact')? 'active' : '' }}" href="{{ route('frontend.contact') }}" title="Liên hệ" aria-label="Contact">Liên hệ</a></li>
                <li>
                    <a href="{{ route('frontend.inspire') }}" class="btnSurvey {{(isset($page) && $page == 'inspire')? 'active' : ''}}" title="Khảo sát miễn phí" aria-label="Free Survey">Khảo sát miễn phí</a>
                </li>
            </ul>
            <div class="btnGroup flxc">
                <form id="searchForm" action="{{ route('frontend.search') }}" method="GET" class="formSearchTop">
                    <input type="text" id="searchInput" name="q" value="{{ request()->input('q') }}" placeholder="Tìm kiếm">
                    <button id="btnSearchTop" onclick="document.getElementById('searchForm').submit(); return false;">
                        <img src="/frontend/assets/img/i_search.jpg" alt="Menu" class="imgFull">
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