@extends('frontend.layout')


@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
<div class="row justify-content-md-center">
    <div class="col-xl-8">
        <!--begin:: Widgets/Survey List-->
        <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Danh sách khảo sát của bạn
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_widget5_tab1_content" role="tab" aria-selected="true">
                                Mới nhất
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_widget5_tab2_content" role="tab" aria-selected="false">
                                Tháng này
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_widget5_tab3_content" role="tab" aria-selected="false">
                                Tất cả
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div class="kt-widget5">
                        @if ($survey)
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                        <img class="kt-widget7__img" src="{{ url('frontend/images/product27.jpg') }}" alt="survey_image_title">
                                    </div>
                                    <div class="kt-widget5__section">
                                        <a href="{{ route('frontend.question') }}" target="_blank" class="kt-widget5__title">
                                            {{ $survey['name'] }}
                                        </a>
                                    </div>
                                </div>
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__stats">
                                        <!-- <span class="kt-widget5__number">19,200</span>
                                        <span class="kt-widget5__sales">lượt xem</span> -->
                                    </div>
                                    <div class="kt-widget5__stats">
                                        <!-- <span class="kt-widget5__number">1046</span>
                                        <span class="kt-widget5__votes">lượt khảo sát</span> -->
                                    </div>
                                </div>
                            </div>
                        @else
                            <p>Bạn không có yêu cầu khảo sát nào!</p>
                        @endif
                    </div>
                    <div class="tab-pane" id="kt_widget5_tab2_content">
                        <div class="kt-widget5">
                            Tính năng chưa được hỗ trợ
                        </div>
                    </div>
                    <div class="tab-pane" id="kt_widget5_tab3_content">
                        <div class="kt-widget5">
                            Tính năng chưa được hỗ trợ
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--end:: Widgets/Survey List-->
    </div>
</div>
</div>
@endsection