@extends('frontend.layout')

@section('content')
    <div id="root">
        <div class="Root_1Kcx">

            @include('frontend.partials.header')

            <main>
                <div class="fixCen flex-between">

                    @if (\App\Helpers::haveResult())
                        <div class="myBtn btnTest" title="Test"><a href="{{ route('frontend.result') }}">Xem kết quả</a></div>
                    @endif

                    {{--<div class="myBtn btnTest" title="Test">Test</div>--}}
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
                                <a class="item flex-between" href="{{ route('frontend.question') }}" title="Bộ câu hỏi cho doanh nghiệp Công ty Senplus">
                                    <div class="logoCompany">
                                        <img src="{{ url('frontend/assets/img/logo.png') }}" alt="Logo" />
                                    </div>
                                    <div class="txt">{{ $survey['name'] }}</div>
                                </a>

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </main>


        </div>
    </div>
@endsection
