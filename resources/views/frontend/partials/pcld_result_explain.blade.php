<div>
    <h4>PHONG CÁCH LÃNH ĐẠO</h4>
</div>

<div>
    Số liệu này thể hiện nhận thức của nhóm về cách ứng xử của người đứng đầu hoặc các lãnh đạo tại {{ $explain['company_name'] }}.
</div>

<div>
    <span class="red-text"><b>Loại hình {{ $explain['details'][2]['explainMax']->ten_van_hoa }}</b> được chấm điểm cao nhất ({{ $explain['details'][2]['maxValue'] }} điểm)</span>. Như vậy họ cho rằng:
</div>

<div>
    Phong cách của lãnh đạo {{ $explain['company_name'] }} là <b>{{ $explain['details'][2]['explainMax']->phong_cach_lanh_dao }}</b>
</div>

<div>
    <h4>KHOẢNG CÁCH GIỮA HIỆN TẠI VÀ MONG MUỐN</h4>
</div>

<div>
    Mức độ chênh lệch điểm số giữa hiện tại và mong muốn thể hiện nhu cầu thay đổi của nhóm đối tượng khảo sát.
</div>

@if ($explain['details'][2]['moreThan'])
    <div>
        Có {{ count($explain['details'][2]['moreThan']) }} khoảng chênh lệch lớn hơn hoặc bằng 10, thể hiện nhu cầu thay đổi mạnh mẽ của họ đó là:
    </div>
    <div>
        <ul>
            @foreach ($explain['details'][2]['moreThan'] as $option)
                @php
                    $tempValue = round($explain['details'][2]['result'][2][$option] - $explain['details'][2]['result'][1][$option], 2);
                @endphp

                <li><span class="red-text">{{ ($tempValue > 0) ? 'Gia tăng' : 'Giảm bớt' }} tỉ trọng của {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ $tempValue }} điểm)</span></li>
            @endforeach
        </ul>
    </div>

@endif

@if ($explain['details'][2]['lessThan'])
    <div>
        Có {{ count($explain['details'][2]['lessThan']) }} khoảng chênh lệch nhỏ hơn 10 và lớn hơn hoặc bằng 5, thể hiện nhu cầu thay đổi cần lưu ý của họ đó là:
    </div>
    <div>
        <ul>
            @foreach ($explain['details'][2]['lessThan'] as $option)
                @php
                    $tempValue = round($explain['details'][2]['result'][2][$option] - $explain['details'][2]['result'][1][$option], 2);
                @endphp

                <li><span class="red-text">{{ ($tempValue > 0) ? 'Gia tăng' : 'Giảm bớt' }} tỉ trọng của {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ $tempValue }} điểm)</span></li>
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
            <th>Phong cách lãnh đạo</th>
            <th>Chênh lệch</th>
        </tr>
        </thead>
        <tbody>
        @foreach (\App\Helpers::ARRAY_OPTIONS as $option)
            <tr>
                <td><b>{{ $explain['all']->where('option', $option)->first()->ten_van_hoa }}</b></td>
                <td>{{ round($explain['details'][7]['result'][2][$option] - $explain['details'][7]['result'][1][$option], 2) }}</td>
                <td>{{ round($explain['details'][2]['result'][2][$option] - $explain['details'][2]['result'][1][$option], 2) }}</td>
                <td>{{ \App\Helpers::getXValue($explain, 2, $option) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div>
    Theo đánh giá của nhóm thì <span class="red-text">phong cách lãnh đạo trong thời gian qua là {{ \App\Helpers::getMatchName($explain['extends'][2]['percentMatch']) }} ({{$explain['extends'][2]['percentMatch']}}%)</span>

    @if (count($explain['extends'][2]['bigThan']) == 0) do cả 4 giá trị cột chênh lệch đều < 5. @endif

    @if (count($explain['extends'][2]['bigThan']) == 3) do có 3 giá trị của cột chênh lệch >= 5, tương ứng với
    @foreach ($explain['extends'][2]['bigThan'] as $option)
        {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ \App\Helpers::getXValue($explain, 2, $option) }} điểm).
    @endforeach
    @endif

    @if (count($explain['extends'][2]['bigThan']) == 2) do có 2 giá trị của cột chênh lệch >= 5, tương ứng với
    @foreach ($explain['extends'][2]['bigThan'] as $option)
        {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ \App\Helpers::getXValue($explain, 2, $option) }} điểm).
    @endforeach
    @endif

    @if (count($explain['extends'][2]['bigThan']) == 1) do có 1 giá trị của cột chênh lệch >= 5, tương ứng với
    @foreach ($explain['extends'][2]['bigThan'] as $option)
        {{ $explain['all']->where('option', $option)->first()->ten_van_hoa }} ({{ \App\Helpers::getXValue($explain, 2, $option) }} điểm).
    @endforeach
    @endif

    @if (count($explain['extends'][2]['bigThan']) == 4) do cả 4 giá trị của cột chênh lệch đều >= 5. @endif

</div>