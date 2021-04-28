<div id="secondMenu">
    <div class="fixCen">
        <div class="leftSide leftMenu">
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
    </div>
</div>