@extends('frontend_store.layout')

@section('content')
    <div id="root">
        <div class="Root_1Kcx">

            @include('frontend_store.partials.header')

            <main>
                <div class="fixCen flex-between">
                    <div class="content">
                        <div class="tabs flex-between">
                            <div class="txt">Danh sách khảo sát của bạn</div>
                        </div>
                        <div class="filterContent">
                            <div class="tabContent active">
                                @if ($surveys)
                                    @foreach ($surveys as $survey)
                                        <div class="item flex-between">
                                        <a class="logoCompany" href="{{ route('frontend.survey') }}?id={{ $survey->id }}" title="{{ $survey['name'] }}">
                                            <img src="{{ url('frontend/assets/img/logo.png') }}" alt="Logo">
                                        </a>
                                        <a href="{{ route('frontend.survey') }}?id={{ $survey->id }}" class="txt" title="{{ $survey['name'] }}">{{ $survey['name'] }}</a>
                                        <div class="btnGroup">

                                            @if (\App\Helpers::checkIfSurveyHaveResultForUser($survey))
                                                <a class="myBtn btnViewResult" href="{{ route('frontend.result') }}?id={{ $survey->id }}" title="Xem kết quả">Xem kết quả</a>
                                            @else
                                                <a class="myBtn btnTest" href="{{ route('frontend.survey') }}?id={{ $survey->id }}" title="Bắt đầu khảo sát">Bắt đầu khảo sát</a>
                                            @endif

                                            @if ($survey->company_id && \App\Helpers::currentFrontendUserIsManager())
                                                <a class="myBtn btnProfile" href="{{ route('frontend.general') }}?id={{ $survey->id }}" title="Hồ sơ doanh nghiệp">Hồ sơ doanh nghiệp</a>
                                            @endif

                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        @if (\App\Helpers::currentFrontendUserIsAdmin())
                            <div class="tabs flex-between">
                                <div class="txt">Danh sách tài khoản manager</div>
                            </div>

                            <div class="filterContent">
                                <div class="tabContent active">
                                    @if ($managers = \App\Helpers::getListManagerForCurrentUser())
                                        @foreach ($managers as $manager)
                                            <div class="item flex-between">
                                                <a href="javascript:void(0)">{{ $manager->login }}</a>
                                                <div class="btnGroup">
                                                    <a class="myBtn btnProfile" href="{{ route('frontend.remove_manager') }}?id={{ $manager->id }}" title="remove">Remove Access</a>

                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        Không có manager nào.
                                    @endif
                                </div>
                            </div>

                            <div class="tabs flex-between">
                                <div class="txt">Thêm manager</div>
                            </div>
                            <div class="filterContent">
                                <form action="{{ route('frontend.add_manager') }}"
                                      method="POST"
                                      id="addManager">
                                    <div class="form-group">
                                        {{ csrf_field() }}
                                        <input type="email" name="login" id="reg_email" placeholder="Nhập tài khoản (Email/Username)">
                                    </div>

                                    <div id="add_error" style="display: {{ count($errors) ? 'visible' : 'hidden' }}" class="error">
                                        * Cần nhập đầy đủ thông tin
                                    </div>

                                    <a id="btnAdd" href="javascript:void(0)" title="Thêm Manager">Thêm Manager</a>
                                </form>

                            </div>
                        @endif
                    </div>
                </div>
            </main>


        </div>
    </div>
@endsection

@section('after_scripts')
    <script>
        $(function(){
            $('#btnAdd').click(function(){
                let email = $('#reg_email').val();
                let errorEle = $('#add_error');

                if (!email) {
                    errorEle.show();
                    return false;
                }

                $('form#addManager').submit();

                return false;
            });
        });
    </script>
@endsection
