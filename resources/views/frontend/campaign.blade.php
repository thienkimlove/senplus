@extends('frontend.layout_home')

@section('content')
    <main>
        @include('frontend.partials.sort_block')
        <div class="topBlock">
            <div class="fixCen hasBefore">
                <h2 class="title">Tất cả khảo sát</h2>
                @if (\App\Helpers::currentFrontendUserIsAdmin())
                    <a href="{{ route('frontend.campaign_create') }}" class="myBtn addNewUser" title="Tạo chiến dịch">+ Tạo chiến dịch</a>
                @endif
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
                                    @if (\App\Helpers::currentFrontendUserIsAdmin())
                                    <a href="{{ route('frontend.campaign_detail').'?id='.$survey->id }}" class="btnEditSurvey" title="Sửa chiến dịch">
                                        <img src="/frontend/assets//img/i_pen.png" alt="Edit">
                                    </a>
                                     @endif
                                </td>
                                <td>{{ $survey->start_time ? $survey->start_time->format('d/m/Y') : '' }}</td>
                                <td>{{ $survey->end_time ? $survey->end_time->format('d/m/Y') : '' }}</td>
                                <td>{{ \App\Helpers::getTotalUserJoin($survey) }}</td>
                                <td class="red">
                                    <a href="{{ route('frontend.member') }}?is_not_complete={{$survey->id}}">
                                        {{ \App\Helpers::getTotalUserNotAnswer($survey) }}
                                    </a>
                                </td>
                                <td>


                                    @if (\App\Helpers::currentFrontendUserIsAdmin())
                                        @if (!\App\Helpers::isDemoCustomer())
                                            <a href="javascript:void(0)"
                                               class="btnDelete" title="Xóa"
                                               onclick="showPopupNotifyWithParams({{ $survey->id }})">Xóa
                                            </a>
                                        @else
                                            <a href="javascript:void(0)"
                                               class="btnDelete" title="Xóa"
                                               onclick="return false;">Xóa
                                            </a>
                                        @endif
                                    @endif
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
