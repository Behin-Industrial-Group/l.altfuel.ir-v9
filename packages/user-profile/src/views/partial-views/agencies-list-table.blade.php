<table class="table table-stripped">
    <thead>
        <tr>
            <th>نام</th>
            <th>کد مرکز</th>
            <th>شماره صنف</th>
            <th>تاریخ انقضا</th>
            <th>آدرس</th>
            <th>لوکیشن</th>
            <th>نظر سنجی</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($agencies as $agency)
            <tr>
                <td>{{ $agency['firstname'] }}</td>
                <td>{{ $agency['agency_code'] }}</td>
                <td>{{ $agency['guild_number'] }}</td>
                <td>{{ $agency['exp_date'] }}</td>
                <td>{{ $agency['address'] }}</td>
                <td><a href="{{ route('user-profile.getLocation', ['parent_id' => $agency['parent_id']]) }}">ویرایش
                        لوکیشن</a></td>
                <td>
                    <form action="javascript:void(0)">
                        <button class="btn btn-primary btn-sm" onclick="create_ticket()">شرکت در طرح رتبه بندی</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
        function create_ticket() {
            var data = new FormData();
            data.append('catagory', 6)
            data.append('title', 'تمایل به شرکت')
            data.append('text', '{{ $agency["province"] . $agency["agency_code"] }}')
            send_ajax_formdata_request(
                "{{ route('ATRoutes.store') }}",
                data,
                function(response) {
                    console.log(response);
                    show_message("{{ trans('attendence success') }}")
                }
            )
        }
</script>
