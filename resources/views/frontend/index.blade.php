@extends('frontend.layout')

@section('content')


@if (auth('frontend')->check())
    <script>window.location = "/home";</script>
@else
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
<div class="py128 p-slope-left product-hero-background">
    <h1 class="w90 mx-auto p-ff-roboto-slab-bold fs-display2 ta-center mb16">SenPlus</h1>
    <p class="fs-title ta-center w90 wmx4 mx-auto mb24">
        Nền tảng khảo sát trực tuyến. Chúng tôi mang đến giải pháp toàn diện cho người dùng cá nhân và doanh nghiệp
    </p>
    <div class="grid jc-center ai-center fs-body2 sm:fd-column">
        {{--<a class="btn px50 py12 btn-wide btn-outline-success" href="{{ route('frontend.register') }}" role="button">Đăng ký</a>--}}
        <a class="btn px41 py12 ml8 btn-wide btn-outline-success" href="{{ route('frontend.login') }}" role="button">Đăng nhập</a>
    </div>
</div>
</div>
@endif

@endsection