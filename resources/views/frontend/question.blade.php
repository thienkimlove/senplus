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
                        Vòng {{ $question->round }}
                    </h3>
                </div>

            </div>
            <form action="{{ route('frontend.answer') }}" method="POST">
                <div class="kt-portlet__body">
                <div class="tab-content">
                    <div class="kt-widget5">

                        <div class="kt-widget5__item">
                            <div class="kt-widget5__content">
                                <div class="kt-widget5__section">
                                    {{ $question->name }}
                                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                                    {{ csrf_token() }}
                                </div>
                            </div>
                        </div>

                        @foreach(['option1', 'option2', 'option3', 'option4'] as $opt)
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__section">
                                        {{ $question->{$opt} }}
                                    </div>
                                    <div class="kt-widget5__sales">
                                        <input type="number" name="{{ $opt }}" />
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="kt-widget5__item">
                            <div class="kt-widget5__content">
                                <div class="kt-widget5__section">
                                    <input class="kt-mycart__button" type="submit" value="Tiếp Theo" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </form>
        </div>

        <!--end:: Widgets/Survey List-->
    </div>
</div>
</div>
@endsection