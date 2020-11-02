@extends('frontend.layout_home')

@section('content')
    <main>
        @include('frontend.partials.sort_block')
        <div class="topBlock">
            <div class="fixCen hasBefore">
                <h2 class="title">{{ $survey->name }}</h2>
                <a href="{{ route('frontend.campaign_create')  }}" class="myBtn addNewUser" title="Tạo chiến dịch">+ Tạo chiến dịch</a>
            </div>
        </div>

        <div class="editSurveyBlock editBlock">
            <div class="fixCen">
                <div class="box">
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
                    <form action="{{ route('frontend.post_campaign_edit') }}" method="POST" id="campaignSurveyForm">
                        {{ csrf_field() }}
                        <input type="hidden" name="survey_id" value="{{ $survey->id }}" />
                        <div class="form-group">
                            <label class="left" for="surveyName">Tên chiến dịch</label>
                            <input type="text" class="right" name="name" id="surveyName" value="{{ $survey->name }}" style="font-weight: bold;">
                        </div>
                        <div class="form-group">
                            <label class="left" for="description">Mô tả</label>
                            <textarea name="desc" class="right" rows="4" type="text" id="description" placeholder="">
                                {{ $survey->desc }}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label class="left" for="beginDate">Ngày bắt đầu</label>
                            <input type="text" name="start_time" class="datepicker right" id="beginDate" value="{{ $survey->start_time? $survey->start_time->format('d/m/Y H:i:s') : '' }}" >
                        </div>
                        <div class="form-group">
                            <label class="left" for="endDate">Ngày kết thúc</label>
                            <input type="text" name="end_time" class="datepicker right" id="endDate" value="{{ $survey->end_time? $survey->end_time->format('d/m/Y H:i:s') : '' }}" >
                        </div>

                        <div class="form-group">
                            <label class="left" for="surveyLink">Linh khảo sát</label>
                            <input type="text" name="link" id="surveyLink" class="right" value="{{ $survey->link? url($survey->link) : ''}}">
                        </div>
                        <div id="formButton" class="form-group showBtn">
                            <button id="cancelForm" data-url="{{ route('frontend.campaign_detail').'?id='.$survey->id }}" type="button">Bỏ qua</button>
                            <button id="submitForm" type="button" class="myBtn btnSave">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection    

@section('after_scripts')
    <script src="/frontend/assets/js/page_survey.js?v=1" type="text/javascript"></script>
    <script>
        $(function(){
            $('#cancelForm').click(function(){
                window.location.href =  $(this).attr('data-url');
            });

            $('#submitForm').click(function(){
                $('#campaignSurveyForm').submit();
                return false;
            });
        });
    </script>
@endsection