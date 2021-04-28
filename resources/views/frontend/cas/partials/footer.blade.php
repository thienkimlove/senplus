<footer>
    <a href="#onTop" id="btnGoTop" title="Lên đầu trang"><img src="/frontend/cas/assets/img/btn_next.png" alt="" class="imgFull"></a>
    <div class="fixCen flex">
        <div class="leftSide">
            <h2 class="logoSm">
                <a href="{{ route('frontend.index') }}" title="CAS"><img src="/frontend/cas/assets/img/logo-white.svg" alt="" class="imgFull"></a>
            </h2>
            <div class="txt">
                <p>Trụ sở chính: Hanoi, Vietnam</p>
                <p>Tel: <a href="tel:0967573573" title="Tel" aria-label="Tel">0967 573 573</a></p>
                <p>Email: <a href="mailto:support@casonline.vn" title="Email" aria-label="Email">support@casonline.vn</a></p>
            </div>
        </div>
        <div class="rightSide">
            <div class="col">
                <h3>CAS</h3>
                <a href="javascript:void(0)" class="link" title="Hướng dẫn" aria-label="Guiding">Hướng dẫn</a>
                <a href="{{ route('frontend.contact') }}" title="Liên hệ">Liên hệ</a>
                <a href="javascript:void(0)" title="Câu hỏi thường gặp">Câu hỏi thường gặp</a>
            </div>
            <div class="col">
                <a href="{{ route('frontend.product') }}" class="link" title="Sản phẩm" aria-label="Products">Sản phẩm</a>
                <a href="{{ route('frontend.index') }}/blog" class="link" title="Blog" aria-label="Blog">Blog</a>
                <a href="{{ route('frontend.index') }}" class="link" title="Về chúng tôi" aria-label="About Us">Về chúng tôi</a>
                <a href="javascript:void(0)" class="link" title="Đăng ký" data-popup="#popupRegister" onclick="showPopup($(this))">Đăng ký</a>
            </div>
        </div>
    </div>
</footer>