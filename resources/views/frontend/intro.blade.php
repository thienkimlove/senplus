<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="content-language" content="vi"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=5"/>

    <link rel="shortcut icon" href="/frontend/assets/img/favicon.png"/>
    <link rel="icon" href="/frontend/assets/img/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="/frontend/assets/img/favicon.png" type="image/vnd.microsoft.icon"/>

    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrapv4.5.min.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleIndex.css">
    <title data-react-helmet="true">Hướng dẫn</title>

    <script src="/frontend/assets/js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/bootstrap4.5.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/page_all.js" type="text/javascript"></script>

</head>
<body class="bodyIndex">

<div class="wrapper" style="background: url('/frontend/assets/img/bg.jpg') center top no-repeat;background-size: 100%;">
    <div class="popup px" id="popupGuidings">
        <div class="bg_drop pa"></div>
        <div class="popupContent pa">
            <a href="{{ route('frontend.home') }}" class="closePopup pa" title="Đóng lại" aria-label="Close"><img src="/frontend/assets/img/i_x.png" alt="" class="imgFull"></a>
            <div class="content">
                <h2>Trước khi bắt đầu</h2>
                <div class="ruleOne rule">
                    <div class="num"><span>1</span>Quy tắc 2 vòng</div>
                    <div class="txt">
                        <p>Chúng ta sẽ trải qua 2 vòng chấm điểm:</p>
                        <p><strong>• Vòng 1:</strong> nhằm đánh giá và nhận diện văn hóa doanh nghiệp hiện tại.</p>
                        <p><strong>• Vòng 2:</strong> giúp định hướng và lựa chọn văn hóa phù hợp cho tương lai.</p>
                        <p>Mỗi vòng chấm điểm gồm <strong>6 câu hỏi</strong> nhằm khảo sát <strong>6 yếu tố</strong> nội tại của doanh nghiệp, đó là:</p>
                        <p style="font-weight: bold;">• Đặc điểm nổi trội</p>
                        <p style="font-weight: bold;">• Phong cách lãnh đạo</p>
                        <p style="font-weight: bold;">• Quản lý nhân viên</p>
                        <p style="font-weight: bold;">• Sự gắn kết</p>
                        <p style="font-weight: bold;">• Chiến lược</p>
                        <p style="font-weight: bold;">• Tiêu chí thành công</p>
                    </div>
                </div>
                <div class="ruleTwo rule">
                    <div class="num"><span>2</span>Quy tắc chấm điểm.</div>
                    <p><span class="left">• Tương ứng với mỗi câu hỏi, sẽ có 4 câu trả lời</span><span class="right"><input value="56" type="text" disabled></span></p>
                    <p><span class="left">• Bạn có quỹ 100 điểm để phân chia vào từng câu trả lời</span><span class="right"><input value="0" type="text" disabled></span></p>
                    <p><span class="left">• Hãy để số điểm cao nhất cho câu trả lời giống nhất với doanh nghiệp của bạn.</span><span class="right"><input value="34" type="text" disabled></span></p>
                    <p><span class="left">• Bạn có thể để số điểm thấp nhất cho câu trả lời không giống với doanh nghiệp của bạn</span><span class="right"><input value="10" type="text" disabled></span></p>
                    <p><span class="left">• Có thể cho điểm 0 nếu muốn</span></p>
                    <p><span class="right"><strong>Tổng điểm: </strong><input value="100" type="text" disabled></span></p>
                </div>
                <div class="getReady">
                    <div class="left"><span class="iconTick"><img src="/frontend/assets/img/tick.png" alt="" class="imgFull"></span><span>và .. bạn đã sẵn sàng</span></div>
                    <a href="{{ route('frontend.home') }}" class="btn_Next" title="Tiếp theo"><img src="/frontend/assets/img/i_next.png" alt="" class="imgFull"></a>
                </div>
            </div>
            <div class="popupBot">
                <a href="javascript:void(0)" class="btn-back" title="Quay lại" onclick="window.history.back()"><img src="/frontend/assets/img/btn-back.png" alt="" class="imgFull"></a>
                <div id="processing">
                    <span class="moc moc0"><i></i></span>
                    <span class="moc moc1 active"><i>Hướng dẫn</i></span>
                    <span class="moc moc2"><i></i></span>
                    <span class="moc moc3"><i></i></span>
                    <span class="moc moc4"><i></i></span>
                </div>
                <a href="{{ route('frontend.home') }}" class="btn-next" title="Tiếp tục"><img src="/frontend/assets/img/btn-next.png" alt="" class="imgFull"></a>
            </div>
        </div>
    </div>
</div>
<script>
    showPopup($('#popupGuidings'));
</script>


</body>
</html>