@extends('frontend.layout')

@section('content')
    <div id="root">
        <div class="Root_1Kcx">

            @include('frontend.partials.header')

            <main>
                <div class="fixCen flex-between">
                    <div class="myBtn btnTest" title="Nhận kết quả">Nhận kết quả</div>
                    <div class="showTurn"><h2 class="title">Tóm tắt hồ sơ css group</h2></div>
                    <div class="selectGroup mt50" style="display: none">
                        <h3 class="title">Bộ lọc dữ liệu</h3>
                        <form action="" id="filerSelect">
                            <div class="objectTest">
                                <div class="title">Đối tượng khảo sát</div>
                                <div class="input-group"><input type="checkbox"> CEO</div>
                                <div class="input-group"><input type="checkbox"> Quản lý cấp cao</div>
                                <div class="input-group"><input type="checkbox"> Quản lý cấp trung</div>
                                <div class="input-group"><input type="checkbox"> Nhân viên</div>
                                <div class="input-group"><input type="checkbox"> Khối nội chính</div>
                                <div class="input-group"><input type="checkbox"> Khối kinh doanh</div>
                                <div class="input-group"><input type="checkbox"> Tập thể</div>
                            </div>
                            <div class="typeOfChart">
                                <div class="title">Loại biểu đồ</div>
                                <div class="input-group"><input type="checkbox"> Đăc điểm nổi trội</div>
                                <div class="input-group"><input type="checkbox"> Phong cách lãnh đạo</div>
                                <div class="input-group"><input type="checkbox"> Quản lý nhân viên</div>
                                <div class="input-group"><input type="checkbox"> Sự gắn kết</div>
                                <div class="input-group"><input type="checkbox"> Chiến lược</div>
                                <div class="input-group"><input type="checkbox"> Tiêu chí thành công</div>
                                <div class="input-group"><input type="checkbox"> Loại hình VHDN</div>
                            </div>
                            <button class="btnFilter myBtn">Xem</button>
                        </form>
                    </div>
                    <div class="leftSide mt50 leftSideResult">
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
                                    <td>{{ $result[1][$opt] }}</td>
                                    <td>{{ $result[2][$opt] }}</td>
                                    <td>{{ $result[1][$opt] - $result[2][$opt] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="rightSide mt50 rightSideResult">
                        <h3 class="title">Loại hình Văn hóa doanh nghiệp</h3>
                        <div class="contain mt50">
                            <canvas id="myChart" style="width: 100%; height: auto"></canvas>

                        </div>
                    </div>
                    <div class="bottom mt50 flex-between">
                        <a href="javascript:void(0)" class="myBtn btnBack" title="Quay lại" onclick="window.history.back()">Quay lại</a>
                    </div>
                </div>
            </main>

        </div>
    </div>
@endsection

@section('after_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script>
        let ctx = document.getElementById('myChart').getContext('2d');

        let result = JSON.parse(' @json($result) ');
        let mapOrder = JSON.parse(' @json(\App\Helpers::mapOrder()) ');
        let mapOption = JSON.parse(' @json(\App\Helpers::mapOption()) ');
        let mapRound = JSON.parse(' @json(\App\Helpers::mapRound()) ');

        console.log(mapOption);

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
                labels: ['Y1', mapOption["option1"], 'X1', mapOption["option2"], 'Y2', mapOption["option3"], 'X2', mapOption["option4"]],
                datasets: [
                    {
                        label: mapRound[1],
                        //backgroundColor: 'green',
                        borderColor: 'green',
                        data: [null, result[1]['option1'], null, result[1]['option2'], null, result[1]['option3'], null, result[1]['option4']]
                    },
                    {
                        label: mapRound[2],
                        //backgroundColor: 'pink',
                        borderColor: 'pink',
                        data: [null, result[2]['option1'], null, result[2]['option2'], null, result[2]['option3'], null, result[2]['option4']]
                    }
                ],
            },

            // Configuration options go here
            options: {
                responsive: true,
                legend: {
                    position: 'bottom'
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
