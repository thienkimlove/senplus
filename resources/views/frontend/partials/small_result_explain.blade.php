    <div>
        Trên đây là nhận thức về văn hóa {{$explain['company_name'] }} của nhóm đối tượng mà anh/chị đã chọn.
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
        Hiện tại, văn hóa nối trội của ({{ $explain['company_name'] }}) là {{ $explain['details'][7]['explainMax']->ten_van_hoa }} – {{ $explain['details'][7]['maxValue'] }} điểm. Năng lực cạnh tranh chính của doanh nghiệp là {{ $explain['details'][7]['explainMax']->nang_luc_canh_tranh }}. (Tham khảo phụ lục). Giá trị chính mà loại hình văn hóa này đem lại là {{ $explain['details'][7]['explainMax']->gia_tri_dem_lai }} (Tham khảo phụ lục)
    </div>

    <div>
        Văn hóa bổ trợ là {{ $explain['details'][7]['explainSecond']->ten_van_hoa }} – {{ $explain['details'][7]['secondValue'] }}.
    </div>

    <div>
        <b>Kết luận: Nhận thức của nhóm đối tượng khảo sát về văn hóa hiện tại của ({{ $explain['company_name'] }}) được diễn giải như sau:</b>
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
        <h4>Ưu Điểm</h4>
    </div>

    <div>
       <ul>
           @foreach ($explain['details'][7]['explainMax']->uu_diem as $k)
               <li>{{ $k['content'] }}</li>
           @endforeach
       </ul>
    </div>

    <div>
        <h4>Nhược điểm</h4>
    </div>

    <div>
        <ul>
            @foreach ($explain['details'][7]['explainMax']->nhuoc_diem as $k)
                <li>{{ $k['content'] }}</li>
            @endforeach
        </ul>
    </div>
