<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <script src="https://www.chartjs.org/samples/latest/utils.js"></script>
    </head>
    <body>
        <div class="flex-center full-height">


            <div class="content">

                <canvas id="myChart" style="width: 100%; height: auto"></canvas>

            </div>
        </div>
    </body>
    <script>
        let ctx = document.getElementById('myChart').getContext('2d');

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

        let utils = Samples.utils;

        utils.srand(110);

        function getLineColor(ctx) {
            return utils.color(ctx.datasetIndex);
        }

        function alternatePointStyles(ctx) {
            var index = ctx.dataIndex;
            return index % 2 === 0 ? 'circle' : 'rect';
        }

        function makeHalfAsOpaque(ctx) {
            return utils.transparentize(getLineColor(ctx));
        }

        function make20PercentOpaque(ctx) {
            return utils.transparentize(getLineColor(ctx), 0.8);
        }

        function adjustRadiusBasedOnData(ctx) {
            var v = ctx.dataset.data[ctx.dataIndex];
            return v < 10 ? 5
                : v < 25 ? 7
                    : v < 50 ? 9
                        : v < 75 ? 11
                            : 15;
        }

        let options2 = {
            responsive: true,
            legend: {
                position: 'bottom'
            }
        };

        let chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'radar',

            // The data for our dataset
            data: {
                labels: ['Clan', 'Adhocracy', 'Market', 'Hierarchy'],
                datasets: [
                    {
                        label: 'Current',
                        //backgroundColor: 'green',
                        borderColor: 'green',
                        data: [32.50, 25, 17.78, 24.72]
                    },
                    {
                        label: 'Preferred',
                        //backgroundColor: 'pink',
                        borderColor: 'pink',
                        data: [30, 36.67, 16.39, 16.94]
                    }
                ]
            },

            // Configuration options go here
            options: options2,
            // plugins: [{
            //     beforeDraw: function (chart, options) {
            //         var ctx = chart.chart.ctx;
            //         var yaxis = chart.scales['scale'];
            //         console.log(yaxis);
            //         var paddingX = 100;
            //         var paddingY = 40;
            //
            //         ctx.save();
            //         ctx.beginPath();
            //         ctx.strokeStyle = '#0000ff';
            //         ctx.lineWidth = 0.75;
            //
            //         drawArrow(ctx, yaxis.xCenter, yaxis.yCenter, yaxis.xCenter - yaxis.drawingArea - paddingX, yaxis.yCenter);
            //         drawArrow(ctx, yaxis.xCenter, yaxis.yCenter, yaxis.xCenter + yaxis.drawingArea + paddingX, yaxis.yCenter);
            //         drawArrow(ctx, yaxis.xCenter, yaxis.yCenter, yaxis.xCenter, yaxis.yCenter - yaxis.drawingArea - paddingY);
            //         drawArrow(ctx, yaxis.xCenter, yaxis.yCenter, yaxis.xCenter, yaxis.yCenter + yaxis.drawingArea + paddingY);
            //
            //         ctx.stroke();
            //         ctx.restore();
            //     },
            // }],

        });
    </script>
</html>
