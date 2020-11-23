<div>
    <h4>CHIẾN LƯỢC</h4>
</div>

<div>
    Số liệu này thể hiện nhận thức của nhóm về định hướng chiến lược của {{ $explain['company_name'] }}.
</div>

<div>
    <b>{{ $explain['details'][5]['explainMax']->ten_van_hoa }}</b> được chấm điểm cao nhất ({{ $explain['details'][5]['maxValue'] }} điểm). Như vậy họ cho rằng:
</div>

<div>
    Định hướng chiến lược của {{ $explain['company_name'] }} là <b>{{ $explain['details'][5]['explainMax']->chien_luoc }}</b>
</div>

<div>
    <h4>KHOẢNG CÁCH GIỮA HIỆN TẠI VÀ MONG MUỐN</h4>
</div>

<div>
    Chênh lệch điểm số giữa hiện tại và mong muốn thể hiện nhu cầu thay đổi của nhóm đối tượng khảo sát.
</div>

@if ($explain['details'][5]['moreThan'])
    <div>
        Có {{ count($explain['details'][5]['moreThan']) }} sự chênh lệch lớn hơn hoặc bằng 10, thể hiện nhu cầu thay đổi mạnh mẽ của họ đó là:
    </div>
    <div>
        <ul>
            @foreach ($explain['details'][5]['moreThan'] as $option)
                @php
                    $tempValue = round($explain['details'][5]['result'][2][$option] - $explain['details'][5]['result'][1][$option], 2);
                @endphp

                <li>{{ ($tempValue > 0) ? 'Gia tăng' : 'Giảm bớt' }} tỉ trọng của {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ $tempValue }} điểm) tương ứng với việc {{ $explain['all']->where('option', $option)->first()->phong_cach_lanh_dao }}</li>
            @endforeach
        </ul>
    </div>

@endif

@if ($explain['details'][5]['lessThan'])
    <div>
        Có {{ count($explain['details'][5]['lessThan']) }} sự chênh lệch nhỏ hơn 10 và lớn hơn hoặc bằng 5, thể hiện nhu cầu thay đổi cần lưu ý của họ đó là:
    </div>
    <div>
        <ul>
            @foreach ($explain['details'][5]['lessThan'] as $option)
                @php
                    $tempValue = round($explain['details'][5]['result'][2][$option] - $explain['details'][5]['result'][1][$option], 2);
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
    <table border="1">
        <thead>
        <tr>
            <th>VĂN HÓA / THAY ĐỔI</th>
            <th>Tổng quan</th>
            <th>Chiến lược</th>
            <th>Chênh lệch</th>
        </tr>
        </thead>
        <tbody>
        @foreach (\App\Helpers::ARRAY_OPTIONS as $option)
            <tr>
                <td><b>{{ $explain['all']->where('option', $option)->first()->ten_van_hoa }}</b></td>
                <td>{{ round($explain['details'][7]['result'][2][$option] - $explain['details'][7]['result'][1][$option], 2) }}</td>
                <td>{{ round($explain['details'][5]['result'][2][$option] - $explain['details'][5]['result'][1][$option], 2) }}</td>
                <td>{{ \App\Helpers::getXValue($explain, 5, $option) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div>
    Theo đánh giá của nhóm thì định hướng chiến lược hiện tại {{ \App\Helpers::getMatchName($explain['extends'][5]['percentMatch']) }} ({{$explain['extends'][5]['percentMatch']}}%)

    @if (count($explain['extends'][5]['bigThan']) == 0) do cả 4 giá trị cột chênh lệch đều < 5. @endif

    @if (count($explain['extends'][5]['bigThan']) == 3) do có 3 giá trị của cột chênh lệch >= 5, tương ứng với
    @foreach ($explain['extends'][5]['bigThan'] as $option)
        {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ \App\Helpers::getXValue($explain, 5, $option) }} điểm).
    @endforeach
    @endif

    @if (count($explain['extends'][5]['bigThan']) == 2) do có 2 giá trị của cột chênh lệch >= 5, tương ứng với
    @foreach ($explain['extends'][5]['bigThan'] as $option)
        {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ \App\Helpers::getXValue($explain, 5, $option) }} điểm).
    @endforeach
    @endif

    @if (count($explain['extends'][5]['bigThan']) == 1) do có 1 giá trị của cột chênh lệch >= 5, tương ứng với
    @foreach ($explain['extends'][5]['bigThan'] as $option)
        {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ \App\Helpers::getXValue($explain, 5, $option) }} điểm).
    @endforeach
    @endif

    @if (count($explain['extends'][5]['bigThan']) == 4) do cả 4 giá trị của cột chênh lệch đều >= 5. @endif

</div>