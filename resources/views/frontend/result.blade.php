@extends('frontend.layout_home')

@section('content')
    <main>
        @include('frontend.partials.sort_block')
        <div class="topBlock">
            <div class="fixCen hasBefore">
                <div class="descriptionRusult">
                    <p class="blue2 fw18px">
                        {{ $survey->name }}
                    </p>
                    <p>Thời gian thực hiện: {{ $survey->start_time? $survey->start_time->format('d/m/Y') : "" }}  - {{ $survey->end_time? $survey->end_time->format('d/m/Y') : "" }}</p>
                    <p>Số lượng: {{ \App\Helpers::getTotalAnswerForSurvey($survey) }}</p>
                </div>
            </div>
        </div>
        <div class="contentBlock">
            <div class="fixCen">

                <div class="box resultBox">
                    <div class="txt">* Sử dụng bộ lọc dữ liệu để nhận kết quả đa chiều</div>
                    <div class="tableAndChart">
                        <div class="leftSide">
                            <table class="tableResult">
                                <thead>
                                <tr>
                                    <th>Tổng quan</th>
                                    <th>Đánh giá <br>(hiện tại)</th>
                                    <th>Mong muốn <br>(tuong lai)</th>
                                    <th>Chêch lệch</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(\App\Helpers::ARRAY_OPTIONS as $index => $opt)
                                    <tr>
                                        <td>{{ \App\Helpers::mapOption()[$opt] }}</td>
                                        <td>{{ round($explain['details'][7]['result'][1][$opt], 2) }}</td>
                                        <td>{{ round($explain['details'][7]['result'][2][$opt], 2) }}</td>
                                        <td>{{ round($explain['details'][7]['result'][2][$opt] - $explain['details'][7]['result'][1][$opt], 2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="rightSide">
                            <h3 class="title">Tổng quan</h3>
                            <div class="name">{{ $survey->company->name }}</div>
                            <div class="content">

                                <div class="radaChart">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <article class="articleResult">
                        @if (\App\Helpers::currentFrontendUserIsManager())
                            @include('frontend.partials.general_result_explain', ['explain' => $explain])
                        @else
                            @include('frontend.partials.small_result_explain', ['explain' => $explain])
                        @endif
                    </article>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('after_scripts')
    <script>
        $(function(){
            let ctx = document.getElementById('myChart').getContext('2d');
            let result = JSON.parse(' @json($explain['details'][7]['result']) ');
            let mapOption = JSON.parse(' @json(\App\Helpers::mapOption()) ');
            let mapRound = JSON.parse(' @json(\App\Helpers::mapRound()) ');
            makeChart(ctx, mapOption, mapRound, result);
        });
    </script>
@endsection
