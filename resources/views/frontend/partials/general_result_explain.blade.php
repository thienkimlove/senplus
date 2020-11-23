    <div>
	Trong phạm vi của báo cáo này, chúng tôi dùng từ "nhóm" để đại diện cho nhóm đối tượng khảo sát mà anh/chị đã chọn ra.
        Trên đây này là nhận thức của họ về văn hóa của {{ $explain['company_name'] }}
        Kết quả này có ý nghĩa như sau:
    </div>

    <div>
        <h4>LOẠI HÌNH VĂN HÓA NỔI TRỘI</h4>
    </div>

    <div>
        Văn hóa nổi trội quyết định năng lực cạnh tranh chính của doanh nghiệp, được xác định bởi giá trị lớn nhất của mỗi cột. Một doanh nghiệp có văn hóa đồng nhất và mạnh mẽ thường là khi giá trị lớn nhất đó thực sự nổi trội so với phần còn lại. Nghiên cứu của chúng tôi cho thấy, nhân viên của những doanh nghiệp như vậy luôn có ý thức rõ ràng về mục tiêu, đồng nhất về nỗ lực và hướng đi.
    </div>

    <div>
        Giá trị lớn thứ 2 của mỗi cột miêu tả văn hóa bổ trợ. Thực tế là không có doanh nghiệp nào chỉ tập trung vào 1 loại văn hóa duy nhất. Văn hóa bổ trợ có vai trò tận dụng những ưu điểm và hạn chế nhược điểm của văn hóa nổi trội, không phải là năng lực cạnh tranh chính của doanh nghiệp.
    </div>

    <div>
        <b>Như vậy, trong trường hợp này:</b>
    </div>

    <div>
        Văn hóa nối trội của {{ $explain['company_name'] }} trong thời gian qua theo đánh giá của nhóm là {{ $explain['details'][7]['explainMax']->ten_van_hoa }} – {{ $explain['details'][7]['maxValue'] }} điểm. Năng lực cạnh tranh chính của doanh nghiệp là {{ $explain['details'][7]['explainMax']->nang_luc_canh_tranh }}. Giá trị chính mà loại hình văn hóa này đem lại là {{ $explain['details'][7]['explainMax']->gia_tri_dem_lai }}.
    </div>

    <div>
        Văn hóa bổ trợ là {{ $explain['details'][7]['explainSecond']->ten_van_hoa }} – {{ $explain['details'][7]['secondValue'] }}.
    </div>

    <div>
        <h4><b>Kết luận: <i style="color: #333333; font-style: normal;">Văn hóa của {{ $explain['company_name'] }} theo đánh giá của nhóm có đặc điểm như sau:</i></b></h4>
    </div>

    <div>
        <h5 style="color: #333333;font-weight: bold;font-size: 16px;">Xu hướng</h5>
    </div>

    <div>
        <ul>
            @foreach ($explain['details'][7]['explainMax']->xu_huong as $k)
                <li>{{ $k['content'] }}</li>
            @endforeach
        </ul>
    </div>

    <div>
        <h5 style="color: #333333;font-weight: bold;font-size: 16px;">Ưu Điểm</h5>
    </div>

    <div>
       <ul>
           @foreach ($explain['details'][7]['explainMax']->uu_diem as $k)
               <li>{{ $k['content'] }}</li>
           @endforeach
       </ul>
    </div>

    <div>
        <h5 style="color: #333333;font-size: 16px;font-weight: bold;">Nhược điểm</h5>
    </div>

    <div>
        <ul>
            @foreach ($explain['details'][7]['explainMax']->nhuoc_diem as $k)
                <li>{{ $k['content'] }}</li>
            @endforeach
        </ul>
    </div>

    <div>
        <h4>KHOẢNG CÁCH GIỮA VĂN HÓA HIỆN TẠI VÀ MONG MUỐN</h4>
    </div>

    <div>
        Khoảng cách giữa văn hóa hiện tại và mong muốn thể hiện nhu cầu thay đổi của nhóm. Những giá trị lớn hơn 10 theo lý thuyết của Khung năng lực cạnh tranh, thể hiện sự quan trọng và mức độ cấp thiết của các hành động nhằm tạo ra sự thay đổi đó.
    </div>

    <div>
        Những giá trị nhỏ hơn 10 thể hiện cho những nhu cầu thay đổi mà doanh nghiệp cần lưu ý. Doanh nghiệp nên tổ chức những cuộc trao đổi giữa đội ngũ lãnh đạo và cán bộ nhân viên để đi sâu tìm hiểu điều chúng ta muốn thay đổi là gì.
    </div>

    <div>
        Đối với những thay đổi cấp thiết, doanh nghiệp có thể liên hệ với Senplus để nhận tư vấn chuyên sâu.
    </div>

    <div>
        <b>Như vậy, trong trường hợp này:</b>
    </div>

    @if ($explain['details'][7]['moreThan'])
        <div>
            Có {{ count($explain['details'][7]['moreThan']) }} nhu cầu cấp thiết đó là:
        </div>
        <div>
            <ul>
                @foreach ($explain['details'][7]['moreThan'] as $option)
                    @php
                        $tempValue = round($explain['details'][7]['result'][2][$option] - $explain['details'][7]['result'][1][$option], 2);
                    @endphp

                    <li>{{ ($tempValue > 0) ? 'Gia tăng' : 'Giảm bớt' }} tỉ trọng của loại hình {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ $tempValue }} điểm) tương ứng với năng lực cạnh tranh bằng {{ $explain['all']->where('option', $option)->first()->nang_luc_canh_tranh }}</li>
                @endforeach
            </ul>
        </div>

    @endif

    @if ($explain['details'][7]['lessThan'])
        <div>
            Có {{ count($explain['details'][7]['lessThan']) }} nhu cầu cần lưu ý đó là:
        </div>
        <div>
            <ul>
                @foreach ($explain['details'][7]['lessThan'] as $option)
                    @php
                        $tempValue = round($explain['details'][7]['result'][2][$option] - $explain['details'][7]['result'][1][$option], 2);
                    @endphp

                    <li>{{ ($tempValue > 0) ? 'Gia tăng' : 'Giảm bớt' }} tỉ trọng của loại hình {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ $tempValue }} điểm) tương ứng với năng lực cạnh tranh bằng {{ $explain['all']->where('option', $option)->first()->nang_luc_canh_tranh }}</li>
                @endforeach
            </ul>
        </div>

    @endif

    <div>
        <h4>MỨC ĐỘ NHẤT QUÁN CỦA VĂN HÓA</h4>
    </div>

    <div>
        Mức độ nhất quán của văn hóa doanh nghiệp được thể hiện qua sự nhất quán của những yếu tố thành phần. Có nghĩa là giá trị lớn nhất của từng yếu tố tạo nên văn hóa doanh nghiệp bao gồm: Đặc điểm nổi trội, Phong cách lãnh đạo, Quản lý nhân viên, Sự gắn kết, Chiến lược, Tiêu chí thành công cần có sự tương đồng.
    </div>

    <div>
        Các nghiên cứu chỉ ra rằng, các doanh nghiệp thành công có mức độ tương đồng cao, thể hiện tính nhất quán của văn hóa. Họ gặp ít xung đột và mẫu thuẫn hơn.
    </div>

    <div>
        Những doanh nghiệp có mức độ nhất quán thấp, thường trải qua nhiều xung đột và mâu thuẫn hơn. Từ đó kích thích nhận thức về sự thay đổi. Để tạo ra sự thay đổi, doanh nghiệp cần dành thời gian để tranh luận, tìm ra những sự khác biệt về quan điểm trong 6 yếu tố kể trên.
    </div>

    <div>
        Để kiểm tra mức độ nhất quán, bạn vui lòng sử dụng bộ lọc để chọn các loại biểu đồ tương ứng với 6 yếu tố nội tại của doanh nghiệp bạn.
    </div>

    <div>
        Để nhận tư vấn chuyên sâu hơn, vui lòng liên hệ với Senplus.
    </div>

    <div>
        <h4>MỨC ĐỘ PHÙ HỢP CỦA VĂN HÓA TRONG THỜI GIAN QUA</h4>
    </div>

    <div>
        Theo lý thuyết của khung năng lực cạnh tranh, văn hóa được coi là phù hợp khi các yếu tố cấu thành nó phù hợp.
    </div>

    <div>
        Như vậy, sau khi nghiên cứu kỹ lưỡng trường hợp của {{ $explain['company_name'] }}, với tổng điểm là {{ $explain['avgPercentMatch'] }}%. Văn hóa trong thời gian qua là {{ \App\Helpers::getMatchName($explain['avgPercentMatch']) }} theo nhận định của nhóm.
    </div>
