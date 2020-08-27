@extends('frontend.layout')


@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
<div class="row justify-content-md-center">
    <div class="col-xl-8">
        <!--begin:: Widgets/Survey List-->
        <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Kết Quả
                    </h3>
                </div>

            </div>

            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div class="kt-widget5">
                        <div class="kt-widget5__item">
                            <div class="kt-widget5__content">

                                <div class="kt-widget5__section">

                                    <canvas id="myChart" style="width: 100%; height: auto"></canvas>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!--end:: Widgets/Survey List-->
    </div>
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


        function getArrayValue(object, position) {

            $.each(object, function( index, value ) {
                if (parseInt(index) === position) {
                    return value;
                }
            });
            return null;
        }

        function getArrayDeepValue(object, position, opt) {

            $.each(object, function( index, value ) {
                if (parseInt(index) === position) {
                    $.each(value, function( index2, value2 ) {
                        if (index2 === opt) {
                            return value2;
                        }
                    });
                }
            });
            return null;
        }

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


        console.log(getArrayDeepValue(result, 2, 'option1'));
        console.log(getArrayValue(mapOption, 1));


        let chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'radar',

            // The data for our dataset
            data: {
                labels: ['Y1', getArrayValue(mapOption, 1), 'X1', getArrayValue(mapOption, 2), 'Y2', getArrayValue(mapOption, 3), 'X2', getArrayValue(mapOption, 4)],
                datasets: [
                    {
                        label: mapRound[1],
                        //backgroundColor: 'green',
                        borderColor: 'green',
                        data: [null, getArrayDeepValue(result, 1, 'option1'), null, getArrayDeepValue(result, 1, 'option2'), null, getArrayDeepValue(result, 1, 'option3'), null, getArrayDeepValue(result, 1, 'option4')]
                    },
                    {
                        label: mapRound[2],
                        //backgroundColor: 'pink',
                        borderColor: 'pink',
                        data: [null, getArrayDeepValue(result, 2, 'option1'), null, getArrayDeepValue(result, 2, 'option2'), null, getArrayDeepValue(result, 2, 'option3'), null, getArrayDeepValue(result, 2, 'option4')]
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