<header>
    <div id="topBar">
        <div class="fixCen">
            <div class="hello">
                <span class="txt">Xin chào: </span><a href="javascript:void(0)" class="btnUserID" title="Tên đăng nhập" aria-label="User ID">{{ auth()->user()->name }}</a>
                <div class="pa" id="userPopup">
                    <ul>
                        <li><a href="{{ route('frontend.logout') }}" title="Đăng xuất">Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="centerHeader">
        <div class="fixCen">
            <a href="javascript:void(0)" class="myBtn logo" title="Senplus">
                <img src="{{ url('frontend/assets/img/logo4.png') }}" alt="" class="imgFull">
            </a>
        </div>
    </div>
</header>