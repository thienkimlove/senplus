<table>
    <thead>
    <tr>
        @foreach (\App\Helpers::mapCustomer() as $index => $customer)
            <th>{{ $customer['value'] }}</th>
        @endforeach
        @foreach ($company->filters as $filter)
            <th>Thuộc Tính {{ $filter->name }}</th>
        @endforeach

    </tr>
    </thead>
    <tbody>
        <tr>
            @foreach (\App\Helpers::mapCustomer() as $index => $customer)
                <th></th>
            @endforeach
            @foreach ($company->filters as $filter)
                <td></td>
            @endforeach
        </tr>
    </tbody>
</table>