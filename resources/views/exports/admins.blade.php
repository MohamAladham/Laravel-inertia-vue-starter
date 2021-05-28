<table>
    <thead>
    <tr>
        <th>الاسم</th>
        <th>البريد الإلكتروني</th>
        <th>تاريخ الإضافة</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->created_at->format('Y-m-d h:i A') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
