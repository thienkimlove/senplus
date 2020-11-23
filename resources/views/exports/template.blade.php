<table>
    <thead>
    <tr>
        @foreach (\App\Helpers::mapTemplateQuestion() as $values)
            <th>{{ $values['value'] }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    <tr>
        @foreach (\App\Helpers::mapTemplateQuestion() as $values)
            <td>&nbsp;</td>
        @endforeach
    </tr>
    </tbody>

</table>