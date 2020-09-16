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
                <th>N/A</th>
            @endforeach
            @foreach ($company->filters as $filter)
                <td>Giá trị thuộc tính {{ $filter->name }}</td>
            @endforeach
        </tr>
    </tbody>
</table>