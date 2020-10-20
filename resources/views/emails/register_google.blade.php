<table>
    <tbody><tr>
        <td>
            <p>Xin chào {{ $customer->name }},</p>
            <p>
                Bạn hoặc ai đó đã đăng ký tài khoản tại Sen Cộng với tài khoản Google <b>{{ $customer->email }}</b>.
            </p>
            <p>
                <strong>Trong trường hợp bạn cần đăng nhập bằng mặt khẩu</strong>, hãy ghi nhớ mật khẩu: <br>
            </p>
            <p>
                <b>{{ $customer->password }}</b>
            </p>
            <p>Xin cảm ơn,</p>
            <p>Công ty cổ phần Sen Cộng</p>
        </td>
    </tr>
    </tbody>
</table>