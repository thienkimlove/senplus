@extends('frontend_store_2.layout')

@section('before_header')
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrapv4.5.min.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap-select.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleSurveyAction.css">

    <title data-react-helmet="true">Báo cáo chiến dịch</title>

    <script src="/frontend/assets/js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/page_all.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/page_result.js" type="text/javascript"></script>
@endsection    

@section('content')
    <body class="bodyHomeUser">
    @include('frontend_store_2.header_user')

    <main>
        @if ($survey->company_id)
            <div class="sortInfoBlock">
                <div class="fixCen">
                    <div class="avatar">
                        <img src="{{ $survey->company->logo ? url($survey->company->logo) : '/frontend/assets/img/demo-logo1.jpg' }}" alt="" class="imgFull">
                    </div>
                    <div class="txt">
                        {{ $survey->company->name }}
                    </div>
                </div>
            </div>
        @else
            <div class="sortInfoBlock">
                <div class="fixCen">
                    <div class="avatar">
                        <img src="{{ auth()->user()->avatar? url(auth()->user()->avatar) : '/frontend/assets/img/demo-logo1.jpg' }}" alt="" class="imgFull">
                    </div>
                    <div class="txt">
                        {{ auth()->user()->name }}
                    </div>
                </div>
            </div>
        @endif
        <div class="topBlock">
            <div class="fixCen hasBefore">
                <div class="descriptionRusult">
                    <p class="blue2 fw18px">
                        [{{ $survey->name }}]
                    </p>
                    <p>Thời gian thực hiện: [{{ $survey->start_time? $survey->start_time->format('d/m/Y') : "" }}  - {{ $survey->end_time? $survey->end_time->format('d/m/Y') : "" }}]</p>
                    <p>Đối tượng: [tương ứng với đối tượng bộ lọc]</p>
                    <p>Số lượng: [số - tương ứng với sl của đối tượng lọc đã hoàn thành ks]</p>
                </div>
            </div>
        </div>
        <div class="contentBlock">
            <div class="fixCen">

                <div class="box resultBox">
                    <div class="txt">* Sử dụng bộ lọc dữ liệu để nhận kết quả đa chiều</div>
                    <div class="tableAndChart">
                        <div class="leftSide">
                            <table class="tableResult">
                                <thead>
                                <tr>
                                    <th>Loại hình <br>VHDN</th>
                                    <th>Đánh giá <br>(hiện tại)</th>
                                    <th>Mong muốn <br>(tuong lai)</th>
                                    <th>Chênh lệch</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(['option1', 'option2', 'option3', 'option4'] as $index => $opt)
                                    <tr>
                                        <td>{{ \App\Helpers::mapOption()[$opt] }}</td>
                                        <td>{{ round($result[1][$opt], 2) }}</td>
                                        <td>{{ round($result[2][$opt], 2) }}</td>
                                        <td>{{ round($result[2][$opt] - $result[1][$opt], 2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="rightSide">
                            <h3 class="title">Loại hình Văn hóa doanh nghiệp</h3>
                            <div class="name">[Tên]</div>
                            <div class="content">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                    @if ($explain)
                    <article class="articleResult">
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
                    @endif
                </div>
            </div>
        </div>
    </main>

    @include('frontend_store_2.footer_user')
    </body>
@endsection

@section('after_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script>
        let ctx = document.getElementById('myChart').getContext('2d');

        let result = JSON.parse(' @json($result) ');
        let mapOption = JSON.parse(' @json(\App\Helpers::mapOption()) ');
        let mapRound = JSON.parse(' @json(\App\Helpers::mapRound()) ');

        drawArrow = function(context, fromx, fromy, tox, toy) {
            var headlen = 10;
            var dx = tox - fromx;
            var dy = toy - fromy;
            var angle = Math.atan2(dy, dx);
            context.moveTo(fromx, fromy);
            context.lineTo(tox, toy);
            context.lineTo(tox - headlen * Math.cos(angle - Math.PI / 6), toy - headlen * Math.sin(angle - Math.PI / 6));
            context.moveTo(tox, toy);
            context.lineTo(tox - headlen * Math.cos(angle + Math.PI / 6), toy - headlen * Math.sin(angle + Math.PI / 6));
        }



        let chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'radar',

            // The data for our dataset
            data: {
                labels: [
                    'Linh hoạt',
                    mapOption["option2"],
                    'Hướng ngoại',
                    mapOption["option3"],
                    'Ổn định',
                    mapOption["option4"],
                    'Hướng nội',
                    mapOption["option1"]
                ],
                datasets: [
                    {
                        label: mapRound[1],
                        //backgroundColor: 'green',
                        borderColor: 'green',
                        data: [null, result[1]['option2'], null, result[1]['option3'], null, result[1]['option4'], null, result[1]['option1']]
                    },
                    {
                        label: mapRound[2],
                        //backgroundColor: 'pink',
                        borderColor: 'pink',
                        data: [null, result[2]['option2'], null, result[2]['option3'], null, result[2]['option4'], null, result[2]['option1']]
                    }
                ],
            },

            // Configuration options go here
            options: {
                responsive: true,
                legend: {
                    position: 'top'
                },
                spanGaps: true,
            },
            plugins: [{
                beforeDraw: function(chart, options) {
                    var ctx = chart.chart.ctx;
                    var yaxis = chart.scales['scale'];
                    var paddingX = 0;
                    var paddingY = 0;

                    ctx.save();
                    ctx.beginPath();
                    ctx.strokeStyle = '#000000';
                    ctx.lineWidth = 1.75;

                    drawArrow(ctx, yaxis.xCenter, yaxis.yCenter, yaxis.xCenter - yaxis.drawingArea - paddingX, yaxis.yCenter);
                    drawArrow(ctx, yaxis.xCenter, yaxis.yCenter, yaxis.xCenter + yaxis.drawingArea + paddingX, yaxis.yCenter);
                    drawArrow(ctx, yaxis.xCenter, yaxis.yCenter, yaxis.xCenter, yaxis.yCenter - yaxis.drawingArea - paddingY);
                    drawArrow(ctx, yaxis.xCenter, yaxis.yCenter, yaxis.xCenter, yaxis.yCenter + yaxis.drawingArea + paddingY);

                    ctx.stroke();
                    ctx.restore();
                }
            }]

        });
    </script>
@endsection