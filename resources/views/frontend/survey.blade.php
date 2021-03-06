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

                <div id="error" class="warning {{ count($errors) ? 'showWarning' : '' }}">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <form id="answerSubmitForm" action="{{ route('frontend.answer') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <div class="box surveyContent">
                    <div class="content">
                        <p>
                            @if ($question->round == 1)
                                {{ $survey->round_1_desc }}
                            @else
                               {{ $survey->round_2_desc }}
                            @endif
                        </p>
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
                                            <input type="number" min="0" max="100" value="{{ $answer? $answer->{$opt} : "" }}" id="value_{{$opt}}" name="{{ $opt }}">
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

                                    @if (\App\Helpers::currentFrontendUserIsDemo())

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
                            <a id="back_step" href="{{ route('frontend.back') }}?question_id={{ $question->id }}" class="btn-back" title="Quay lại">
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

        function isEmpty(ele) {
            return (ele.val().length === 0);
        }

        function getVal(ele) {
            return parseInt(ele.val(), 10);
        }



        function generate() {

            let option1 = $('#value_option1');
            let option2 = $('#value_option2');
            let option3 = $('#value_option3');
            let option4 = $('#value_option4');

            if ((getVal(option1) === 100) && isEmpty(option2) && isEmpty(option3) && isEmpty(option4)) {
                option2.val(0);
                option3.val(0);
                option4.val(0);
            }

            if ((getVal(option2) === 100) && isEmpty(option1) && isEmpty(option3) && isEmpty(option4)) {
                option1.val(0);
                option3.val(0);
                option4.val(0);
            }

            if ((getVal(option3) === 100) && isEmpty(option1) && isEmpty(option2) && isEmpty(option4)) {
                option1.val(0);
                option2.val(0);
                option4.val(0);
            }

            if ((getVal(option4) === 100) && isEmpty(option1) && isEmpty(option2) && isEmpty(option3)) {
                option1.val(0);
                option2.val(0);
                option3.val(0);
            }

            if (!isEmpty(option1) && !isEmpty(option2) && !isEmpty(option3) && isEmpty(option4)) {
                //auto fill
                let option4Value = 100 - (getVal(option1) + getVal(option2) + getVal(option3));
                option4.val(option4Value);
            }

            if (!isEmpty(option1) && !isEmpty(option2) && !isEmpty(option3) && !isEmpty(option4)) {
                let totalVal = getVal(option1) + getVal(option2) + getVal(option3) + getVal(option4);

                $('#total').val(totalVal);
                if (totalVal !== 100) {
                    $('#total_warning').show();
                } else {
                    $('#total_warning').hide();
                }
            }



        }
        $(function(){
            generate();

            $('#value_option1, #value_option2, #value_option3, #value_option4').change(function(){
                generate();
                return false;
            });

            $('#answerSubmitForm input[type="number"]:first').focus();

            $('input').keypress(function(event){
                if(event.which === 13){
                    event.preventDefault();
                    $('#answerSubmitForm').submit();
                    return false;
                }
            });



            $('#next_step').click(function(){
                $('#answerSubmitForm').submit();
                return false;
            });

        });
    </script>
@endsection

