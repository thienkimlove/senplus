<table>
    <tbody><tr>
        <td>
            <p>Xin chào {{ $customer->name }},</p>
            <p>
                Bạn hoặc ai đó đã đăng ký tài khoản tại Sen Cộng với email <b>{{ $customer->email }}</b>.
            </p>
            <p>
                <strong>Để hoàn thành quá trình đăng ký</strong>, hãy bấm vào link sau: <br>
            </p>
            <p>
                <a href="{{ url('active?token='.$customer->token) }}">Account Activation</a>
            </p>
            <p>Xin cảm ơn,</p>
            <p>Công ty cổ phần Sen Cộng</p>
        </td>
    </tr>
    </tbody>
</table>