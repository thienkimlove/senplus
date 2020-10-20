@extends('frontend_store_2.layout')

@section('before_header')
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrapv4.5.min.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrap-select.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleSurveyAction.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleSurveyAction.css">

    <title data-react-helmet="true">Danh sách khảo sát</title>

    <script src="/frontend/assets/js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/page_all.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/page_result.js" type="text/javascript"></script>
@endsection    

@section('content')
    <body class="bodyHomeUser">
    @include('frontend_store_2.header_user')

    <main>
        <div class="sortInfoBlock">
            <div class="fixCen">
                <div class="avatar">
                    <img src="{{ $customer->avatar? url($customer->avatar) : '/frontend/assets/img/demo-logo1.jpg' }}" alt="" class="imgFull">
                </div>
                <div class="txt">
                    {{ $customer->name }}
                </div>
            </div>
        </div>
        <div class="topBlock">
            <div class="fixCen hasBefore">
                <h2 class="title">Danh sách khảo sát</h2>
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
                            <td>Thao tác</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($surveys as $survey)
                            <tr>
                                <td>
                                    {{ $survey->name }}
                                </td>
                                <td>{{ $survey->start_time ? $survey->start_time->format('d/m/Y') : '' }}</td>
                                <td>{{ $survey->end_time ? $survey->end_time->format('d/m/Y') : '' }}</td>

                                <td>
                                    @if (\App\Helpers::checkIfSurveyHaveResultForUser($survey))
                                        <a href="{{ route('frontend.result').'?id='.$survey->id }}">Xem kết quả</a>
                                    @else
                                        <a href="{{ route('frontend.survey').'?id='.$survey->id }}">Khảo sát</a>
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

    @include('frontend_store_2.footer_user')
    </body>
@endsection

@section('after_scripts')
    <script>
        $(function(){
            $('.btnSave').click(function(){
                $('#CorInfo').submit();
                return false;
            });
        });
    </script>
@endsection