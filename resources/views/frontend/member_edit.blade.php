@extends('frontend.layout_home')

@section('after_head')
    <title data-react-helmet="true">Chi tiết thành viên</title>
@endsection


@section('content')
    <main>
        @include('frontend.partials.sort_block')
        <div class="searchBlock">
            <div class="fixCen hasBefore">
                
                @if (\App\Helpers::currentFrontendUserIsManager())                
                    <a href="{{ route('frontend.member_create') }}" class="myBtn addNewUser" title="Thêm mới">+ Thêm mới</a>

                    <a href="{{ route('frontend.member_edit') }}?id={{$customer->id}}" class="btnEdit" title="Chỉnh sửa">
                        <span>Chỉnh sửa</span>
                        <img src="/frontend/assets/img/i_pen.png" alt="" class="imgFull">
                    </a>
                @endif
                    <form action="" class="searchUser">
                        <input type="text" placeholder="Tìm kiếm" id="inputSearchDemo">
                       
                    </form>
            </div>

        </div>
        <div class="editInfoBlock editBlock">
            <div class="fixCen">
                <div class="box">
                    <form action="" id="userData">
                        <div class="form-group">
                            <label class="left" for="userName">Họ tên</label>
                            <input type="text" class="right" id="userName" value="{{ $customer->name }}" disabled style="font-weight: bold;">
                        </div>
                        <div class="form-group">
                            <label class="left" for="gender">Giới tính</label>
                            <input type="text" class="right" id="gender" value="{{ $customer->gender ? \App\Helpers::getGenders()[$customer->gender] : '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label class="left" for="email">Email</label>
                            <input type="text" class="right" id="email" value="{{ $customer->email }}" disabled>
                        </div>

                        @if ($company->filters)
                            @foreach ($company->filters as $filter)
                                @if ($value = \App\Helpers::getCustomerFilterValue($customer, $filter))
                                    <div class="form-group">
                                        <label class="left" for="filter_{{ $filter->name }}">{{ $filter->name }}</label>
                                        <input type="text" class="right" id="filter_{{ $filter->name }}" value="{{ $value }}" disabled>
                                    </div>
                                @endif
                            @endforeach
                        @endif


                        <div class="form-group">
                            <label class="left" for="showPermission">Phân quyền</label>
                            <input type="text" class="right" id="showPermission" value="{{ \App\Helpers::mapLevel()[$customer->level] }}" disabled>
                        </div>
                        <div class="form-group">
                            <button type="button" onclick="window.location.reload(); return false;">Bỏ qua</button>
                            <button type="button" class="myBtn btnSave">Lưu / Tạo mới</button>
                        </div>
                    </form>
                </div>
                <div class="campaignSurvey pr hasBefore">
                    <h2 class="title">Danh sách khảo sát</h2>
                    <nav class="menuBar">
                        <ul>
                            <li>Tổng số khảo sát: <span class="number black">{{ $countTotal }}</span></li>
                            <li>Hoàn thành: <span class="number blue">{{ $countCompleted }}</span></li>
                            <li>Chưa thực hiện: <span class="number red">{{ $countNotCompleted }}</span></li>
                        </ul>
                    </nav>
                    <div class="campaignList">
                        <ul>
                            @foreach ($surveys as $survey)
                                <li>
                                    <a href="javascript:void(0)" class="titleCampaign" title="{{ $survey->name }}" aria-label="Chiến dịch VHDN Celadon">{{ $survey->name }} ({{ $survey->created_at->format('d/m/Y') }})</a>

                                    @if (\App\Helpers::checkIfSurveyHaveResultForUser($survey, $customer->id))
                                        <a href="{{ route('frontend.result').'?id='.$survey->id }}" class="btnWait" title="Xem" aria-label="Xem">Xem</a>
                                    @else

                                        <a href="javascript:void(0)" class="btnWait" title="Chờ" aria-label="Wait">Chờ</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
