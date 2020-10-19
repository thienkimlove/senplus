<table>
    <tbody><tr>
        <td>
            <p>Xin chào {{ $customer->name }},</p>
            <p>
                Bạn hoặc ai đó đã thực hiện việc tìm lại mật khẩu tại Sen Cộng.
            </p>
            <p>
                <strong>Để hoàn thành quá trình lấy lại mật khẩu</strong>, hãy bấm vào link sau: <br>
            </p>
            <p>
                <a href="{{ url('forget?token='.$customer->token) }}">Quên mật khẩu</a>
            </p>
            <p>Xin cảm ơn,</p>
            <p>Công ty cổ phần Sen Cộng</p>
        </td>
    </tr>
    </tbody>
</table>