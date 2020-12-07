<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="content-language" content="vi"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=5"/>
    <title data-react-helmet="true">Khảo sát và đánh giá môi trường Văn hoá doanh nghiệp</title>
    <link rel="shortcut icon" href="/frontend/assets/img/favicon.png"/>
    <link rel="icon" href="/frontend/assets/img/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="/frontend/assets/img/favicon.png" type="image/vnd.microsoft.icon"/>
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap.min2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap-datetimepicker2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap-select.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleSurveyAction.css">

</head>
<body class="">

<main>
    <div class="topBlock">
        Content of first part of Report Doc
    </div>

    <div class="contentBlock">

        <div class="fixCen">

            @foreach ([7, 6, 5, 4, 3, 2, 1] as $resultType)

            <div class="topOfBox">
                <h3 class="turnName">Báo cáo {{\App\Helpers::mapOrder()[$resultType]}}</h3>
                <div class="box resultBox">
                    <div class="tableAndChart">
                        <div class="leftSide">
                            <table class="tableResult">
                                <thead>
                                <tr>
                                    <th id="titleTable">{{\App\Helpers::mapOrder()[$resultType]}}</th>
                                    <th>Đánh giá <br>(hiện tại)</th>
                                    <th>Mong muốn <br>(tuong lai)</th>
                                    <th>Nhu cầu thay đổi</th>
                                </tr>
                                </thead>
                                <tbody id="mainTableBody">
                                @include('frontend.partials.table', ['result' => $explain['details'][$resultType]['result']])
                                </tbody>
                            </table>
                        </div>
                        <div class="rightSide">
                            <h3 class="title" id="titleRight">Tổng quan</h3>
                            <div class="name">{{ $survey->company->name }}</div>
                            <div class="content">
                                <div class="radaChart">
                                    <canvas class="resultChart" id="myChart{{$resultType}}"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <article class="articleResult" id="article">
                        @include('frontend.partials.'.\App\Helpers::ARRAY_TYPES[$resultType].'_result_explain', ['explain' => $explain])
                    </article>
                </div>
            </div>

            @endforeach
        </div>
    </div>
</main>



<script src="/frontend/assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="/frontend/assets/js/bootstrap.min2.js" type="text/javascript"></script>
<script src="/frontend/assets/js/moment.js" type="text/javascript"></script>
<script src="/frontend/assets/js/bootstrap-datetimepicker.min2.js" type="text/javascript"></script>
<script src="/frontend/assets/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="/frontend/assets/js/Chart.min.js"></script>
<script src="/frontend/assets/js/page_all.js?v=2" type="text/javascript"></script>
<script src="/frontend/assets/js/index.js?v=2" type="text/javascript"></script>
<script>
    $(function(){
        let mapOption = JSON.parse(' @json(\App\Helpers::mapOption()) ');
        let mapRound = JSON.parse(' @json(\App\Helpers::mapRound()) ');
        @foreach ([7, 6, 5, 4, 3, 2, 1] as $resultType)
            makeChart(document.getElementById('myChart{{$resultType}}').getContext('2d'), mapOption, mapRound, JSON.parse(' @json($explain['details'][$resultType]['result']) '));
        @endforeach
    });
</script>
</body>
</html>