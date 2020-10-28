<div>
    <h4>SỰ GẮN KẾT</h4>
</div>

<div>
    Số liệu này thể hiện nhận thức của nhóm về điều gì giữ cho các thành viên {{ $explain['company_name'] }} luôn là một tập thể gắn kết. 
</div>

<div>
    <b>{{ $explain['details'][4]['explainMax']->ten_van_hoa }}</b> được chấm điểm cao nhất ({{ $explain['details'][4]['maxValue'] }} điểm). Như vậy họ cho rằng:
</div>

<div>
    Điều giữ cho các thành viên {{ $explain['company_name'] }} luôn gắn kết là <b>{{ $explain['details'][4]['explainMax']->su_gan_ket }}</b>
</div>

<div>
    <h4>SỰ KHÁC NHAU GIỮA HIỆN TẠI VÀ MONG MUỐN</h4>
</div>

<div>
    Chênh lệch điểm số giữa hiện tại và mong muốn thể hiện nhu cầu thay đổi của nhóm đối tượng khảo sát.
</div>

@if ($explain['details'][4]['moreThan'])
    <div>
        Có {{ count($explain['details'][4]['moreThan']) }} sự chênh lệch lớn hơn hoặc bằng 10, thể hiện nhu cầu thay đổi mạnh mẽ của họ đó là:
    </div>
    <div>
        <ul>
            @foreach ($explain['details'][4]['moreThan'] as $option)
                @php
                    $tempValue = round($explain['details'][4]['result'][2][$option] - $explain['details'][4]['result'][1][$option], 2);
                @endphp

                <li>{{ ($tempValue > 0) ? 'Gia tăng' : 'Giảm bớt' }} tỉ trọng của {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ $tempValue }} điểm) tương ứng với việc {{ $explain['all']->where('option', $option)->first()->phong_cach_lanh_dao }}</li>
            @endforeach
        </ul>
    </div>

@endif

@if ($explain['details'][4]['lessThan'])
    <div>
        Có {{ count($explain['details'][4]['lessThan']) }} sự chênh lệch nhỏ hơn 10 và lớn hơn hoặc bằng 5, thể hiện nhu cầu thay đổi cần lưu ý của họ đó là:
    </div>
    <div>
        <ul>
            @foreach ($explain['details'][4]['lessThan'] as $option)
                @php
                    $tempValue = round($explain['details'][4]['result'][2][$option] - $explain['details'][4]['result'][1][$option], 2);
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
            <th>Nhu cầu thay đổi về sự gắn kết</th>
            <th>Chênh lệch</th>
        </tr>
        </thead>
        <tbody>
        @foreach (\App\Helpers::ARRAY_OPTIONS as $option)
            <tr>
                <td><b>{{ $explain['all']->where('option', $option)->first()->ten_van_hoa }}</b></td>

                <td>{{ round($explain['details'][7]['result'][2][$option] - $explain['details'][7]['result'][1][$option], 2) }}</td>

                <td>{{ round($explain['details'][4]['result'][2][$option] - $explain['details'][4]['result'][1][$option], 2) }}</td>
                <td>{{ \App\Helpers::getXValue($explain, 4, $option) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div>
    Sự gắn kết hiện tại {{ \App\Helpers::getMatchName($explain['extends'][4]['percentMatch']) }}({{$explain['extends'][4]['percentMatch']}}%)

    @if (count($explain['extends'][4]['bigThan']) == 0) do cả 4 giá trị cột chênh lệch đều nhỏ hơn 5. @endif

    @if (count($explain['extends'][4]['bigThan']) == 3) do có 3 giá trị của cột chênh lệch lớn hơn hoặc = 5, tương ứng với
    @foreach ($explain['extends'][4]['bigThan'] as $option)
        {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ \App\Helpers::getXValue($explain, 4, $option) }} điểm),
    @endforeach
    @endif

    @if (count($explain['extends'][4]['bigThan']) == 2) do có 2 giá trị của cột chênh lệch lớn hơn hoặc = 5, tương ứng với
    @foreach ($explain['extends'][4]['bigThan'] as $option)
        {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ \App\Helpers::getXValue($explain, 4, $option) }} điểm),
    @endforeach
    @endif

    @if (count($explain['extends'][4]['bigThan']) == 1) do có 1 giá trị của cột chênh lệch lớn hơn hoặc = 5, tương ứng với
    @foreach ($explain['extends'][4]['bigThan'] as $option)
        {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ \App\Helpers::getXValue($explain, 4, $option) }} điểm),
    @endforeach
    @endif

    @if (count($explain['extends'][4]['bigThan']) == 4) do cả 4 giá trị của cột chênh lệch đều lớn hơn hoặc = 5. @endif

</div>