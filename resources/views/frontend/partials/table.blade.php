@foreach(['option1', 'option2', 'option3', 'option4'] as $index => $opt)
    <tr>
        <td>{{ \App\Helpers::mapOption()[$opt] }}</td>
        <td>{{ round($result[1][$opt], 2) }}</td>
        <td>{{ round($result[2][$opt], 2) }}</td>
        <td>{{ round($result[2][$opt] - $result[1][$opt], 2) }}</td>
    </tr>
@endforeach