@foreach(\App\Helpers::ARRAY_OPTIONS as $index => $opt)
    <tr>
        <td>{{ \App\Helpers::mapOption()[$opt] }}</td>
        <td>{{ round($result[1][$opt], 2) }}</td>
        <td>{{ round($result[2][$opt], 2) }}</td>
        <td>{{ round($result[2][$opt] - $result[1][$opt], 2) }}</td>
    </tr>
@endforeach