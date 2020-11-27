<div id="secondMenu">
    <div class="fixCen">
        <div class="leftSide leftMenu">
            <a href="javascript:void(0)" id="btnShowMainMenu" title="Menu">
                <img src="/frontend/assets/img/btn-menu.png" alt="Menu" class="imgFull">
            </a>
            <nav class="tabs breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
                <ul>
                    <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{{ route('frontend.blog') }}" itemid="blog.html" class="link" title="Blog" aria-label="Blog">
                            <span itemprop="name">Blog</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="rightSide rightMenu">
            <form id="searchForm" action="{{ route('frontend.search') }}" method="GET" class="formSearchTop">
                <input type="text" id="searchInput" name="q" value="{{ request()->input('q') }}" placeholder="Tìm kiếm">
                <button id="btnSearchTop" onclick="document.getElementById('searchForm').submit(); return false;">
                    <img src="/frontend/assets/img/i_search.jpg" alt="Menu" class="imgFull">
                </button>
            </form>
            <div class="btnGroup">
                <a href="javascript:void(0)" id="showMenuGuideMb" class="btn_question" title="Hướng dẫn" aria-label="Guiding">Hướng dẫn</a>
                <a href="javascript:void(0)" id="showMenuGuide" class="btn_question" title="Hướng dẫn" aria-label="Guiding">Hướng dẫn</a>
                <a href="javascript:void(0)" class="btn_more" title="Xem thêm" aria-label="View More">Xem thêm</a>
                <ul id="menuQuestion">
                    <li><a href="javascript:void(0)" title="Trung tâm trợ giúp" aria-label="Support" class="btnHelpCenter">Trung tâm trợ giúp</a></li>
                    <li><a href="javascript:void(0)" title="Hướng dẫn khảo sát" aria-label="Survey Guiding" onclick="showPopupGuiding('#popupGuidings2')">Hướng dẫn khảo sát</a></li>
                </ul>
            </div>
        </div>

    </div>
</div>