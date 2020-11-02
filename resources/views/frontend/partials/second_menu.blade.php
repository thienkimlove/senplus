<div id="secondMenu">
    <div class="fixCen">
        <div class="leftSide leftMenu">
            <a href="javascript:void(0)" id="btnShowMainMenu" title="Menu">
                <img src="/frontend/assets/img/btn-menu.png" alt="Menu" class="imgFull">
            </a>
            <nav class="tabs breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
                <ul>
                    <li class="{{ isset($section) && $section == 'home' ? 'active' : '' }}" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{{ route('frontend.home') }}" itemid="home-user" class="link" title="CAS" aria-label="CAS">
                            <span itemprop="name">CAS</span>
                        </a>
                    </li>
                    @if (\App\Helpers::currentFrontendUserIsManager())
                        <li class="{{ isset($section) && $section == 'profile' ? 'active' : '' }}" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{{ route('frontend.profile') }}" itemid="ho-so-doanh-nghiep" class="link" title="Hồ sơ doanh nghiêp" aria-label="Corporate Profile">
                                <span itemprop="name">Hồ sơ doanh nghiệp</span>
                            </a>
                        </li>
                        <li class="{{ isset($section) && $section == 'member' ? 'active' : '' }}" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{{ route('frontend.member') }}" itemid="du-lieu-nguoi-dung" class="link" title="Dữ liệu người dùng" aria-label="User Data">
                                <span itemprop="name">Dữ liệu người dùng</span>
                            </a>
                        </li>
                        <li class="{{ isset($section) && $section == 'campaign' ? 'active' : '' }}" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{{ route('frontend.campaign') }}" itemid="chien-dich-khao-sat"  class="link" title="Danh sách khảo sát" aria-label="Survey Campaign">
                                <span itemprop="name">Danh sách khảo sát</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
        <div class="rightSide rightMenu">
            <form action="" class="formSearchTop">
                <input type="text" id="searchInput" placeholder="Tìm kiếm">
                <button id="btnSearchTop">
                    <img src="/frontend/assets/img/i_search.jpg" alt="Menu" class="imgFull">
                </button>
            </form>
            <div class="btnGroup">
                <a href="javascript:void(0)" id="showMenuGuideMb" class="btn_question" title="Hướng dẫn" aria-label="Guiding">Hướng dẫn</a>
                <a href="javascript:void(0)" id="showMenuGuide" class="btn_question" title="Hướng dẫn" aria-label="Guiding">Hướng dẫn</a>
                <a href="javascript:void(0)" class="btn_more" title="Xem thêm" aria-label="View More">Xem thêm</a>
                <ul id="menuQuestion">
                    <li><a href="javascript:void(0)" class="btnHelpCenter" title="Trung tâm trợ giúp" aria-label="Support">Trung tâm trợ giúp</a></li>
                    <li><a href="javascript:void(0)" title="Hướng dẫn khảo sát" aria-label="Survey Guiding" onclick="showPopupGuiding('#popupGuidings2')">Hướng dẫn khảo sát</a></li>
                </ul>
            </div>
        </div>

    </div>
</div>