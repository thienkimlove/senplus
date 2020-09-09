<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Password</th>
        @foreach ($company->filters as $filter)
            <th>Thuộc Tính {{ $filter->name }}</th>
        @endforeach

    </tr>
    </thead>
    <tbody>
        <tr>
            <td>Đặng Văn A</td>
            <td>senplus@example.com</td>
            <td>123456</td>
            @foreach ($company->filters as $filter)
                <td>Giá trị thuộc tính {{ $filter->name }}</td>
            @endforeach
        </tr>
    </tbody>
</table>