<div>
    <h4>QUẢN LÝ NHÂN VIÊN</h4>
</div>

<div>
    Số liệu này thể hiện nhận thức của nhóm về những điều mà họ được khuyến khích, thúc đẩy tại {{ $explain['company_name'] }}.
</div>

<div>
    <b>{{ $explain['details'][3]['explainMax']->ten_van_hoa }}</b> được chấm điểm cao nhất ({{ $explain['details'][3]['maxValue'] }} điểm). Như vậy họ cho rằng:
</div>

<div>
    Cách quản lý nhân viên tại {{ $explain['company_name'] }} là <b>{{ $explain['details'][3]['explainMax']->dac_diem_noi_troi }}</b>
</div>

<div>
    <h4>SỰ KHÁC NHAU GIỮA HIỆN TẠI VÀ MONG MUỐN</h4>
</div>

<div>
    Chênh lệch điểm số giữa hiện tại và mong muốn thể hiện nhu cầu thay đổi của nhóm đối tượng khảo sát.
</div>

@if ($explain['details'][3]['moreThan'])
    <div>
        Có {{ count($explain['details'][3]['moreThan']) }} sự chênh lệch lớn hơn hoặc bằng 10, thể hiện nhu cầu thay đổi mạnh mẽ của họ đó là:
    </div>
    <div>
        <ul>
            @foreach ($explain['details'][3]['moreThan'] as $option)
                @php
                    $tempValue = round($explain['details'][3]['result'][2][$option] - $explain['details'][3]['result'][1][$option], 2);
                @endphp

                <li>{{ ($tempValue > 0) ? 'Gia tăng' : 'Giảm bớt' }} tỉ trọng của {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ $tempValue }} điểm) tương ứng với việc {{ $explain['all']->where('option', $option)->first()->phong_cach_lanh_dao }}</li>
            @endforeach
        </ul>
    </div>

@endif

@if ($explain['details'][3]['lessThan'])
    <div>
        Có {{ count($explain['details'][3]['lessThan']) }} sự chênh lệch lớn hơn hoặc bằng 10, thể hiện nhu cầu thay đổi cần lưu ý của họ đó là:
    </div>
    <div>
        <ul>
            @foreach ($explain['details'][3]['lessThan'] as $option)
                @php
                    $tempValue = round($explain['details'][3]['result'][2][$option] - $explain['details'][3]['result'][1][$option], 2);
                @endphp

                <li>{{ ($tempValue > 0) ? 'Gia tăng' : 'Giảm bớt' }} tỉ trọng của {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ $tempValue }} điểm) tương ứng với việc {{ $explain['all']->where('option', $option)->first()->phong_cach_lanh_dao }}</li>
            @endforeach
        </ul>
    </div>

@endif

<div>
    <h4>MỨC ĐỘ PHÙ HỢP</h4>
</div>

<div>
    Cách quản lý nhân viên hiện tại {{ \App\Helpers::getMatchName($explain['details'][3]['percentMatch']) }}.
</div>