<table>
    <tbody><tr>
        <td>
            <p>Xin chào {{ $customer->name }},</p>
            <p>
                Bạn hoặc ai đó vừa sử dụng email này để thực hiện việc lấy lại mật khẩu tại CASONLINE – Hệ thống Khảo sát và Đánh giá Môi trường Văn hoá Doanh nghiệp

            </p>
            <p>
                Bấm vào link dưới đây để hoàn thành việc lấy lại mật khẩu: <br>
            </p>
            <p>
                <a href="{{ url('forget?token='.$customer->token) }}">Quên mật khẩu</a>
            </p>
            <p>Xin cảm ơn,</p>
            <p>
                -----------------<br/>
                <b>HỆ THỐNG KHẢO SÁT VÀ ĐÁNH GIÁ MÔI TRƯỜNG VĂN HOÁ DOANH NGHIỆP – CASONLINE</b><br/>
                Hotline: 0967 573 573 | Email: info@casonline.vn | http://casonline.vn
            </p>
        </td>
    </tr>
    </tbody>
</table>