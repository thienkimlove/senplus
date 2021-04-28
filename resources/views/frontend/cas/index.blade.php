@extends('frontend.cas.layout')


@section('content')
    <main>
        <section class="section pr" id="section1">
            <div class="fixCen">
                <quotes>
                    {!! \App\Helpers::configGet('index_section1_quote') !!}
                </quotes>
                <div class="description">
                    {!! \App\Helpers::configGet('index_section1_desc') !!}
                </div>
                <a href="https://casonline.vn/inspire" class="btnSurvey" title="Khảo sát miễn phí" aria-label="Free Survey">Khảo sát miễn phí</a>
            </div>
        </section>
        <section class="section pr" id="section2">
            <div class="fixCen">
                <quotes id="sec2quotes">
                    <div>{!! \App\Helpers::configGet('index_section2_quote') !!}</div>
                </quotes>
                <div class="circleGroup">
                    <div class="item">
                        <div class="circleWrapper bgOrange">
                            <div class="circleInner pa"><div class="leftPercent" id="cOrange"></div></div>
                            <div class="showPercent">72%</div>
                        </div>
                        <div class="name bgOrange"><span></span>Breathe</div>
                        <div class="des p024">72% SMEs cho rằng văn hóa công ty có ảnh hưởng tích cực đến hiệu quả kinh doanh</div>
                    </div>
                    <div class="item">
                        <div class="circleWrapper bgPurple">
                            <div class="circleInner pa"><div class="leftPercent" id="cPurple"></div></div>
                            <div class="showPercent">82%</div>
                        </div>
                        <div class="name bgPurple"><span></span>Deloitte</div>
                        <div class="des p024">82% người được hỏi cho rằng văn hóa doanh nghiệp là một lợi thế cạnh tranh của họ</div>
                    </div>
                    <div class="item">
                        <div class="circleWrapper bgGreen">
                            <div class="circleInner pa"><div class="leftPercent" id="cGreen"></div></div>
                            <div class="showPercent">65%</div>
                        </div>
                        <div class="name bgGreen"><span></span>PwC</div>
                        <div class="des">65% nhà quản lý cho rằng văn hóa doanh nghiệp quan trong hơn chiến lược hoặc mô hình hoạt động của họ</div>
                    </div>
                    <div class="item">
                        <div class="circleWrapper bgBlue">
                            <div class="circleInner pa"><div class="leftPercent" id="cBlue"></div></div>
                            <div class="showPercent">92%</div>
                        </div>
                        <div class="name bgBlue"><span></span>E&Y</div>
                        <div class="des">92% thành viên HĐQT cho rằng đầu tư vào văn hóa doanh nghiệp đã cải thiện hiệu quả tài chính</div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section pr" id="section3">
            <div class="fixCen">
                <h2 class="title hasBd">VĂN HÓA DOANH NGHIỆP TIÊU CỰC GÂY RA</h2>
                <div class="content" id="effect1">
                    <div class="item card1">
                        <div class="card">
                            <div class="icon"><img src="/frontend/cas/assets/img/5.png" alt="" class="imgFull"></div>
                            <h3 class="title" title="Kiệt sức">Kiệt sức</h3>
                            <div class="sum">24% nhân viên <br> thấy kiệt sức</div>
                            <div class="source">Viện lao động Mỹ, 2019</div>
                        </div>
                    </div>
                    <div class="item card2">
                        <div class="card">
                            <div class="icon"><img src="/frontend/cas/assets/img/6.png" alt="" class="imgFull"></div>
                            <h3 class="title" title="Chảy máu chất xám">Chảy máu chất xám</h3>
                            <div class="sum">87% nhân viên <br> trên thế giới <br> không muốn gắn bó <br> với công ty</div>
                            <div class="source">Tập đoàn Gallup, 2017</div>
                        </div>
                    </div>
                    <div class="item card3">
                        <div class="card">
                            <div class="icon"><img src="/frontend/cas/assets/img/7.png" alt="" class="imgFull"></div>
                            <h3 class="title" title="Giảm động lực">Giảm động lực</h3>
                            <div class="sum">48% nhân viên trên thế giới không yêu thích công việc, thấy căng thẳng và mất động lực làm việc nơi công sở.</div>
                            <div class="source">Forbes, 2014</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section pr" id="section4">
            <div class="fixCen">
                <h2 class="title">CAS ONLINE <br> Công cụ ưu việt cải thiện văn hóa doanh nghiệp</h2>
                <div class="content content1">
                    <div class="banner"><img src="/frontend/cas/assets/img/banner1.jpg" alt="" class="imgFull"></div>
                    <div class="items">
                        <div class="item">
                            <div class="icon"><img src="/frontend/cas/assets/img/2.png" alt="" class="imgFull"></div>
                            <h3 class="title" title="Đo lường">Đo lường</h3>
                            <div class="sum">Đo lường, đánh giá các chỉ số về môi trường văn hóa, mô hình cạnh tranh, mức độ hiệu quả của văn hóa doanh nghiệp</div>
                        </div>
                        <div class="item">
                            <div class="icon"><img src="/frontend/cas/assets/img/4.png" alt="" class="imgFull"></div>
                            <h3 class="title" title="Tùy biến">Tùy biến</h3>
                            <div class="sum">Tùy biến các chiến dịch khảo sát riêng biệt, phù hợp với từng doanh nghiệp</div>
                        </div>
                        <div class="item">
                            <div class="icon"><img src="/frontend/cas/assets/img/3.png" alt="" class="imgFull"></div>
                            <h3 class="title" title="Chủ động">Chủ động</h3>
                            <div class="sum">
                                <p>Quản lý dữ liệu nhân viên</p>
                                Thiết lập các chiến dịch khảo sát vào thời điểm thích hợp
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon"><img src="/frontend/cas/assets/img/1.png" alt="" class="imgFull"></div>
                            <h3 class="title" title="Hiệu quả">Hiệu quả</h3>
                            <div class="sum">
                                <p>Thuật toán đảm bảo 100% câu trả lời hợp lệ</p>
                                Rút ngắn 90% thời gian khảo sát
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content content2">
                    <div class="items" id="effect2">
                        <div class="item card4">
                            <div class="card">
                                <a href="javascript:void(0)" class="title" title="Chủ doanh nghiệp">Chủ doanh nghiệp</a>
                                <ul>
                                    <li>Đo lường hiệu quả văn hóa doanh nghiệp theo cơ sở khoa học, với số liệu cụ thể</li>
                                    <li>Góc nhìn đa chiều về nhận thức, mong muốn của các cấp nhân viên</li>
                                    <li>Tối ưu chi phí đầu tư cho văn hóa doanh nghiệp</li>
                                    <li>Dễ dàng thống nhất ý chí nội bộ</li>
                                </ul>
                            </div>
                        </div>
                        <div class="item card5">
                            <div class="card">
                                <a href="javascript:void(0)" class="title" title="Chủ doanh nghiệp">Cấp quản lý</a>
                                <ul>
                                    <li>Hiểu nguyện vọng nhân viên cấp dưới</li>
                                    <li>Cơ sở xây dựng đội ngũ nhân sự chất lượng cao, phù hợp với tập thể</li>
                                    <li>Nắm rõ định hướng phát triển, chia sẻ thông suốt trong đội ngũ</li>
                                </ul>
                            </div>
                        </div>
                        <div class="item card6">
                            <div class="card">
                                <a href="javascript:void(0)" class="title" title="Chủ doanh nghiệp">Nhân viên</a>
                                <ul>
                                    <li>Tự do bày tỏ mong muốn cá nhân về văn hóa doanh nghiệp</li>
                                    <li>Góp phần xây dựng môi trường làm việc lý tưởng</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="banner">
                        <img src="/frontend/cas/assets/img/banner2.jpg" alt="" class="imgFull">
                    </div>
                    <h2 class="title">Kết nối nhu cầu các cấp trong doanh nghiệp</h2>
                </div>
            </div>
        </section>
        <section class="section pr" id="section5">
            <div class="fixCen">
                <h2 class="title hasBd">SẢN PHẨM CỦA CHÚNG TÔI</h2>
                <div class="content">
                    <div class="item">
                        <div class="icon">
                            <img src="/frontend/cas/assets/img/8.png" alt="" class="imgFull">
                        </div>
                        <h3 class="title" title="Khảo sát mô hình cạnh tranh">Khảo sát <br>mô hình cạnh tranh</h3>
                        <div class="sum">
                            <ul>
                                <li>Trải nghiệm MIỄN PHÍ với tài khoản cá nhân</li>
                                <li>Công cụ ƯU VIỆT, nhận diện mô hình cạnh tranh trong 30 phút</li>
                                <li>Kim chỉ nam giúp doanh nghiệp định hướng mô hình cạnh tranh HIỆU QUẢ</li>
                                <li>Đào tạo TOÀN DIỆN về văn hóa doanh nghiệp</li>
                                <li>Tư vấn CHIẾN LƯỢC trên quy mô toàn hệ thống</li>
                            </ul>
                        </div>
                        <a href="#" class="linkDetail" title="Chi tiết">Chi tiết</a>
                        <a href="https://casonline.vn/inspire" class="myBtn" title="Khảo sát ngay">Khảo sát ngay</a>
                    </div>
                    <div class="item">
                        <div class="icon"><img src="/frontend/cas/assets/img/9.png" alt="" class="imgFull"></div>
                        <h3 class="title" title="Chảy máu chất xám">Đo lường <br> văn hóa doanh nghiệp</h3>
                        <div class="sum">
                            <ul>
                                <li>Công cụ HIỆN ĐẠI đo lường CHÍNH XÁC hiệu quả của văn hóa doanh nghiệp</li>
                                <li>Xác định LỢI THẾ, mũi nhọn cạnh tranh của doanh nghiệp</li>
                                <li>Đào tạo TOÀN DIỆN về văn hóa doanh nghiệp</li>
                                <li>Tư vấn CHIẾN LƯỢC trên quy mô toàn hệ thống</li>
                            </ul>
                        </div>
                        <a href="#" class="linkDetail" title="Chi tiết">Chi tiết</a>
                        <a href="javascript:void(0)" class="myBtn" title="Đăng ký" data-popup="#popupRegister" onclick="showPopup($(this))">Đăng ký</a>
                    </div>
                    <div class="item">
                        <div class="icon"><img src="/frontend/cas/assets/img/10.png" alt="" class="imgFull"></div>
                        <h3 class="title" title="Giảm động lực">Dịch vụ bổ trợ</h3>
                        <div class="sum">Tư vấn, lập kế hoạch, triển khai hoạt động truyền thông nội bộ
                            <ul>
                                <li>Tư vấn, xây dựng bộ quy chế ứng xử, văn bản nội quy liên quan đến văn hóa doanh nghiệp</li>
                                <li>Tư vấn xây dựng, thiết kế, thi công bộ nhận diện thương hiệu doanh nghiệp</li>
                            </ul>
                        </div>
                        <a href="#" class="linkDetail" title="Chi tiết">Chi tiết</a>
                        <a href="javascript:void(0)" class="myBtn" title="Đăng ký" data-popup="#popupRegister" onclick="showPopup($(this))">Đăng ký</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="section pr" id="section6">
            <div class="fixCen">
                <h2 class="title hasBd">BLOG</h2>
                <div class="content">
                    <div id="sliderNewPost">
                        @foreach (\App\Helpers::getLatestPosts() as $latestPost)
                            <div class="item">
                            <a href="{{ url($latestPost->slug.'.html') }}" class="txt" title="{{ $latestPost->name }}">
                                <span class="title" title="{{ $latestPost->name }}">{{ $latestPost->name }}</span>
                                <span class="sum">
                               {{ $latestPost->desc }}
                            </span>
                                <span class="viewMore">Xem thêm</span>
                            </a>
                            <a href="{{ url($latestPost->slug.'.html') }}" class="thumb" title="{{ $latestPost->name }}"><img src="{{ $latestPost->anh2 ? url($latestPost->anh2) : url($latestPost->image) }}" alt="" class="imgFull"></a>
                        </div>
                        @endforeach
                    </div>
                    @if ($latestNew = \App\Helpers::getLatestPost())
                    <div id="newestNews">
                        <a href="{{ url($latestNew->slug.'.html') }}" class="thumb" title="{{ $latestNew->name }}">
                            <img src="{{ \App\Helpers::getImageBySize($latestNew, 350, 195) }}" alt="" class="imgFull">
                        </a>
                        <a href="{{ url($latestNew->slug.'.html') }}" class="title" title="{{ $latestNew->name }}">{{ $latestNew->name }}</a>
                        <div class="line">----------------</div>
                        <div class="sum">
                            {{ $latestNew->desc }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        <section class="section pr" id="section7">
            <div class="fixCen">
                <h2 class="title hasBd">KHÁCH HÀNG CỦA CAS</h2>
                <div class="content content1">
                   @foreach (\App\Helpers::getPartners() as $partner)
                    <div class="item">
                        <div class="thumb">
                            <img src="{{ $partner->image? url($partner->image) : '' }}" alt="" class="imgFull">
                        </div>
                        <div class="name">{{ $partner->name }}</div>
                        <div class="company">{{ $partner->company }}</div>
                        <quotes>{{ $partner->text }}</quotes>
                    </div>
                   @endforeach
                </div>
                <div class="content2">
                    <div id="partnerSlider">
                        @foreach (\App\Helpers::getPartners() as $partner)
                        <a href="#" title="{{ $partner->company }}"><img src="{{ $partner->image? url($partner->image) : '' }}" alt=""></a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection