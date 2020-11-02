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
                <li><a href="{{ url('/') }}" title="Văn hóa doanh nghiệp" aria-label="Corporate Culture">Văn hóa doanh nghiệp</a></li>
                <li><a href="javascript:void(0)" title="Blog" aria-label="Blog">Blog</a></li>
            </ul>
            <div class="userBlock">
                <div class="avatar">
                    <img src="{{ \App\Helpers::getLoginCustomerAvatar() }}" alt="" class="imgFull">
                </div>
                <div class="userName">{{ auth()->user()->name }}</div>
            </div>
        </nav>
    </div>
</header>