<div>
    <h4>QUẢN LÝ NHÂN VIÊN</h4>
</div>

<div>
    Số liệu này thể hiện nhận thức của nhóm đối tượng khảo sát về đặc điểm của môi trường làm việc tại {{ $explain['company_name'] }}.
</div>

<div>
    <b>{{ $explain['details'][1]['explainMax']->ten_van_hoa }}</b> được chấm điểm cao nhất ({{ $explain['details'][1]['maxValue'] }} điểm). Như vậy họ cho rằng:
</div>

<div>
    Đặc điểm nổi trội của {{ $explain['company_name'] }} là <b>{{ $explain['details'][1]['explainMax']->dac_diem_noi_troi }}</b>
</div>

<div>
    <h4>SỰ KHÁC NHAU GIỮA HIỆN TẠI VÀ MONG MUỐN</h4>
</div>

<div>
    Chênh lệch điểm số giữa hiện tại và mong muốn thể hiện nhu cầu thay đổi của nhóm đối tượng khảo sát.
</div>

@if ($explain['details'][1]['moreThan'])
    <div>
        Có {{ count($explain['details'][1]['moreThan']) }} sự chênh lệch lớn hơn hoặc bằng 10, thể hiện nhu cầu thay đổi mạnh mẽ của họ đó là:
    </div>
    <div>
        <ul>
            @foreach ($explain['details'][1]['moreThan'] as $option)
                @php
                    $tempValue = round($explain['details'][1]['result'][2][$option] - $explain['details'][1]['result'][1][$option]);
                    //dd($explain['explainAll']->where('option', $option));
                @endphp

                <li>{{ ($tempValue > 0) ? 'Gia tăng' : 'Giảm bớt' }} tỉ trọng của {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ abs($tempValue) }} điểm) tương ứng với đặc điểm  {{ $explain['all']->where('option', $option)->first()->dac_diem_noi_troi }}</li>
            @endforeach
        </ul>
    </div>

@endif

<div>
    <h4>MỨC ĐỘ PHÙ HỢP</h4>
</div>

<div>
    Môi trường làm việc hiện tại {{ \App\Helpers::getMatchName($explain['details'][1]['percentMatch']) }}.
</div>