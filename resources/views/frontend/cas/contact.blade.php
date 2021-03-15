@extends('frontend.cas.layout')


@section('content')
    <main>
        <h2 class="title tt hasBdt">Liên hệ với CAS online</h2>
        <form action="{{ route('frontend.post_contact') }}" method="POST" id="contactForm">
            {{ csrf_field() }}
            <div id="error" class="warning showWarning" style="display: none">Bạn chưa nhập đủ các thông tin yêu cầu !</div>
            <div class="form-group">
                <input type="text" placeholder="Họ và tên *" name="name" id="name">
            </div>
            <div class="form-group">
                <input type="text" placeholder="Số điện thoại *" name="phone" id="phone">
            </div>
            <div class="form-group">
                <input type="email" placeholder="Email *" name="email" id="email">
            </div>
            <div class="form-group">
                <select name="option" id="option">
                    <option value="">Mong muốn của bạn *</option>
                    @foreach (\App\Helpers::CONTACT_OPTIONS as $key => $val)
                        <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <textarea name="content" cols="30" rows="6" placeholder="Nhập nội dung"></textarea>
            </div>
            <div class="form-group acception">
                Truy cập mục <a href="javascript:void(0)"  class="blue" title="Hướng dẫn" aria-label="Hướng dẫn" target="_blank" rel="noreferrer">Hướng dẫn</a>
                <br>hoặc liên hệ hotline <a href="tel:0967573573">0967 573 573</a> để biết thêm chi tiết
            </div>
            <div class="form-group">
                <button id="submitContactForm" type="button">Gửi</button>
            </div>
        </form>
    </main>
@endsection

@section('after_scripts')
    <script>
        $(function(){
            $('#submitContactForm').click(function(){

                let name = $('#name');
                let phone = $('#phone');
                let email = $('#email');
                let option = $('#option');

                let error = $('#error');

                if (name.val() === '' || phone.val() === '' || email.val() ===
                '' || option.val() === '') {
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