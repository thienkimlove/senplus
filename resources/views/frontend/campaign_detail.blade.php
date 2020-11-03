@extends('frontend.layout_home')

@section('content')
    <main>
        @include('frontend.partials.sort_block')
        <div class="topBlock">
            <div class="fixCen hasBefore">
                <h2 class="title">{{ $survey->name }}</h2>
                <a href="{{ route('frontend.campaign_create')  }}" class="myBtn addNewUser" title="Tạo chiến dịch">+ Tạo chiến dịch</a>
                <a href="{{ route('frontend.campaign_edit').'?id='.$survey->id  }}" class="btnEdit" title="Chỉnh sửa"><span>Chỉnh sửa</span>
                    <img src="/frontend/assets/img/i_pen.png" alt="" class="imgFull">
                </a>
            </div>
        </div>

        <div class="editSurveyBlock editBlock">
            <div class="fixCen">
                <div class="box">
                    <form action="javascript:void(0)" method="POST" id="campaignSurveyForm">
                        <div class="form-group">
                            <label class="left" for="surveyName">Tên chiến dịch</label>
                            <input type="text" class="right" name="name" id="surveyName" value="{{ $survey->name }}" disabled style="font-weight: bold;">
                        </div>
                        <div class="form-group">
                            <label class="left" for="description">Mô tả</label>
                            <textarea name="desc" class="disabled right" rows="4" type="text" id="description"disabled>{{ $survey->desc }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="left" for="beginDate">Ngày bắt đầu</label>
                            <input type="text" name="start_time" class="datepicker right disabled" id="beginDate" value="{{ $survey->start_time? $survey->start_time->format('d/m/Y H:i:s') : '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="left" for="endDate">Ngày kết thúc</label>
                            <input type="text" name="end_time" class="disabled datepicker right" id="endDate" value="{{ $survey->end_time? $survey->end_time->format('d/m/Y H:i:s') : '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label class="left" for="surveyLink">Link khảo sát</label>
                            <input type="text" name="link" id="surveyLink" class="disabled right" value="{{ $survey->link? url($survey->link) : ''}}" disabled>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

