@extends('frontend.cas.layout')


@section('content')
    <main>
        <h2 class="title tt hasBdt">Deactivated Account</h2>
        <form action="{{ route('frontend.post_deactivated') }}" method="POST" id="contactForm">
            {{ csrf_field() }}
            <div id="error" class="warning showWarning" style="display: none">Bạn chưa nhập đủ các thông tin yêu cầu !</div>

            <div class="form-group acception">
                Nhập vào email bạn muốn xóa khỏi hệ thống của chúng tôi.
            </div>

            <div class="form-group">
                <input type="email" placeholder="Email *" name="email" id="email">
            </div>


            <div class="form-group">
                <button id="submitContactForm" type="button">Submit</button>
            </div>
            <p style="text-align: center;">Sau khi bấm nút "Submit", dữ liệu tương ứng với tài khoản email của bạn sẽ được xóa khỏi hệ thống!</p>
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