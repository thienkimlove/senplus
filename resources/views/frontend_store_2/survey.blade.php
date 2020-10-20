@extends('frontend_store_2.layout')

@section('before_header')
    <link rel="shortcut icon" href="/frontend/assets/img/favicon.png"/>
    <link rel="icon" href="/frontend/assets/img/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="/frontend/assets/img/favicon.png" type="image/vnd.microsoft.icon"/>

    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/bootstrapv4.5.min.css">
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/styleSurveyAction.css">

    <title data-react-helmet="true">Khảo sát</title>

    <script src="/frontend/assets/js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="/frontend/assets/js/page_all.js" type="text/javascript"></script>

@endsection    

@section('content')
    <body class="bodyHomeUser">
    @include('frontend_store_2.header_user')
    <main>
        @if ($survey->company_id)
            <div class="sortInfoBlock">
                <div class="fixCen">
                    <div class="avatar">
                        <img src="{{ $survey->company->logo ? url($survey->company->logo) : '/frontend/assets/img/demo-logo1.jpg' }}" alt="" class="imgFull">
                    </div>
                    <div class="txt">
                        {{ $survey->company->name }}
                    </div>
                </div>
            </div>
        @else
            <div class="sortInfoBlock">
                <div class="fixCen">
                    <div class="avatar">
                        <img src="{{ auth()->user()->avatar? url(auth()->user()->avatar) : '/frontend/assets/img/demo-logo1.jpg' }}" alt="" class="imgFull">
                    </div>
                    <div class="txt">
                        {{ auth()->user()->name }}
                    </div>
                </div>
            </div>
        @endif
        <div class="topBlock">
            <div class="fixCen hasBefore">
                <h2 class="title fz18px blue2">{{ $survey->name }}</h2>
                <div class="descriptionSurvey">
                    <p>{{ $survey->desc }}</p>
                    <p>Thời gian thực hiện: [{{ $survey->start_time? $survey->start_time->format('d/m/Y') : "" }}  - {{ $survey->end_time? $survey->end_time->format('d/m/Y') : "" }}]</p>
                </div>
            </div>
        </div>
        <div class="contentBlock">
            <div class="fixCen">
                <div class="topOfBox">
                    <h3 class="turnName">Vòng {{$question->round}}</h3>
                    <a href="javascript:void(0)" class="myBtn viewGuiding" title="Tạo chiến dịch" onclick="showPopup('#popupGuidings')">Hướng dẫn khảo sát</a>
                </div>
                <div class="box surveyContent">
                    <form id="answerSubmitForm" action="{{ route('frontend.answer') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="content">
                        <p>Thể hiện những đánh giá/cảm nhận của anh/chị về công ty tới thời điểm hiện tại</p>
                         <input type="hidden" name="question_id" value="{{ $question->id }}">
                        <div class="ruleOne rule">
                            <h4 class="question"><span>Câu {{ $question->order }}</span>
                                <div class="txt">
                                    {{ $question['name'] }}
                                </div>
                            </h4>
                            <ul class="listOptions">
                                @foreach(['option1', 'option2', 'option3', 'option4'] as $index => $opt)
                                <li>
                                    <div class="lstLeft">
                                        {{ $question->{$opt} }}
                                    </div>
                                    <div class="lstRight">
                                        <input type="number" value="{{ $answer? $answer->{$opt} : "" }}" id="value_{{$opt}}" name="{{ $opt }}">
                                    </div>
                                </li>
                                @endforeach

                                <li>
                                    <div class="lstLeft">
                                        <!--Xuất hiện khi user bấm next/enter mà tổng điểm khác 100-->
                                        <div id="total_warning" class="txtWarning">Tổng số điểm cần bằng 100</div>
                                    </div>
                                    <div class="lstRight">
                                        Tổng điểm <input type="number" readonly="readonly" id="total">
                                    </div>
                                </li>

                                @if (\App\Helpers::currentFrontendUserIsManager())

                                <li>
                                    <div class="lstLeft">
                                        Tự động tạo
                                    </div>
                                    <div class="lstRight">
                                        <input type="checkbox" name="random" value="1">
                                    </div>
                                </li>
                                @endif

                            </ul>
                        </div>
                    </div>
                    </form>
                    <div class="popupBot">
                        <a id="back_step" href="javascript:void(0)" class="btn-back" title="Quay lại">
                            <img src="/frontend/assets/img/btn-back.png" alt="" class="imgFull">
                        </a>
                        <div id="processing">
                            <span class="moc moc0"><i>Login</i></span>
                            <span class="moc moc1"><i>Hướng dẫn</i></span>
                            <span class="moc moc2 active"><i>Vòng 1</i></span>
                            <span class="moc moc3"><i>Vòng 2</i></span>
                            <span class="moc moc4"><i>Báo cáo</i></span>
                        </div>
                        <a id="next_step" href="javascript:void(0)" class="btn-next" title="Tiếp tục">
                            <img src="/frontend/assets/img/btn-next.png" alt="" class="imgFull">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('frontend_store_2.footer_user')
    </body>
@endsection

@section('after_scripts')
<script src="https://cdn.jsdelivr.net/npm/react@16.12/umd/react.production.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/react-dom@16.12/umd/react-dom.production.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/prop-types@15.7.2/prop-types.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/react-apexcharts@1.3.6/dist/react-apexcharts.iife.min.js"></script>

<script type="text/babel">
    class ApexChart extends React.Component {
        constructor(props) {
            super(props);

            this.state = {

                series: [{{ $roundPercent }},{{ 100-$roundPercent }}],
                options: {
                    labels: ['Đã hoàn thành', 'Chưa hoàn thành'],
                    colors: ['#9c5137', '#657558'],
                    chart: {
                        type: 'donut',
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                },


            };
        }



        render() {
            return (
                <div>
                    <div id="chart">
                        <ReactApexChart options={this.state.options} series={this.state.series} type="donut" />
                    </div>
                    <div id="html-dist"></div>
                </div>
            );
        }
    }

    const domContainer = document.querySelector('#circleChart');
    ReactDOM.render(React.createElement(ApexChart), domContainer);
</script>

<script>
    $(function(){

        function generate() {
            let option1 = $('#value_option1').val() > 0 ? parseInt($('#value_option1').val(), 10) : 0;
            let option2 = $('#value_option2').val() > 0 ? parseInt($('#value_option2').val(), 10) : 0;
            let option3 = $('#value_option3').val() > 0 ? parseInt($('#value_option3').val(), 10) : 0;
            let option4 = $('#value_option4').val() > 0 ? parseInt($('#value_option4').val(), 10) : 0;

            let totalVal = option1 + option2 + option3 + option4;

            if (totalVal> 100) {
                $('#total_warning').show();
                $('#total').val(totalVal);
            } else {
                $('#total_warning').hide();

                if (option1 > 0 && option2 > 0 && option3 > 0 && option4 === 0 && totalVal < 100) {
                    $('#value_option4').val(100 - totalVal);
                    $('#total').val(100);
                } else {
                    $('#total').val(totalVal);
                }
            }

        }

        generate();

        $('#value_option1, #value_option2, #value_option3, #value_option4').change(function(){
            generate();
            return false;
        });

        $('#next_step').click(function(){
            $('#answerSubmitForm').submit();
            return false;
        });

        $('#back_step').click(function(){
            $('#backQuestionForm').submit();
            return false;
        });

    });
</script>
@endsection