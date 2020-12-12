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

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap.min2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap-datetimepicker2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap-select.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/report.css">

</head>
<body>
<main>
    <table class="report-container">
        <thead class="report-header">
        <tr>
            <th class="report-header-cell">
                <div class="topOfPage flex">
                    <div class="left">KẾT QUẢ KHẢO SÁT VĂN HÓA DOANH NGHIỆP CSS GROUP</div>
                    <div class="logo-top">
                        <img src="/frontend/assets/img/logo-header.jpg" alt="" class="imgFull">
                    </div>
                    <div class="pageNum">- 1 -</div>
                </div>
            </th>
        </tr>
        </thead>
        <tfoot class="report-footer">
        <tr>
            <td class="report-footer-cell">
                <div class="bottomOfPage flex-end">
                    <div class="left">© 2020 CASONLINE.VN</div>
                    <div class="logo-bottom">
                        <img src="/frontend/assets/img/logo-sm.png" alt="" class="imgFull">
                    </div>
                </div>
            </td>
        </tr>
        </tfoot>
        <tbody class="report-content">
        <tr>
            <td class="report-content-cell">
                <div class="main">
                    <div class="article">
                        <div class="contentPage1 contentPage">
                            <div class="fz16 ttUpper colorBlue fw500">BÁO CÁO ĐÁNH GIÁ</div>
                            <div class="fsItalic fz20 mt45">Văn hóa doanh nghiệp</div>
                            <div class="fz30 ffNoto fwb mt5">Khung Giá Trị Cạnh Tranh</div>
                            <div class="fz24 colorBlue ttUpper fwb mt45">CSS GROUP</div>
                            <div class="fsItalic clGray fz12 mt45">Chiến dịch</div>
                            <div class="fz20 fwb mt10">Khảo sát văn hóa doanh nghiệp CSS 2020</div>
                            <div class="fsItalic clGray fz12 mt45">Phạm vi khảo sát:</div>
                            <div class="fz14 fwb">Nội bộ CSS Group</div>
                            <div class="fsItalic clGray fz12 mt5">Thời gian khảo sát:</div>
                            <div class="fz14 fwb">27/11/2020 – 29/11/2020</div>
                        </div>
                    </div>
                    <div class="article">
                        <div class="contentPage2 contentPage">
                            <div class="fz18 colorBlue fwb pd-lr-30 ffLato">Mục lục</div>
                            <div class="line mt45"></div>
                            <div class="index">
                                <div class="mtb30"><div class="pl30">THÔNG TIN CHUNG</div><div class="right">- 3 -</div></div>
                                <div><div class="fwb">THÔNG TIN DOANH NGHIỆP</div><div class="right">- 3 -</div></div>
                                <div><div class="fwb">CƠ SỞ LUẬN</div><div class="right">- 3 -</div></div>
                                <div><div class="pl30">KẾT QUẢ KHẢO SÁT</div><div class="right">- 5 -</div></div>
                                <div><div class="fwb">THÔNG TIN CHIẾN DỊCH KHẢO SÁT</div><div class="right">- 5 -</div></div>
                                <div><div class="fwb">TRỌNG SỐ</div><div class="right">- 5 -</div></div>
                                <div><div class="fwb">KẾT QUẢ KHẢO SÁT</div><div class="right">- 6 -</div></div>
                            </div>
                        </div>
                    </div>
                    @foreach ([7, 6, 5, 4, 3, 2, 1] as $resultType)
                        <div class="article">
                            <div class="contentPage">
                                <h2 class="turnName ttUpper">Báo cáo {{\App\Helpers::mapOrder()[$resultType]}}</h2>
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
                        </div>
                    @endforeach
                </div>
            </td>
        </tr>
        </tbody>
    </table>
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