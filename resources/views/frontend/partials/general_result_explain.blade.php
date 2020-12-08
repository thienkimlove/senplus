    <div>
        <h4>LOẠI HÌNH VĂN HÓA NỔI TRỘI</h4>
    </div>

    <div>
        Văn hóa nổi trội quyết định năng lực cạnh tranh chính của doanh nghiệp, được xác định bởi giá trị lớn nhất của mỗi cột.
    </div>

    <div>
        Ở một doanh nghiệp có văn hóa đồng nhất và mạnh mẽ, giá trị lớn nhất đó sẽ thực sự nổi trội so với phần còn lại. Nghiên cứu của chúng tôi cho thấy, nhân viên ở những doanh nghiệp như vậy luôn có ý thức rõ ràng về mục tiêu chung, đồng nhất với mục tiêu cá nhân, nỗ lực và hướng đi.
    </div>

    <div>
        <b>Như vậy, trong trường hợp này:</b>
    </div>

    <div>
        <span class="red-text">Văn hóa nối trội của {{ $explain['company_name'] }} trong thời gian qua theo đánh giá của nhóm là {{ $explain['details'][7]['explainMax']->ten_van_hoa }} – {{ $explain['details'][7]['maxValue'] }} điểm. Năng lực cạnh tranh chính của doanh nghiệp là {{ $explain['details'][7]['explainMax']->nang_luc_canh_tranh }}. Giá trị chính mà loại hình văn hóa này đem lại là {{ $explain['details'][7]['explainMax']->gia_tri_dem_lai }}</span>.
    </div>

    <div>
        <b>Kết luận: Văn hóa của {{ $explain['company_name'] }} theo đánh giá của nhóm có đặc điểm như sau:</b>
    </div>

    <div>
        <h4>Xu hướng</h4>
    </div>

    <div>
        <ul>
            @foreach ($explain['details'][7]['explainMax']->xu_huong as $k)
                <li>{{ $k['content'] }}</li>
            @endforeach
        </ul>
    </div>

    <div>
        <h4>Điểm mạnh</h4>
    </div>

    <div>
       <ul>
           @foreach ($explain['details'][7]['explainMax']->uu_diem as $k)
               <li>{{ $k['content'] }}</li>
           @endforeach
       </ul>
    </div>

    <div>
        <h4>Hạn chế</h4>
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
        Khoảng cách giữa văn hóa hiện tại và mong muốn thể hiện nhu cầu thay đổi của nhóm. Những giá trị lớn hơn 10 theo lý thuyết của khung giá trị cạnh tranh, thể hiện sự quan trọng và mức độ cấp thiết của các hành động nhằm tạo ra sự thay đổi đó.
    </div>

    <div>
        Những giá trị nhỏ hơn 10 thể hiện cho những nhu cầu thay đổi mà doanh nghiệp cần lưu ý. Doanh nghiệp nên tổ chức những cuộc trao đổi giữa đội ngũ lãnh đạo và cán bộ nhân viên để đi sâu tìm hiểu điều chúng ta muốn thay đổi là gì.
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

                    <li><span class="red-text">{{ ($tempValue > 0) ? 'Gia tăng' : 'Giảm bớt' }} tỉ trọng của loại hình {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ $tempValue }} điểm) tương ứng với năng lực cạnh tranh bằng {{ $explain['all']->where('option', $option)->first()->nang_luc_canh_tranh }}</span></li>
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

                    <li><span class="red-text">{{ ($tempValue > 0) ? 'Gia tăng' : 'Giảm bớt' }} tỉ trọng của loại hình {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ $tempValue }} điểm) tương ứng với năng lực cạnh tranh bằng {{ $explain['all']->where('option', $option)->first()->nang_luc_canh_tranh }}</span></li>
                @endforeach
            </ul>
        </div>

    @endif

    <div>
        <h4>MỨC ĐỘ NHẤT QUÁN CỦA VĂN HÓA</h4>
    </div>

    <div>
        Các nghiên cứu chỉ ra rằng, các doanh nghiệp thành công thể hiện tính nhất quán cao. Họ gặp ít xung đột và mâu thuẫn trong nội bộ.
    </div>

    <div>
        Những doanh nghiệp có mức độ nhất quán thấp, thường trải qua nhiều xung đột và mâu thuẫn hơn. Từ đó kích thích nhận thức về sự thay đổi. Để tạo ra sự thay đổi, doanh nghiệp cần dành thời gian để tranh luận, tìm ra những sự khác biệt về quan điểm trong 6 yếu tố kể trên.
    </div>

    <div>
        Chúng tôi sẽ tư vấn riêng hạng mục này.
    </div>

    <div>
        <h4>MỨC ĐỘ PHÙ HỢP CỦA VĂN HÓA TRONG THỜI GIAN QUA</h4>
    </div>

    <div>
        Như vậy, sau khi nghiên cứu kỹ lưỡng trường hợp của {{ $explain['company_name'] }}, với tổng điểm là <span class="red-text">{{ $explain['avgPercentMatch'] }}%</span>. 
    </div>

    <div>
        Văn hóa trong thời gian qua là {{ \App\Helpers::getMatchName($explain['avgPercentMatch']) }} theo nhận định của nhóm.
    </div>
