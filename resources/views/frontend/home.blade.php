@extends('frontend.layout')

@section('content')
    <div id="root">
        <div class="Root_1Kcx">

            @include('frontend.partials.header')

            <main>
                <div class="fixCen flex-between">
                    <div class="myBtn btnTest" title="Test">Test</div>
                    <div class="content">
                        <div class="tabs flex-between">
                            <div class="txt">Danh sách khảo sát của bạn</div>
                            <div class="filter">
                                <ul>
                                    <li class="active btnShowTab" data-content="#newest"><a href="javascript:void(0)" title="Mới nhất">Mới nhất</a></li>
                                    {{--<li class="btnShowTab" data-content="#newest"><a href="javascript:void(0)" title="Tháng này">Tháng này</a></li>--}}
                                    {{--<li class="btnShowTab" data-content="#newest"><a href="javascript:void(0)" title="Tất cả">Tất cả</a></li>--}}
                                </ul>
                            </div>
                        </div>
                        <div class="filterContent">
                            <div class="tabContent active" id="newest">
                                @if ($survey)
                                    <div class="item flex-between">
                                        <a class="logoCompany" href="{{ route('frontend.question') }}" title="{{ $survey['name'] }}">
                                            <img src="{{ url('frontend/assets/img/logo.png') }}" alt="Logo">
                                        </a>
                                        <a href="{{ route('frontend.question') }}" class="txt" title="{{ $survey['name'] }}">{{ $survey['name'] }}</a>
                                        <div class="btnGroup">

                                            @if (\App\Helpers::haveResult())
                                                <a class="myBtn btnViewResult" href="{{ route('frontend.result') }}" title="Xem kết quả">Xem kết quả</a>
                                            @else
                                                <a class="myBtn btnTest" href="{{ route('frontend.question') }}" title="Bắt đầu khảo sát">Bắt đầu khảo sát</a>
                                            @endif

                                            @if (\App\Helpers::currentFrontendUserIsAdmin())
                                                <a class="myBtn btnProfile" href="javascript:void(0)" title="Hồ sơ doanh nghiệp">Hồ sơ doanh nghiệp</a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </main>


        </div>
    </div>
@endsection
