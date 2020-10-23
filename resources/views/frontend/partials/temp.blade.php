<div>
    <h4>MỨC ĐỘ PHÙ HỢP</h4>
</div>

<div>
    <table border="1">
        <thead>
        <tr>
            <th>SỰ PHÙ HỢP</th>
            <th>Nhu cầu thay đổi về quản lý nhân viên</th>
            <th>Nhu cầu thay đổi tổng quan</th>
            <th>Chênh lệch</th>
        </tr>
        </thead>
        <tbody>
        @foreach (\App\Helpers::ARRAY_OPTIONS as $option)
            <tr>
                <td><b>{{ $explain['all']->where('option', $option)->first()->ten_van_hoa }}</b></td>
                <td>{{ round($explain['details'][3]['result'][2][$option] - $explain['details'][3]['result'][1][$option], 2) }}</td>
                <td>{{ round($explain['details'][7]['result'][2][$option] - $explain['details'][7]['result'][1][$option], 2) }}</td>
                <td>{{ \App\Helpers::getXValue($explain, 2, $option) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div>
    Cách quản lý nhân viên hiện tại {{ \App\Helpers::getMatchName($explain['extends'][1]['percentMatch']) }}({{$explain['extends'][1]['percentMatch']}}%)

    @if (count($explain['extends'][1]['bigThan']) == 0) do cả 4 giá trị cột chênh lệch đều nhỏ hơn 5. @endif

    @if (count($explain['extends'][1]['bigThan']) == 3) do có 3 giá trị của cột chênh lệch lớn hơn hoặc = 5, tương ứng với
    @foreach ($explain['extends'][1]['bigThan'] as $option)
        {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ \App\Helpers::getXValue($explain, 2, $option) }} điểm),
    @endforeach
    @endif

    @if (count($explain['extends'][1]['bigThan']) == 2) do có 2 giá trị của cột chênh lệch lớn hơn hoặc = 5, tương ứng với
    @foreach ($explain['extends'][1]['bigThan'] as $option)
        {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ \App\Helpers::getXValue($explain, 2, $option) }} điểm),
    @endforeach
    @endif

    @if (count($explain['extends'][1]['bigThan']) == 1) do có 1 giá trị của cột chênh lệch lớn hơn hoặc = 5, tương ứng với
    @foreach ($explain['extends'][1]['bigThan'] as $option)
        {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ \App\Helpers::getXValue($explain, 2, $option) }} điểm),
    @endforeach
    @endif

    @if (count($explain['extends'][1]['bigThan']) == 4) do cả 4 giá trị của cột chênh lệch đều lớn hơn hoặc = 5. @endif

</div>