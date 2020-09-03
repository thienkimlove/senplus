@extends('frontend_v1.layout_default')

@section('content')
<div class="kt-login__signin">
    <div class="kt-login__head">
        <h3 class="kt-login__title">Đăng nhập | SenPlus</h3>
    </div>
    <form class="kt-form" method="POST" action="{{ route('frontend.post_login') }}">
        {{ csrf_field() }}
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off">
        </div>
        <div class="input-group">
            <input class="form-control" type="password" placeholder="Mật khẩu" name="password">
        </div>

        <div class="kt-login__actions">
            <button type="submit" id="kt_login_signin_submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Đăng nhập</button>
        </div>
        <div>
            @if (count($errors))
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
        </div>

    </form>
</div>
@endsection