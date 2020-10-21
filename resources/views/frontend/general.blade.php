@extends('frontend.layout_home')

@section('content')
    <main>
        @include('frontend.partials.sort_block')
        <div class="topBlock">
            <div class="fixCen hasBefore">
                <div class="descriptionRusult">
                    <p class="blue2 fw18px">
                        [{{ $survey->name }}]
                    </p>
                    <p>Thời gian thực hiện: [{{ $survey->start_time? $survey->start_time->format('d/m/Y') : "" }}  - {{ $survey->end_time? $survey->end_time->format('d/m/Y') : "" }}]</p>
                    <p>Số lượng: [{{ \App\Helpers::getTotalAnswerForSurvey($survey) }}]</p>
                </div>
            </div>
        </div>
        <div class="contentBlock">
            <div class="fixCen">

                <div class="topOfBox">
                    <h3 class="turnName">Báo cáo tổng quan</h3>
                    <a href="{{ route('frontend.campaign_create') }}" class="myBtn" title="Tạo chiến dịch" >+ Tạo chiến dịch</a>
                    <form action="javascript:void(0)" class="filterData">
                        <input type="text" placeholder="Lọc dữ liệu" id="inputSearchDemo">
                        <input id="survey_id" type="hidden" name="survey_id" value="{{ $survey->id }}">
                        <div id="filterDataBox">
                            <div class="objectTest">
                                @if (\App\Helpers::currentFrontendUserIsAdmin())
                                    <h3 class="title">Đối tượng khảo sát</h3>
                                    <div class="selectGroup">
                                        @foreach ($survey->company->filters->where('is_level', false) as $filter)
                                            <select name="filter_{{ $filter->id }}" multiple class="multiSeclect filterSelect">
                                                @foreach ($filter->options as $option)
                                                    <option class="option" value="{{ $option['attr_value'] }}">
                                                        {{ $option['attr_value'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="typeOfChart">
                                <h3 class="title">Loại biểu đồ</h3>
                                <select name="choose_type" id="chartKind">
                                    @foreach (\App\Helpers::mapOrder() as $index => $value)
                                        <option class="option" value="{{ $index }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button id="filerSelectSubmit" class="btnFilter myBtn">Xem</button>
                        </div>
                    </form>
                </div>

                <div class="box resultBox">
                    <div class="txt">* Sử dụng bộ lọc dữ liệu để nhận kết quả đa chiều</div>
                    <div class="tableAndChart">
                        <div class="leftSide">
                            <table class="tableResult">
                                <thead>
                                <tr>
                                    <th id="titleTable">Loại hình Văn hóa doanh nghiệp</th>
                                    <th>Đánh giá <br>(hiện tại)</th>
                                    <th>Mong muốn <br>(tuong lai)</th>
                                    <th>Chênh lệch</th>
                                </tr>
                                </thead>
                                <tbody id="mainTableBody">
                                    @include('frontend.partials.table', ['result' => $explain['details'][7]['result']])
                                </tbody>
                            </table>
                        </div>
                        <div class="rightSide">
                            <h3 class="title" id="titleRight">Loại hình Văn hóa doanh nghiệp</h3>
                            <div class="name">[{{ $survey->company->name }}]</div>
                            <div class="content">
                                <div class="radaChart">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <article class="articleResult" id="article">
                        @include('frontend.partials.general_result_explain', ['explain' => $explain])
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

            $('#filerSelectSubmit').click(function(){
                let surveyId = $('#survey_id').val();
                let chooseType = $('#chartKind').val();
                let checkboxValues = [];

                $('.filterSelect').each(function () {
                    let filterId = this.name.replace('filter_', '');
                    checkboxValues.push(filterId + '||' + this.value);
                });
                let chooseCustomers = checkboxValues.toString(); //Output Format: 1,2,3

                $.post('{{ route('frontend.filter') }}', {
                    survey_id : surveyId,
                    choose_type: chooseType,
                    choose_customers : chooseCustomers
                }, function(res) {
                    if (!res.error) {
                        makeChart(ctx, mapOption, mapRound, res.result);
                        $('#explainText').hide();
                        $('#titleTable').text(res.title);
                        $('#titleRight').text(res.title);
                        $('#article').html(res.explain);
                    } else {
                        alert('Chưa có dữ liệu câu trả lời vói trường hợp này!');
                    }
                });
            });
        });
    </script>
@endsection
