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
    <article class="contentPage1 contentPage">
        <h1 class="logo">
            <a href="#" title="{{ $survey->company->name }}">

                <img src="{{ \App\Helpers::getLoginCompanyLogo() }}" alt="">
            </a>
        </h1>
        <div class="fz16 ttUpper colorBlue fw500">BÁO CÁO ĐÁNH GIÁ</div>
        <div class="fsItalic fz20 mt45">Văn hóa doanh nghiệp</div>
        <div class="fz30 ffNoto fwb mt5">Khung Giá Trị Cạnh Tranh</div>
        <div class="fz24 colorBlue ttUpper fwb mt45">{{ $survey->company->name }}</div>
        <div class="fsItalic clGray fz12 mt45">Chiến dịch</div>
        <div class="fz20 fwb mt10">{{ $survey->name }}</div>
        <div class="fsItalic clGray fz12 mt45">Phạm vi khảo sát:</div>
        <div class="fz14 fwb">Nội bộ CSS Group</div>
        <div class="fsItalic clGray fz12 mt5">Thời gian khảo sát:</div>
        <div class="fz14 fwb">{{ $survey->start_time? $survey->start_time->format('d/m/Y') : "" }}  - {{ $survey->end_time? $survey->end_time->format('d/m/Y') : "" }}</div>
    </article>
    <article class="contentPage2 contentPage">
        <div class="fz18 colorBlue fwb pd-lr-30 ffLato">Mục lục</div>
        <div class="line mt45"></div>
        <div class="index">
            <div class="mtb30">
                <a href="#chapter-3"><span class="pl30">I. THÔNG TIN CHUNG</span></a>
                <div class="right">- 4 -</div>
            </div>
            <div>
                <a href="#chapter-3" class="fwb"><span>THÔNG TIN DOANH NGHIỆP</span></a>
                <div class="right">- 4 -</div>
            </div>
            <div>
                <a href="#chapter-3" class="fwb"><span>CƠ SỞ LUẬN</span></a>
                <div class="right">- 4 -</div>
            </div>
            <div>
                <a href="#chapter-4"><span class="pl30">II. KẾT QUẢ KHẢO SÁT</span></a>
                <div class="right">- 6 -</div>
            </div>
            <div>
                <a href="#chapter-4" class="fwb"><span>THÔNG TIN CHIẾN DỊCH KHẢO SÁT</span></a>
                <div class="right">- 6 -</div>
            </div>
            <div>
                <a href="#chapter-4" class="fwb"><span>TRỌNG SỐ</span></a>
                <div class="right">- 6 -</div>
            </div>
            <div>
                <a href="#chapter-5" class="fwb"><span>BÁO CÁO ĐẶC ĐIỂM NỔI TRỘI</span></a>
                <div class="right">- 7 -</div>
            </div>
            <div>
                <a href="#chapter-6" class="fwb"><span>BÁO CÁO PHONG CÁCH LÃNH ĐẠO</span></a>
                <div class="right">- 9 -</div>
            </div>
            <div>
                <a href="#chapter-7" class="fwb"><span>BÁO CÁO QUẢN LÝ NHÂN VIÊN</span></a>
                <div class="right">- 11 -</div>
            </div>
            <div>
                <a href="#chapter-8" class="fwb"><span>BÁO CÁO SỰ GẮN KẾT</span></a>
                <div class="right">- 13 -</div>
            </div>
            <div>
                <a href="#chapter-9" class="fwb"><span>BÁO CÁO CHIẾN LƯỢC</span></a>
                <div class="right">- 15 -</div>
            </div>
            <div>
                <a href="#chapter-10" class="fwb"><span>BÁO CÁO TIÊU CHÍ THÀNH CÔNG</span></a>
                <div class="right">- 17 -</div>
            </div>
            <div>
                <a href="#chapter-11" class="fwb"><span>BÁO CÁO TỔNG QUAN</span></a>
                <div class="right">- 19 -</div>
            </div>
        </div>
    </article>
    <article class="contentPage3 contentPage" id="chapter-3">
        <h1>I. THÔNG TIN CHUNG</h1>
        <h2 class="pl30 mt30">THÔNG TIN DOANH NGHIỆP</h2>
        <p style="line-height: 40px;margin-top: 30px;"><strong>Tên doanh nghiệp:</strong> {{ $survey->company->name }} <br>
            <strong>Trụ sở chính:</strong> {{ $survey->company->main_address }} <br>
            <strong>Số điện thoại:</strong> {{ $survey->company->contact_phone }} <br>
            <strong>Lĩnh vực kinh doanh:</strong> {{ $survey->company->business->name }} <br>
            <strong>Số lượng nhân viên:</strong> > {{ $survey->company->employee->name }}
        </p>
        <h2 class="mt30 pl30">CƠ SỞ LUẬN</h2>
        <p class="fwb mt30">Xây dựng văn hóa doanh nghiệp dựa trên khung giá trị cạnh tranh:</p>
        <p style="margin-top: 20px;line-height: 30px;">Khung giá trị cạnh tranh được tạo ra lần đầu tiên vào năm 1983 bởi Robert Quinn, một nhà nghiên cứu hàng đầu về lãnh đạo tổ chức và John Rohrbaugh.</p>
        <p style="margin-top: 20px;line-height: 30px;">Hơn 30 năm kể từ ngày ra mắt, khung giá trị cạnh tranh được công nhận là một trong những cách hiểu văn hóa doanh nghiệp hiệu quả nhất. Bất cứ khi nào một tổ chức muốn nâng cao năng lực cạnh tranh và cải tiến phương thức kinh doanh, thì tổ chức đó phải giải quyết vấn đề văn hóa doanh nghiệp, các giá trị nội tại tạo động lực, thúc đẩy con người, các chương trình và chính sách để giúp họ đạt được mục tiêu một cách nhanh chóng.</p>
        <p style="margin-top: 20px;line-height: 30px;">
            Trong suốt quá trình nghiên cứu của mình, Quinn và Rohrbaugh phát hiện ra rằng: Các công ty hoạt động hiệu quả đều ứng phó rất tốt với hai nhóm hành vi đó là:
        </p>
        <p style="margin-top: 20px;line-height: 30px;"><span class="colorBlue fwb">Nhóm 1:</span> <span class="fwb">Tính hướng nội</span> (một số doanh nghiệp hoạt động hiệu quả khi họ tập trung củng cố, phát triển sức mạnh nội tại như cải tiến quy trình,  nâng cao chất lượng nhân sự nội bộ) hoặc Tính hướng ngoại (trong khi các doanh nghiệp khác hoạt động hiệu quả khi duy trì được sự nhạy bén với môi trường bên ngoài, thấu hiểu rõ khách hàng và đối thủ cạnh tranh).</p>
        <p style="margin-top: 20px;line-height: 30px;"><span class="colorBlue fwb">Nhóm 2:</span> <span class="fwb">Sự ổn định</span> (một số doanh nghiệp thành công vì bộ máy được vận hành ổn định, mọi thứ luôn đặt trong tầm kiểm soát) hoặc Sự linh hoạt (trong khi các doanh nghiệp khác thành công nhờ sự linh hoạt và khả năng thích ứng nhanh với thời cuộc)</p>
        <p style="margin-top: 20px;line-height: 30px;">Khung giá trị cạnh tranh xem xét hành vi của người đứng đầu, đội ngũ lãnh đạo và cách hành vi đó tạo ra năng lực cạnh tranh cho doanh nghiệp. Nhưng quan trọng hơn, là những hành vi đó góp phần tạo các giá trị cụ thể như: tăng trưởng doanh thu, lợi nhuận, thị phần, khả năng đổi mới và phát triển sản phẩm, cải thiện chất lượng sản phẩm, dịch vụ và mức độ hạnh phúc của nhân viên.</p>
        <p style="margin-top: 20px;line-height: 30px;">Không có câu trả lời Đúng hay Sai khi cố gắng tìm ra loại hình văn hóa nổi trội cho doanh nghiệp của anh/chị.</p>
        <p style="margin-top: 20px;line-height: 30px;">Anh/chị cần phải lựa chọn loại hình doanh nghiệp mà mình muốn trở thành và phổ biến những giá trị đó với mọi thành viên trong tổ chức.</p>
        <p style="margin-top: 20px;line-height: 30px;">Tuy nhiên, các doanh nghiệp muốn trở nên lớn mạnh sinh lời cần phải có năng lực ở cả 4 góc phần tư của khung giá trị cạnh tranh. Vì trong thực tế, một vấn đề có thể có nhiều cách tiếp cận và giải quyết khác nhau.</p>
    </article>


    <article class="contentPage" id="chapter-4">
        <h1>II. KẾT QUẢ KHẢO SÁT</h1>
        <h2 class="mt30 pl30">THÔNG TIN CHIẾN DỊCH KHẢO SÁT</h2>
        <p style="margin-top: 30px;line-height: 40px;">
            <strong>Tên chiến dịch khảo sát:</strong> {{ $survey->name }} <br>
            <strong>Phạm vi khảo sát:</strong> Nội bộ CSS Group <br>
            <strong>Thời hạn khảo sát:</strong> {{ $survey->start_time? $survey->start_time->format('d/m/Y') : "" }}  - {{ $survey->end_time? $survey->end_time->format('d/m/Y') : "" }} <br>
            <strong>Số lượng thành viên được mời tham gia:</strong> {{ \App\Helpers::getTotalUserJoin($survey) }} <br>
            <strong>Số lượng thành viên hoàn thành khảo sát:</strong> {{ \App\Helpers::getTotalAnswerForSurvey($survey) }} <br>
            <strong>Số lượng thành viên chưa hoàn thành khảo sát:</strong> {{ \App\Helpers::getTotalUserNotAnswer($survey) }}
        </p>
        <h2 class="mt45 pl30">TRỌNG SỐ</h2>
        <table class="tableNormal" style="width: 100%;margin-top: 30px;">
            <thead>
            <tr>
                <th>Cấp bậc / Trọng số </th>
                <th>Mặc định</th>
                <th>Điều chỉnh</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($filterCounts as $value => $filterCount)
                @if (isset($weighConfig[$value]))
                <tr>
                    <td>{{ $value }}</td>
                    <td>{{ $filterCount['percent'] }}%</td>
                    <td>{{ $weighConfig[$value] }}%</td>
                </tr>
                @endif
            @endforeach
            </tbody>
        </table>
        <p class="mt30">Trong phạm vi của báo cáo này, chúng tôi dùng từ "nhóm" để đại diện cho nhóm đối tượng khảo sát mà anh/chị đã chọn ra.</p>
    </article>

    @foreach (array_keys(\App\Helpers::ARRAY_TYPES) as $resultType)
        <article class="contentPage" id="chapter-{{ $resultType+4 }}">
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
        </article>
    @endforeach
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
        @foreach (array_keys(\App\Helpers::ARRAY_TYPES) as $resultType)
        makeChart(document.getElementById('myChart{{$resultType}}').getContext('2d'), mapOption, mapRound, JSON.parse(' @json($explain['details'][$resultType]['result']) '));
        @endforeach
    });
</script>
</body>

</html>