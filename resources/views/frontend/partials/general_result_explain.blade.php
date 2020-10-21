<article class="articleResult">

    <div>
        Trên đây là nhận thức về văn hóa {{ $explain['name'] }} của nhóm đối tượng mà anh/chị đã chọn.
        Trên biểu đồ, đường màu xanh thể hiện Văn hóa hiện tại, đường màu đỏ thể hiện Văn hóa mong muốn.
        Kết quả này có ý nghĩa như sau:
    </div>


    <div>
        <h4>LOẠI HÌNH VĂN HÓA NỔI TRỘI</h4>
    </div>


    <div>
        Văn hóa nổi trội quyết định năng lực cạnh tranh chính của doanh nghiệp, được xác định bởi giá trị lớn nhất của mỗi cột. Một doanh nghiệp có văn hóa đồng nhắt và mạnh mẽ thường là khi giá trị lớn nhất đó thực sự nổi trội so với phần còn lại. Nghiên cứu của chúng tôi cho thấy, nhân viên của những doanh nghiệp như vậy luôn có ý thức rõ ràng về mục tiêu, đồng nhất về nỗ lực và hướng đi.
    </div>

    <div>
        Giá trị lớn thứ 2 của mỗi cột miêu tả văn hóa bổ trợ. Thực tế là không có doanh nghiệp nào chỉ tập trung vào 1 loại văn hóa duy nhất. Văn hóa bổ trợ có vai trò tận dụng những ưu điểm và hạn chế nhược điểm của văn hóa nổi trội, không phải là năng lực cạnh tranh chính của doanh nghiệp.
    </div>

    <div>
        <b>Như vậy, trong trường hợp này:</b>
    </div>

    <div>
        Hiện tại, văn hóa nối trội của ({{ $explain['name'] }}) là {{ $explain['explainMax']->ten_van_hoa }} – {{ $explain['maxValue'] }} điểm. Năng lực cạnh tranh chính của doanh nghiệp là {{ $explain['explainMax']->nang_luc_canh_tranh }}. (Tham khảo phụ lục). Giá trị chính mà loại hình văn hóa này đem lại là {{ $explain['explainMax']->gia_tri_dem_lai }} (Tham khảo phụ lục)
    </div>

    <div>
        Văn hóa bổ trợ là {{ $explain['explainSecond']->ten_van_hoa }} – {{ $explain['secondValue'] }}.
    </div>

    <div>
        <b>Kết luận: Nhận thức của nhóm đối tượng khảo sát về văn hóa hiện tại của ({{ $explain['name'] }}) được diễn giải như sau:</b>
    </div>

    <div>
        <h4>Xu hướng</h4>
    </div>

    <div>
        <ul>
            @foreach ($explain['explainMax']->xu_huong as $k)
                <li>{{ $k['content'] }}</li>
            @endforeach
        </ul>
    </div>

    <div>
        <h4>Ưu Điểm</h4>
    </div>

    <div>
       <ul>
           @foreach ($explain['explainMax']->uu_diem as $k)
               <li>{{ $k['content'] }}</li>
           @endforeach
       </ul>
    </div>

    <div>
        <h4>Nhược điểm</h4>
    </div>

    <div>
        <ul>
            @foreach ($explain['explainMax']->nhuoc_diem as $k)
                <li>{{ $k['content'] }}</li>
            @endforeach
        </ul>
    </div>

    <div>
        <h4>SỰ KHÁC NHAU GIỮA VĂN HÓA HIỆN TẠI VÀ MONG MUỐN</h4>
    </div>

    <div>
        Sự khác nhau giữa văn hóa hiện tại và mong muốn thể hiện nhu cầu thay đổi của nhóm đối tượng khảo sát. Những giá trị lớn hơn 10 theo lý thuyết của Khung năng lực cạnh tranh, thể hiện sự quan trọng và mức độ cấp thiết của các hành động nhằm tạo ra sự thay đổi đó.
    </div>

    <div>
        Những giá trị nhỏ hơn 10 thể hiện cho những sự thay đổi nhỏ mà doanh nghiệp cần lưu ý. Doanh nghiệp cần tổ chức những cuộc trao đổi giữa đội ngũ lãnh đạo và nhóm đối tượng khảo sát để đi sâu tìm hiểu điều chúng ta muốn thay đổi là gì.
    </div>

    <div>
        Đối với những thay đổi cấp thiết, doanh nghiệp có thể liên hệ với Senplus để nhận tư vấn chuyên sâu hoặc kết nối những chuyên gia trong lĩnh vực mà mình mong muốn.
    </div>

    <div>
        <b>Như vậy, trong trường hợp này:</b>
    </div>

    @if ($explain['moreThan'])
        <div>
            Có {{ count($explain['moreThan']) }} sự thay đổi quan trọng đó là:
        </div>
        <div>
            <ul>
                @foreach ($explain['moreThan'] as $option)
                    @php
                        $tempValue = round($explain['result'][2][$option] - $explain['result'][1][$option]);
                        //dd($explain['explainAll']->where('option', $option));
                    @endphp

                    <li>{{ ($tempValue > 0) ? 'Gia tăng' : 'Giảm bớt' }} tỉ trọng của loại hình {{ $explain['explainAll']->where('option', $option)->first()->ten_van_hoa }} ({{ abs($tempValue) }} điểm) tương ứng với năng lực cạnh tranh bằng {{ $explain['explainAll']->where('option', $option)->first()->nang_luc_canh_tranh }}</li>
                @endforeach
            </ul>
        </div>

    @endif

    <div>
        <h4>MỨC ĐỘ NHẤT QUÁN CỦA VĂN HÓA</h4>
    </div>

    <div>
        Mức độ nhất quán của văn hóa doanh nghiệp được thể hiện qua sự nhất quán của những yếu tố nội tại tạo nên nó. Có nghĩa là giá trị lớn nhất của từng yếu tố tạo nên văn hóa doanh nghiệp bao gồm: Đặc điểm nổi trội, Phong cách lãnh đạo, Quản lý nhân viên, Sự gắn kết, Chiến lược, Tiêu chí thành công cần có sự tương đồng.
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





    <div class="noiTroi">
        <p>
            Trên đây là kết quả khảo sát Văn hóa doanh nghiệp ({{ $explain['name'] }}). Trên biểu đồ, đường màu xanh thể hiện Văn hóa hiện tại, đường màu đỏ thể hiện Văn hóa mong muốn. Kết quả này có ý nghĩa như sau:
        </p>
        <br/>
        <h4>LOẠI HÌNH VĂN HÓA NỔI TRỘI</h4><br/>
        <p>
            Văn hóa nổi trội quyết định năng lực cạnh tranh chính của doanh nghiệp, được xác định bởi giá trị lớn nhất của mỗi cột. Một doanh nghiệp có văn hóa đồng nhắt và mạnh mẽ thường là khi giá trị lớn nhất đó thực sự nổi trội so với phần còn lại. Nghiên cứu của chúng tôi cho thấy, nhân viên của những doanh nghiệp như vậy luôn có ý thức rõ ràng về mục tiêu, đồng nhất về nỗ lực và hướng đi.
        </p>
        <p>
            Giá trị lớn thứ 2 của mỗi cột miêu tả văn hóa bổ trợ. Thực tế là không có doanh nghiệp nào chỉ tập trung vào 1 loại văn hóa duy nhất. Văn hóa bổ trợ có vai trò tận dụng những ưu điểm và hạn chế nhược điểm của văn hóa nổi trội, không phải là năng lực cạnh tranh chính của doanh nghiệp.
        </p>
        <p><br/>
        <h5>Như vậy, trong trường hợp này:</h5><br/>
        Hiện tại, văn hóa nối trội của ({{ $explain['name'] }}) là {{ $explain['explainMax']->ten_van_hoa }} – {{ $explain['maxValue'] }} điểm. Năng lực cạnh tranh chính của doanh nghiệp là {{ $explain['explainMax']->nang_luc_canh_tranh }}. (Tham khảo phụ lục). Giá trị chính mà loại hình văn hóa này đem lại là {{ $explain['explainMax']->gia_tri_dem_lai }} (Tham khảo phụ lục)
        Văn hóa bổ trợ là {{ $explain['explainSecond']->ten_van_hoa }} – {{ $explain['secondValue'] }}.

        </p><br/>

        <h5>Kết luận: Văn hóa hiện tại của ({{ $explain['name'] }}) có đặc điểm như sau:</h5><br />

        <div class="xuHuong">
            <h4>Xu hướng</h4><br>
            <ul>
                @foreach ($explain['explainMax']->xu_huong as $k)
                    <li>{{ $k['content'] }}</li>
                @endforeach
            </ul>
        </div>
        <br>
        <div class="uuDiem">
            <h4>Ưu Điểm</h4><br>
            <ul>
                @foreach ($explain['explainMax']->uu_diem as $k)
                    <li>{{ $k['content'] }}</li>
                @endforeach
            </ul>
        </div>
        <br>
        <div class="nhuocDiem">
            <h4>Nhược điểm</h4><br>
            <ul>
                @foreach ($explain['explainMax']->nhuoc_diem as $k)
                    <li>{{ $k['content'] }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="khacNhau">
        <h4>SỰ KHÁC NHAU GIỮA VĂN HÓA HIỆN TẠI VÀ MONG MUỐN</h4><br/>
        <p>
            Các chỉ số ở cột Chênh lệch mô tả mức độ khác nhau giữa văn hóa hiện tại và văn hóa mà đối tượng khảo sát mong muốn. Những giá trị lớn hơn 10 theo lý thuyết của Khung năng lực cạnh tranh, thể hiện sự quan trọng và mức độ cấp thiết của các hành động nhằm tạo ra sự thay đổi đó.
        </p>
        <p>
            Những giá trị nhỏ hơn 10 thể hiện cho những sự thay đổi nhỏ hơn. Doanh nghiệp cần tổ chức những cuộc trao đổi giữa đội ngũ lãnh đạo và nhóm đối tượng khảo sát để đi sâu tìm hiểu điều chúng ta muốn thay đổi là gì.

        <p>
            Sau khi thống nhất được những sự thay đổi cần thiết, doanh nghiệp dựa vào bộ giải pháp mà chúng tôi gợi ý trong phần Download để đưa ra những hành động cụ thể.
        </p>
        <p>
            Đối với những thay đổi quan trọng, doanh nghiệp có thể liên hệ với Senplus để nhận tư vấn chuyên sâu hoặc kết nối những chuyên gia trong lĩnh vực mà mình mong muốn.
        </p>
        @if ($explain['moreThan'])
            <br/>
            <div>
                <h5>Có {{ count($explain['moreThan']) }} sự thay đổi quan trọng đó là:</h5><br/>
                <ul>
                    @foreach ($explain['moreThan'] as $option)
                        @php
                            $tempValue = round($explain['result'][2][$option] - $explain['result'][1][$option]);
                            //dd($explain['explainAll']->where('option', $option));
                        @endphp


                        <li>{{ ($tempValue > 0) ? 'Gia tăng' : 'Giảm bớt' }} năng lực cạnh tranh dựa vào {{ $explain['explainAll']->where('option', $option)->first()->nang_luc_canh_tranh }} của loại hình {{ $explain['explainAll']->where('option', $option)->first()->ten_van_hoa }} ({{ abs($tempValue) }} điểm)</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="nhatQuan">
        <h4>MỨC ĐỘ NHẤT QUÁN CỦA VĂN HÓA</h4><br/>
        <p>
            Mức độ nhất quán của văn hóa doanh nghiệp được thể hiện qua sự nhất quán của những yếu tố nội tại tạo nên nó. Có nghĩa là giá trị nổi trội của 6 yếu tố bao gồm: Đặc điểm nổi trội, Phong cách lãnh đạo, Quản lý nhân viên, Sự gắn kết, Chiến lược, Tiêu chí thành công cần có sự tương đồng.
        </p>
        <p>
            Các nghiên cứu chỉ ra rằng, các doanh nghiệp thành công có mức độ tương đồng cao, thể hiện tính nhất quán của văn hóa. Họ gặp ít xung đột và mẫu thuẫn hơn.
        </p>
        <p>
            Những doanh nghiệp có mức độ nhất quán thấp, thường trải qua nhiều xung đột và mâu thuẫn hơn. Từ đó kích thích nhận thức về sự thay đổi. Để tạo ra sự thay đổi, doanh nghiệp cần dành thời gian để tranh luận, tìm ra những sự khác biệt về quan điểm trong 6 yếu tố kể trên.
        </p>
        <p>
            Để kiểm tra mức độ nhất quán, bạn vui lòng sử dụng bộ lọc để chọn các loại biểu đồ tương ứng với 6 yếu tố nội tại của doanh nghiệp bạn.
        </p>
        <p>
            Để nhận tư vấn chuyên sâu hơn, vui lòng liên hệ với Senplus.
        </p>

    </div>
</article>