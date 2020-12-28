<footer>
    <div class="fixCen flex">
        <div class="leftSide">
            <h2 class="logoSm">
                <a href="{{ url('/') }}" title="CAS"><img src="/frontend/assets/img/logo-sm.png" alt="" class="imgFull"></a>
            </h2>
            <div class="txt">
                <p>Địa chỉ  trụ sở chính, Hanoi, Vietnam</p>
                <p>Tel: <a href="tel:0967573573" title="Tel" aria-label="Tel">0967 573 573</a>  | <a href="mailto:info@domain" title="Email" aria-label="Email">info@domain</a></p>
            </div>
        </div>
        <div class="rightSide">
            <div class="col">
                <h3>CAS</h3>
                <a href="javascript:void(0)" class="link" title="Giới thiệu" aria-label="Introduce">Giới thiệu</a>
                <a href="javascript:void(0)" class="link" title="Hướng dẫn khảo sát" aria-label="Survey Guiding" onclick="showPopupGuiding('#popupGuidings2')">Hướng dẫn khảo sát</a>
                <a href="javascript:void(0)" class="link" title="Quy tắc tính điểm" aria-label="Scoring Rules" onclick="showPopupGuiding('#popupGuidings2')">Quy tắc tính điểm</a>
            </div>
            <div class="col">
                <a href="{{ url('/') }}/home" class="link" title="Văn hoá doanh nghiệp" aria-label="Corporate Culture"><strong>Văn hoá doanh nghiệp</strong></a>
                <a href="{{ url('/') }}" class="link" title="Các sản phẩm" aria-label="Products"><strong>{{ \App\Helpers::configGet('menu_product') }}</strong></a>
                <a href="{{ url('/') }}/blog" class="link" title="Blog" aria-label="Blog"><strong>Blog</strong></a>
                <a href="{{ url('/') }}" class="link" title="Về chúng tôi" aria-label="About Us"><strong>Về chúng tôi</strong></a>
            </div>
            <div class="col">
                <h3>Kết nối với chúng tôi</h3>
                <div class="socialMedia">
                    <a href="javascript:void(0)" title="Facebook" aria-label="Facebook">
                        <img src="/frontend/assets/img/i_fb2.png" alt="" class="imgFull">
                    </a>
                    <a href="javascript:void(0)" title="Instagram" aria-label="Instagram">
                        <img src="/frontend/assets/img/i_insta.png" alt="" class="imgFull">
                    </a>
                    <a href="javascript:void(0)" title="LinkedIn" aria-label="LinkedIn">
                        <img src="/frontend/assets/img/i_in.png" alt="" class="imgFull">
                    </a>
                    <a href="javascript:void(0)" title="Youtube" aria-label="Youtube">
                        <img src="/frontend/assets/img/i_yt.png" alt="" class="imgFull">
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>