@extends('frontend.layout')

@section('content')
    <div id="root">
        <div class="Root_1Kcx">

            @include('frontend.partials.header')

            <main>
                <div class="fixCen flex-between">
                    <div class="showTurn">
                        <h2 class="title">Tóm tắt hồ sơ {{ $survey->company->name }}</h2>
                    </div>

                    <div class="selectGroup mt50">
                        <h3 class="title">Bộ lọc dữ liệu</h3>
                        <form action="javascript:void(0)" id="filerSelect">

                            <input id="survey_id" type="hidden" name="survey_id" value="{{ $survey->id }}">

                            @if (auth()->user()->level == \App\Helpers::FRONTEND_ADMIN_LEVEL)

                            <div class="objectTest">
                                <div class="title">Đối tượng khảo sát</div>
                                @foreach ($survey->company->filters as $filter)

                                    @foreach ($filter->options as $option)
                                        <div class="input-group">
                                            <input type="checkbox" value="{{ $filter->id }}||{{ $option['attr_value'] }}"> {{ $option['attr_value'] }}
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>

                            @endif

                            <div class="typeOfChart">
                                <div class="title">Loại biểu đồ</div>

                                @foreach (\App\Helpers::mapOrder() as $index => $value)
                                <div class="input-group">
                                    <input type="radio" name="choose_type" value="{{ $index }}" /> {{ $value }}
                                </div>
                                @endforeach
                            </div>
                            <button id="filerSelectSubmit" class="btnFilter myBtn">Xem</button>
                        </form>
                    </div>
                    <div class="leftSide mt50 leftSideResult">
                        <table class="tableResult">
                            <thead>
                            <tr>
                                <th id="titleTable">Loại hình Văn hóa DN</th>
                                <th>Đánh giá <br>(hiện tại)</th>
                                <th>Mong muốn <br>(tương lai)</th>
                                <th>Chênh lệch</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(['option1', 'option2', 'option3', 'option4'] as $index => $opt)
                                <tr>
                                    <td>{{ \App\Helpers::mapOption()[$opt] }}</td>
                                    <td>{{ round($result[1][$opt], 2) }}</td>
                                    <td>{{ round($result[2][$opt], 2)}}</td>
                                    <td>{{ round($result[2][$opt] - $result[1][$opt], 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="rightSide mt50 rightSideResult">
                        <h3 id="titleRight" class="title">Loại hình Văn hóa DN</h3>
                        <div class="contain mt50">
                            <canvas id="myChart"></canvas>

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

        function makeChart(ctx, mapOption, mapRound, result) {
            let chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'radar',

                // The data for our dataset
                data: {
                    labels: [
                        'Linh hoạt',
                        mapOption["option4"],
                        'Hướng ngoại',
                        mapOption["option2"],
                        'Ổn định',
                        mapOption["option3"],
                        'Hướng nội',
                        mapOption["option1"]
                    ],
                    datasets: [
                        {
                            label: mapRound[1],
                            //backgroundColor: 'green',
                            borderColor: 'green',
                            data: [null, result[1]['option4'], null, result[1]['option2'], null, result[1]['option3'], null, result[1]['option1']]
                        },
                        {
                            label: mapRound[2],
                            //backgroundColor: 'pink',
                            borderColor: 'pink',
                            data: [null, result[2]['option4'], null, result[2]['option2'], null, result[2]['option3'], null, result[2]['option1']]
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
        }

        let ctx = document.getElementById('myChart').getContext('2d');
        let result = JSON.parse(' @json($result) ');
        let mapOption = JSON.parse(' @json(\App\Helpers::mapOption()) ');
        let mapRound = JSON.parse(' @json(\App\Helpers::mapRound()) ');


        makeChart(ctx, mapOption, mapRound, result);

        $(document).ready(function(){
            $('#filerSelectSubmit').click(function(){
                let surveyId = $('#survey_id').val();
                let chooseType = $('input[name=choose_type]:checked', '#filerSelect').val();

                let checkboxValues = [];

                $('#filerSelect input[type=checkbox]:checked').each(function () {
                    checkboxValues.push(this.value);
                });
                let chooseCustomers = checkboxValues.toString(); //Output Format: 1,2,3

                $.post('{{ route('frontend.filter') }}', {
                    survey_id : surveyId,
                    choose_type: chooseType,
                    choose_customers : chooseCustomers
                }, function(res) {
                    if (!res.error) {
                        makeChart(ctx, mapOption, mapRound, res.result);
                        $('#titleTable').text(res.title);
                        $('#titleRight').text(res.title);
                    }
                });
            });
        });

    </script>
@endsection
