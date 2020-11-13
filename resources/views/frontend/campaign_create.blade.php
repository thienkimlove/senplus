@extends('frontend.layout_home')

@section('content')
    <main>
        @include('frontend.partials.sort_block')
        <div class="topBlock">
            <div class="fixCen hasBefore">
                <h2 class="title">Tạo chiến dịch</h2>
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
                    <form action="{{ route('frontend.post_campaign_create') }}" method="POST" id="campaignSurveyForm">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="left" for="surveyName">Tên chiến dịch</label>
                            <input type="text" class="right" name="name" id="surveyName" value="{{ old('name') }}" style="font-weight: bold;">
                        </div>
                        <div class="form-group">
                            <label class="left" for="description">Mô tả</label>
                            <textarea name="desc" class="right" rows="4" type="text" id="description">{{ old('desc') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="left" for="beginDate">Ngày bắt đầu</label>
                            <input type="text" name="start_time" class="datepicker right" id="beginDate" value="{{ old('start_time') }}" >
                        </div>
                        <div class="form-group">
                            <label class="left" for="endDate">Ngày kết thúc</label>
                            <input type="text" name="end_time" class="datepicker right" id="endDate" value="{{ old('end_time') }}" >
                        </div>

                        <div class="form-group">
                            <label class="left" for="position">Chọn loại khảo sát</label>
                            <select name="template_type" id="position" class="right">
                                @foreach (\App\Helpers::TEMPLATE_QUESTION_TYPES as $index => $value)
                                    <option value="{{ $index }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="left" for="surveyLink">Link khảo sát</label>
                            <input type="text" name="link" id="surveyLink" class="right" value="{{ old('link', url('/').'/'.\App\Helpers::getRandomLinkSurvey())  }}">
                        </div>
                        <div id="formButton" class="form-group showBtn">
                            <button id="cancelForm" data-url="{{ route('frontend.campaign') }}" type="button">Bỏ qua</button>
                            <button id="submitForm" type="button" class="myBtn btnSave">Tạo mới</button>
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