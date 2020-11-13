@extends('frontend.layout_home')

@section('content')
    <main>
        @include('frontend.partials.sort_block')
        <div class="topBlock">
            @if ($isNotCompleteSurveyId)
                <div class="fixCen hasBefore" id="filterMember">
                    <h2 class="title">Chưa hoàn thành khảo sát</h2>
                    <button type="button" id="remindButton" class="myBtn btnSave">Nhắc nhở</button>
                    <form id="remindForm" action="{{ route('frontend.post_member_remind') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="survey_id" value="{{ $isNotCompleteSurveyId }}">
                    </form>
                </div>

            @else
                <div class="fixCen hasBefore" id="filterMember">
                    <h2 class="title">Danh sách thành viên</h2>
                    <a href="{{ route('frontend.member_create') }}" class="myBtn addNewUser" title="Thêm mới">+ Thêm mới</a>
                    <form action="{{ route('frontend.member') }}" method="GET" class="searchUser">
                        <input type="text" placeholder="Tên/email" id="inputSearchDemo" name="q">
                    </form>
                </div>
            @endif
        </div>
        <div class="editSurveyBlock editBlock">
            <div class="fixCen">
                <div class="box">
                    <table class="tableList tableListMember">
                        <thead>
                        <tr>
                            <td>STT</td>
                            <td>Tên </td>
                            <td>Email</td>
                            @if ($company->filters)
                                @foreach ($company->filters as $filter)
                                <td>
                                    {{ $filter->name }}
                                </td>
                                @endforeach
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($customers as $index => $customer)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>
                                <a href="{{ route('frontend.personal').'?id='.$customer->id }}" class="link" title="Tên thành viên">{{ $customer->name }}</a>
                                <a href="{{ route('frontend.member_detail').'?id='.$customer->id }}" class="btnEditMember" title="Sửa thông tin"></a>
                            </td>
                            <td>{{ $customer->email }}</td>

                            @if ($company->filters)
                                @foreach ($company->filters as $filter)
                                    <td>
                                        {{ \App\Helpers::getCustomerFilterValue($customer, $filter) }}
                                    </td>
                                @endforeach
                            @endif
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                @include('frontend.pagination', ['paginate' => $customers])
            </div>
        </div>
    </main>

@endsection

@section('after_scripts')
    <script>
        $(function(){
            $('#remindButton').click(function(){
                $('#remindForm').submit();
                return false;
            });
        });
    </script>

@endsection