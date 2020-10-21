@extends('frontend.layout_home')

@section('content')
    
    <main>
        <div class="sortInfoBlock">
            <div class="fixCen">
                <div class="avatar">
                    <img src="{{ \App\Helpers::getCustomerAvatar($customer) }}" alt="" class="imgFull">
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
@endsection
