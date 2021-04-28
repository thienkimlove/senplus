<div id="secondMenu">
    <div class="fixCen">
        <div class="leftSide leftMenu">
            <nav class="tabs breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
                <ul>
                    <li class="{{ isset($contentBlogUrl)? '' : 'active' }}" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{{ route('frontend.blog') }}" itemid="blog.html" class="link" title="Blog" aria-label="Blog">
                            <span itemprop="name">Blog</span>
                        </a>
                    </li>
                    @if (isset($contentBlogUrl))
                    <li class="hasBgTag active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{{ $contentBlogUrl }}" itemid="{{ $contentBlogUrl }}" class="link" title="{{ $contentBlogName }}" aria-label="{{ $contentBlogName }}">
                            <span itemprop="name">{{ $contentBlogName }}</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>