@extends('frontend.layout')

@section('before_header')
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap.min2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap-datetimepicker2.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleHomeUser.css">

    <title data-react-helmet="true">Home</title>

    <script src="/frontend/assets/js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/bootstrap.min2.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/moment.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/bootstrap-datetimepicker.min2.js" type="text/javascript"></script>

    <script src="/frontend/assets/js/page_all.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/page_homeUser.js" type="text/javascript"></script>
@endsection    

@section('content')
    <body class="bodyHomeUser">
    @include('frontend.header_user')
    <main>
        <div class="helloBlock">
            <div class="avatar">
                <img src="/frontend/assets/img/demo-logo1.jpg" alt="" class="imgFull">
            </div>
            <div class="txt">
                Chào mừng [{{ auth()->user()->name }}] <br> quay lại với CAS online
            </div>
        </div>
        <nav class="btnMainGoup">
            <ul class="fixCen">
                @if (\App\Helpers::currentFrontendUserIsManager())
                <li>
                    <a href="{{ route('frontend.profile') }}" class="link" title="Hồ sơ doanh nghiêp" aria-label="Corporate Profile">
                        <span class="img"><img src="/frontend/assets/img/btn-hoso.jpg" alt="" class="imgFull"></span>
                        Hồ sơ doanh nghiêp
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.customer') }}" class="link" title="Dữ liệu người dùng" aria-label="User Data">
                        <span class="img"> <img src="/frontend/assets/img/btn-dulieu.jpg" alt="" class="imgFull"></span>
                        Dữ liệu người dùng
                    </a>
                </li>

                <li>
                    <a href="{{ route('frontend.campaign') }}" class="link" title="Danh sách khảo sát" aria-label="Survey Campaign">
                        <span class="img"> <img src="/frontend/assets/img/btn-chiendich.jpg" alt="" class="imgFull"></span>
                        Danh sách khảo sát
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <div class="campaignBlock">
            <div class="fixCen">
                <div class="leftSide">
                    <h2 class="title">Danh sách khảo sát</h2>
                    <div class="surveyList">
                        @if ($surveys)
                        <ul>
                            @foreach ($surveys as $index => $survey)
                            <li>
                                <h4><a href="javascript:void(0)"
                                       class="titleCampaign"
                                       title="{{ $survey->name }}"
                                       aria-label="{{ $survey->name }}"
                                       data-popup=".popupCampaign{{ $index }}">{{ $survey->name }} ({{ $survey->start_time? $survey->start_time->format('d/m/Y') : $survey->created_at->format('d/m/Y') }})</a></h4>
                                <div class="popupCampaign pa popupCampaign{{ $index }}">
                                    <h3 class="titlePopup">[{{ $survey->name }}]</h3>
                                    <div class="charts">
                                        <div class="leftSide">
                                            <img src="/frontend/assets/img/demo-bd1.jpg" alt="" class="imgFull">
                                            <div class="chartName">Tên loại hình doanh nghiệp</div>
                                        </div>
                                        <div class="rightSide">
                                            <img src="/frontend/assets/img/demo-bd2.jpg" alt="" class="imgFull">
                                            <div class="chartName">Đối tượng khảo sát</div>
                                        </div>
                                    </div>
                                    <a href="javascript:void(0)" class="btnViewDetail myBtn" title="Xem chi tiết" aria-label="View detail">Chi tiết</a>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @else
                            Không có chiến dịch khảo sát nào.
                        @endif
                    </div>
                    <a href="{{ route('frontend.private') }}" class="myBtn" title="Xem tất cả" aria-label="View All">Xem tất cả</a>
                </div>
                <div class="rightSide">
                    <h2 class="title">Khảo sát mới</h2>
                    @if ($latestCanDoSurvey)
                        <h3 class="newestCampaignName">{{ $latestCanDoSurvey->name }}</h3>
                        <div class="desNewestCampaign">{{ \Illuminate\Support\Str::limit($latestCanDoSurvey->desc, 25) }}</div>
                        <a href="{{ route('frontend.survey') }}?id={{ $latestCanDoSurvey->id }}" class="myBtn" title="Khảo sát ngay" aria-label="Survey now">Khảo sát ngay</a>
                    @endif
                </div>
            </div>
        </div>
    </main>

    @include('frontend.footer_user')

    </body>
@endsection