@extends('frontend.layout')

@section('content')
    <div id="root">
        <div class="Root_1Kcx">
            @include('frontend.partials.header')

            <main>
                <div class="fixCen flex-between">
                    @if (\App\Helpers::haveResult())
                        <a href="{{ route('frontend.result') }}" class="myBtn btnTest">Xem kết quả</a>
                    @endif
                    <div class="showTurn"><h2 class="title">Vòng {{$question->round}} - {{ \App\Helpers::mapRound()[$question->round] }}</h2></div>
                    <div class="leftSide mt50 leftSideCircleChart">

                        <form id="answerSubmitForm" action="{{ route('frontend.answer') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="content mt50">
                                <div class="ques flex-between">
                                    <div class="txt" style="text-transform: uppercase;">{{ $question['name'] }}</div>
                                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                                </div>

                                @foreach(['option1', 'option2', 'option3', 'option4'] as $index => $opt)
                                    <div class="ques flex-between">
                                        <div class="stt">{{ $index+1 }}</div>
                                        <div class="txt">{{ $question->{$opt} }}</div>
                                        <input type="number" value="{{ $answer? $answer->{$opt} : "" }}" id="value_{{$opt}}" name="{{ $opt }}" min="0" max="100" />
                                    </div>
                                @endforeach

                                <div class="ques flex-between pr">
                                    <div class="txt">TOTAL</div>
                                    <input readonly="readonly" type="number" id="total">
                                    <div style="display: none" id="total_warning" class="warningTxt pa showWarning">Tổng số không > 100</div>
                                </div>

                                @if (\App\Helpers::currentFrontendUserIsAdmin())
                                <div class="ques flex-between pr">
                                    <div class="txt">Tự động tạo</div>
                                    <input type="checkbox" name="random" value="1">
                                </div>
                                @endif

                            </div>

                        </form>
                    </div>
                    <div class="rightSide mt50 rightSideCircleChart">
                        <div id="circleChart"></div>
                    </div>
                    <div class="bottom mt50 flex-between">
                        <a id="back_step" href="javascript:void(0)" class="myBtn btnBack" title="Quay lại">Quay lại</a>
                        <a id="next_step" href="javascript:void(0)" class="myBtn btnNext" title="Tiếp tục">Tiếp tục</a>
                    </div>

                    <form id="backQuestionForm" method="POST" action="{{ route('frontend.back') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                    </form>
                </div>
            </main>

        </div>
    </div>
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


