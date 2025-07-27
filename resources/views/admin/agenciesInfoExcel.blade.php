<!DOCTYPE html>
<html>
<head>
    <title>Agency Info Table</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>

<h2>Agency Info Table</h2>

<table id="agency-table" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Parent ID</th>
            @foreach ($columns as $col)
                <th>{{ ucfirst($col) }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($agencies as $agency)
            <tr>
                <td>{{ $agency['parent_id'] }}</td>
                @foreach ($columns as $col)
                    <td>{{ $agency[$col] ?? '-' }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#agency-table').DataTable({
            pageLength: 25,
            responsive: true,
            language: {
                search: "جستجو:",
                lengthMenu: "نمایش _MENU_ رکورد",
                info: "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
                paginate: {
                    first: "اول",
                    last: "آخر",
                    next: "بعدی",
                    previous: "قبلی"
                },
                zeroRecords: "رکوردی پیدا نشد",
            }
        });
    });
</script>

</body>
</html>
