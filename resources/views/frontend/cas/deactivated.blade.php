@extends('frontend.cas.layout')


@section('content')
    <main>
        <h2 class="title tt hasBdt">Deactivated Account</h2>
        <form action="{{ route('frontend.post_deactivated') }}" method="POST" id="contactForm">
            {{ csrf_field() }}
            <div id="error" class="warning showWarning" style="display: none">Bạn chưa nhập đủ các thông tin yêu cầu !</div>

            <div class="form-group">
                <input type="email" placeholder="Email *" name="email" id="email">
            </div>

            <div class="form-group acception">
                Truy cập mục <a href="javascript:void(0)"  class="blue" title="Hướng dẫn" aria-label="Hướng dẫn" target="_blank" rel="noreferrer">Hướng dẫn</a>
                <br>hoặc liên hệ hotline <a href="tel:0967573573">0967 573 573</a> để biết thêm chi tiết
            </div>
            <div class="form-group">
                <button id="submitContactForm" type="button">Gửi</button>
            </div>
            <p style="text-align: center;">Cảm ơn bạn đã liên hệ với CAS Online! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.</p>
        </form>
    </main>
@endsection

@section('after_scripts')
    <script>
        $(function(){
            $('#submitContactForm').click(function(){

                let email = $('#email');

                let error = $('#error');

                if (email.val() ==='') {
                    error.show();
                } else {
                    error.hide();
                    $('#contactForm').submit();
                }

                return false;
            });
        });
    </script>
@endsection