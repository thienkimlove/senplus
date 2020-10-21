@extends('frontend.layout_home')

@section('content')
    <main>
        @include('frontend.partials.sort_block')
        <div class="topBlock">
            <div class="fixCen hasBefore">
                <h2 class="title fz18px blue2">{{ $survey->name }}</h2>
                <div class="descriptionSurvey">
                    <p>{{ \Illuminate\Support\Str::limit($survey->desc, 200)  }}</p>
                    <p>Thời gian thực hiện: [{{ $survey->start_time? $survey->start_time->format('d/m/Y') : "" }}  - {{ $survey->end_time? $survey->end_time->format('d/m/Y') : "" }}]</p>
                </div>
            </div>
        </div>
        <div class="contentBlock">
            <div class="fixCen">
                <div class="topOfBox">
                    <h3 class="turnName">Vòng {{$question->round}}</h3>
                    <a href="javascript:void(0)" class="myBtn viewGuiding" title="Tạo chiến dịch" onclick="showPopupGuiding('#popupGuidings2')">Hướng dẫn khảo sát</a>
                </div>
                <form id="answerSubmitForm" action="{{ route('frontend.answer') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <div class="box surveyContent">
                    <div class="content">
                        <p>Thể hiện những đánh giá/cảm nhận của anh/chị về công ty tới thời điểm hiện tại</p>
                        <div class="ruleOne rule">
                            <h4 class="question"><span>Câu {{ $question->order }}</span>
                                <div class="txt">{{ $question['name'] }}</div>
                            </h4>
                            <ul class="listOptions">
                                @foreach(\App\Helpers::ARRAY_OPTIONS as $index => $opt)
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
                        <div class="popupBot">
                            <a id="back_step" href="javascript:void(0)" class="btn-back" title="Quay lại">
                                <img src="/frontend/assets/img/btn-back.png" alt="" class="imgFull">
                            </a>
                            <div id="processing">
                                <span class="moc moc0"><i>Login</i></span>
                                <span class="moc moc1"><i>Hướng dẫn</i></span>
                                <span class="moc moc2 {{ ($question->round == 1)? 'active' : '' }}"><i>Vòng 1</i></span>
                                <span class="moc moc3 {{ ($question->round == 2)? 'active' : '' }}"><i>Vòng 2</i></span>
                                <span class="moc moc4"><i>Báo cáo</i></span>
                            </div>
                            <a id="next_step" href="javascript:void(0)" class="btn-next" title="Tiếp tục">
                                <img src="/frontend/assets/img/btn-next.png" alt="" class="imgFull">
                            </a>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </main>
@endsection

@section('after_scripts')
    <script>
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
        $(function(){
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

