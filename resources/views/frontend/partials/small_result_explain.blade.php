    <div>
        <h4>LOẠI HÌNH VĂN HÓA NỔI TRỘI</h4>
    </div>

    <div>
        Văn hóa nổi trội quyết định năng lực cạnh tranh chính của doanh nghiệp, được xác định bởi giá trị lớn nhất của mỗi cột. Một doanh nghiệp có văn hóa đồng nhất và mạnh mẽ thường là khi giá trị lớn nhất đó thực sự nổi trội so với phần còn lại. Nghiên cứu của chúng tôi cho thấy, nhân viên của những doanh nghiệp như vậy luôn có ý thức rõ ràng về mục tiêu, đồng nhất về nỗ lực và hướng đi.
    </div>

    <div>
        Ở một doanh nghiệp có văn hóa đồng nhất và mạnh mẽ, giá trị lớn nhất đó sẽ thực sự nổi trội so với phần còn lại. Nghiên cứu của chúng tôi cho thấy, nhân viên ở những doanh nghiệp như vậy luôn có ý thức rõ ràng về mục tiêu chung, đồng nhất với mục tiêu cá nhân, nỗ lực và hướng đi.
    </div>

    <div>
        <b>Như vậy, trong trường hợp này:</b>
    </div>

    <div>
        Văn hóa nối trội của doanh nghiệp trong thời gian qua theo đánh giá của anh/chị là {{ $explain['details'][7]['explainMax']->ten_van_hoa }} – {{ $explain['details'][7]['maxValue'] }} điểm. Năng lực cạnh tranh chính của doanh nghiệp là {{ $explain['details'][7]['explainMax']->nang_luc_canh_tranh }}. Giá trị chính mà loại hình văn hóa này đem lại là {{ $explain['details'][7]['explainMax']->gia_tri_dem_lai }}.
    </div>

    <div>
        <b>Kết luận: Văn hóa của doanh nghiệp nơi anh/chị đang làm việc theo sự đánh giá cá nhân có đặc điểm như sau:</b>
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
        Khoảng cách giữa văn hóa hiện tại và mong muốn thể hiện nhu cầu thay đổi của cá nhân anh/chị về văn hóa doanh nghiệp. Những giá trị lớn hơn 10 theo lý thuyết của khung giá trị cạnh tranh, thể hiện sự quan trọng và mức độ cấp thiết của các hành động nhằm tạo ra sự thay đổi đó.
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

                    <li>{{ ($tempValue > 0) ? 'Gia tăng' : 'Giảm bớt' }} tỉ trọng của loại hình {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ $tempValue }} điểm)</li>
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

                    <li>{{ ($tempValue > 0) ? 'Gia tăng' : 'Giảm bớt' }} tỉ trọng của loại hình {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ $tempValue }} điểm)</li>
                @endforeach
            </ul>
        </div>

    @endif
