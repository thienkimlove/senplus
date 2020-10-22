<div>
    <h4>PHONG CÁCH LÃNH ĐẠO</h4>
</div>

<div>
    Số liệu này thể hiện nhận thức của nhóm về cách ứng xử của người đứng đầu hoặc các lãnh đạo tại {{ $explain['company_name'] }}.
</div>

<div>
    <b>{{ $explain['details'][2]['explainMax']->ten_van_hoa }}</b> được chấm điểm cao nhất ({{ $explain['details'][2]['maxValue'] }} điểm). Như vậy họ cho rằng:
</div>

<div>
    Phong cách của lãnh đạo {{ $explain['company_name'] }} là <b>{{ $explain['details'][2]['explainMax']->dac_diem_noi_troi }}</b>
</div>

<div>
    <h4>SỰ KHÁC NHAU GIỮA HIỆN TẠI VÀ MONG MUỐN</h4>
</div>

<div>
    Chênh lệch điểm số giữa hiện tại và mong muốn thể hiện nhu cầu thay đổi của nhóm đối tượng khảo sát.
</div>

@if ($explain['details'][2]['moreThan'])
    <div>
        Có {{ count($explain['details'][2]['moreThan']) }} sự chênh lệch lớn hơn hoặc bằng 10, thể hiện nhu cầu thay đổi mạnh mẽ của họ đó là:
    </div>
    <div>
        <ul>
            @foreach ($explain['details'][2]['moreThan'] as $option)
                @php
                    $tempValue = round($explain['details'][2]['result'][2][$option] - $explain['details'][2]['result'][1][$option], 2);
                @endphp

                <li>{{ ($tempValue > 0) ? 'Gia tăng' : 'Giảm bớt' }} tỉ trọng của {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ $tempValue }} điểm) tương ứng với phong cách {{ $explain['all']->where('option', $option)->first()->phong_cach_lanh_dao }}</li>
            @endforeach
        </ul>
    </div>

@endif

@if ($explain['details'][2]['lessThan'])
    <div>
        Có {{ count($explain['details'][2]['lessThan']) }} sự chênh lệch lớn hơn hoặc bằng 10, thể hiện nhu cầu thay đổi cần lưu ý của họ đó là:
    </div>
    <div>
        <ul>
            @foreach ($explain['details'][2]['lessThan'] as $option)
                @php
                    $tempValue = round($explain['details'][2]['result'][2][$option] - $explain['details'][2]['result'][1][$option], 2);
                @endphp

                <li>{{ ($tempValue > 0) ? 'Gia tăng' : 'Giảm bớt' }} tỉ trọng của {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ $tempValue }} điểm) tương ứng với phong cách {{ $explain['all']->where('option', $option)->first()->phong_cach_lanh_dao }}</li>
            @endforeach
        </ul>
    </div>

@endif

<div>
    <h4>MỨC ĐỘ PHÙ HỢP</h4>
</div>

<div>
    Phong cách lãnh đạo hiện tại {{ \App\Helpers::getMatchName($explain['details'][2]['percentMatch']) }}.
</div>