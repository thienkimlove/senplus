@extends('frontend.layout')

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
    @include('frontend.header_user')

    <main>
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

                <div class="topOfBox">
                    <h3 class="turnName">Báo cáo tổng quan</h3>
                    <a href="javascript:void(0)" class="myBtn" title="Tạo chiến dịch" >+ Tạo chiến dịch</a>
                    <form action="javascript:void(0)" class="filterData">
                        <input type="text" placeholder="Lọc dữ liệu" id="inputSearchDemo">
                        <input id="survey_id" type="hidden" name="survey_id" value="{{ $survey->id }}">
                        <div id="filterDataBox">
                            <div class="objectTest">
                                @if (auth()->user()->level == \App\Helpers::FRONTEND_ADMIN_LEVEL)
                                <h3 class="title">Đối tượng khảo sát</h3>
                                <div class="selectGroup">
                                    @foreach ($survey->company->filters as $filter)
                                        <select name="{{ $filter->id }}" multiple class="multiSeclect filterSelect">
                                            @foreach ($filter->options as $option)
                                                <option class="option" value="{{ $option['attr_value'] }}">
                                                    {{ $option['attr_value'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            <div class="typeOfChart">
                                <h3 class="title">Loại biểu đồ</h3>
                                @foreach (\App\Helpers::mapOrder() as $index => $value)
                                    <select name="choose_type" id="chartKind">
                                        <option class="option" value="{{ $index }}">{{ $value }}</option>
                                    </select>
                                @endforeach
                            </div>
                            <button id="filerSelectSubmit" class="btnFilter myBtn">Xem</button>
                        </div>
                    </form>
                </div>

                <div class="box resultBox">
                    <div class="txt">* Sử dụng bộ lọc dữ liệu để nhận kết quả đa chiều</div>
                    <div class="tableAndChart">
                        <div class="leftSide">
                            <table class="tableResult">
                                <thead>
                                <tr>
                                    <th id="titleTable">Loại hình <br>VHDN</th>
                                    <th>Đánh giá <br>(hiện tại)</th>
                                    <th>Mong muốn <br>(tuong lai)</th>
                                    <th>Chênh lệch</th>
                                </tr>
                                </thead>
                                <tbody id="mainTableBody">
                                    @include('frontend.partials.table', ['result' => $result])
                                </tbody>
                            </table>
                        </div>
                        <div class="rightSide">
                            <h3 class="title" id="titleRight">Loại hình Văn hóa doanh nghiệp</h3>
                            <div class="name">[Tên]</div>
                            <div class="content">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                    @if ($explain)
                    <article class="articleResult" id="explainText">
                        @include('frontend.partials.explain', ['explain' => $explain])
                    </article>
                    @endif
                </div>
            </div>
        </div>
    </main>

    @include('frontend.footer_user')
    </body>
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

        function makeChart(ctx, mapOption, mapRound, eResult) {

            console.log("round2 option1");
            console.log(eResult[2]['option1']);

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
                            data: [null, eResult[1]['option2'], null, eResult[1]['option3'], null, eResult[1]['option4'], null, eResult[1]['option1']]
                        },
                        {
                            label: mapRound[2],
                            //backgroundColor: 'pink',
                            borderColor: 'pink',
                            data: [null, eResult[2]['option2'], null, eResult[2]['option3'], null, eResult[2]['option4'], null, eResult[2]['option1']]
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


        $(document).ready(function(){
            makeChart(ctx, mapOption, mapRound, result);
            $('#filerSelectSubmit').click(function(){
                let surveyId = $('#survey_id').val();
                let chooseType = $('#chartKind').val();

                let checkboxValues = [];

                $('.filterSelect').each(function () {
                    checkboxValues.push(this.name + '||' + this.value);
                });
                let chooseCustomers = checkboxValues.toString(); //Output Format: 1,2,3

                $.post('{{ route('frontend.filter') }}', {
                    survey_id : surveyId,
                    choose_type: chooseType,
                    choose_customers : chooseCustomers
                }, function(res) {
                    if (!res.error) {
                        console.log(res.result);
                        makeChart(ctx, mapOption, mapRound, res.result);
                        $('#explainText').hide();
                        $('#titleTable').text(res.title);
                        $('#titleRight').text(res.title);
                        $('#mainTableBody').html(res.body);
                    }
                });
            });
        });

    </script>
@endsection