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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

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


        let chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'radar',

            // The data for our dataset
            data: {
                labels: ['Flexibility and Desertion', 'Clan', 'External Focus and Integration', 'Adhocracy','Stability and Control', 'Market','Internal Focus and Integration', 'Hierarchy'],
                datasets: [
                    {
                        label: 'Current',
                        //backgroundColor: 'green',
                        borderColor: 'green',
                        data: [null, 32.50, null, 25, null, 17.78, null, 24.72]
                    },
                    {
                        label: 'Preferred',
                        //backgroundColor: 'pink',
                        borderColor: 'pink',
                        data: [null, 30, null, 36.67, null, 16.39, null,16.94]
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
            }

        });
    </script>
</html>
