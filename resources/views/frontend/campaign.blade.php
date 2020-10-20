@extends('frontend.layout_home')

@section('after_head')
    <title data-react-helmet="true">Hồ sơ doanh nghiệp</title>
@endsection


@section('content')
    <div class="popup px popupNotify" id="popupDelSurveyWithParam">
        <div class="bg_drop pa"></div>
        <div class="popupContent pa box">
            <a href="javascript:void(0)" class="closePopup pa" title="Đóng lại" aria-label="Close">
                <img src="/frontend/assets//img/i_x.png" alt="" class="imgFull">
            </a>
            <div class="notify">Dữ liệu chiến dịch không thể phục hồi sau khi xoá</div>
            <div class="colorBlue fwb fz18px">Chắc chắn xoá chiến dịch? </div>
            <div class="form-group">
                <input type="hidden" id="popup_token" value="{{ csrf_token() }}" />
                <button type="button" class="skip myBtn">Bỏ qua</button>
                <button type="button" id="popup_button_del_survey" class="myBtn btnDelete">Xóa</button>
            </div>
        </div>
    </div>
    <main>
        @include('frontend.partials.sort_block')
        <div class="topBlock">
            <div class="fixCen hasBefore">
                <h2 class="title">Hệ thống đánh giá VHDN</h2>
                <a href="{{ route('frontend.campaign_create') }}" class="myBtn addNewUser" title="Tạo chiến dịch">+ Tạo chiến dịch</a>
            </div>
        </div>
        <div class="editSurveyBlock editBlock">
            <div class="fixCen">
                <div class="box">
                    <table class="tableList tableListSurvey">
                        <thead>
                        <tr>
                            <td>Tên</td>
                            <td>Bắt đầu</td>
                            <td>Kết thúc</td>
                            <td>Tham gia</td>
                            <td>Chưa xong</td>
                            <td>Thao tác</td>
                            <td>Báo cáo</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($surveys as $survey)
                            <tr>
                                <td>
                                    <a href="javascript:void(0)"
                                       class="link bgEdit"
                                       title="{{ $survey->name }}">
                                        {{ $survey->name }}
                                    </a>
                                    <a href="{{ route('frontend.campaign_detail').'?id='.$survey->id }}" class="btnEditSurvey" title="Sửa chiến dịch">
                                        <img src="/frontend/assets//img/i_pen.png" alt="Edit">
                                    </a>
                                </td>
                                <td>{{ $survey->start_time ? $survey->start_time->format('d/m/Y') : '' }}</td>
                                <td>{{ $survey->end_time ? $survey->end_time->format('d/m/Y') : '' }}</td>
                                <td>{{ \App\Helpers::getTotalAnswerForSurvey($survey) }}</td>
                                <td class="red">{{ \App\Helpers::getTotalUserNotAnswer($survey) }}</td>
                                <td>
                                    <a href="javascript:void(0)"
                                       class="btnDelete" title="Xóa"
                                       onclick="showPopupNotifyWithParams({{ $survey->id }})">Xóa
                                    </a>
                                </td>
                                <td>
                                    @if (\App\Helpers::checkIfSurveyHaveAnyResult($survey))
                                        <a href="{{ route('frontend.general') }}?id={{ $survey->id }}">Xem</a>
                                    @else
                                        Chờ
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection


@section('after_scripts')
    <script>
        function showPopupNotifyWithParams(surveyId) {
            let popup = '#popupDelSurveyWithParam';
            let dropElement = $('.bg_drop');
            $(popup).addClass('showPopup');
            dropElement.fadeIn();
            $('.closePopup').click(function () {
                $('.bg_drop').fadeOut();
                $(popup).removeClass('showPopup');
            });
            dropElement.click(function () {
                $(this).fadeOut();
                $(popup).removeClass('showPopup');
            });

            $('#popup_button_del_survey').click(function(){

                let token = $('#popup_token').val();
                $.ajax({
                    url: '/handleDelSurvey',
                    type: 'POST',
                    data: {
                        _token: token,
                        survey_id: surveyId
                    },
                    success: function (data) {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.error);
                        }
                    }
                });

            });
        }
    </script>
@endsection