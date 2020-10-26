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
    Cách quản lý nhân viên tại {{ $explain['company_name'] }} là <b>{{ $explain['details'][3]['explainMax']->quan_ly_nhan_vien }}</b>
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
    <table border="1">
        <thead>
        <tr>
            <th>SỰ PHÙ HỢP</th>
            <th>Nhu cầu thay đổi tổng quan</th>
            <th>Nhu cầu thay đổi về quản lý nhân viên</th>
            <th>Chênh lệch</th>
        </tr>
        </thead>
        <tbody>
        @foreach (\App\Helpers::ARRAY_OPTIONS as $option)
            <tr>
                <td><b>{{ $explain['all']->where('option', $option)->first()->ten_van_hoa }}</b></td>

                <td>{{ round($explain['details'][7]['result'][2][$option] - $explain['details'][7]['result'][1][$option], 2) }}</td>

                <td>{{ round($explain['details'][3]['result'][2][$option] - $explain['details'][3]['result'][1][$option], 2) }}</td>
                <td>{{ \App\Helpers::getXValue($explain, 3, $option) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div>
    Cách quản lý nhân viên hiện tại {{ \App\Helpers::getMatchName($explain['extends'][3]['percentMatch']) }}({{$explain['extends'][3]['percentMatch']}}%)

    @if (count($explain['extends'][3]['bigThan']) == 0) do cả 4 giá trị cột chênh lệch đều nhỏ hơn 5. @endif

    @if (count($explain['extends'][3]['bigThan']) == 3) do có 3 giá trị của cột chênh lệch lớn hơn hoặc = 5, tương ứng với
    @foreach ($explain['extends'][3]['bigThan'] as $option)
        {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ \App\Helpers::getXValue($explain, 3, $option) }} điểm),
    @endforeach
    @endif

    @if (count($explain['extends'][3]['bigThan']) == 2) do có 2 giá trị của cột chênh lệch lớn hơn hoặc = 5, tương ứng với
    @foreach ($explain['extends'][3]['bigThan'] as $option)
        {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ \App\Helpers::getXValue($explain, 3, $option) }} điểm),
    @endforeach
    @endif

    @if (count($explain['extends'][3]['bigThan']) == 1) do có 1 giá trị của cột chênh lệch lớn hơn hoặc = 5, tương ứng với
    @foreach ($explain['extends'][3]['bigThan'] as $option)
        {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ \App\Helpers::getXValue($explain, 3, $option) }} điểm),
    @endforeach
    @endif

    @if (count($explain['extends'][3]['bigThan']) == 4) do cả 4 giá trị của cột chênh lệch đều lớn hơn hoặc = 5. @endif

</div>