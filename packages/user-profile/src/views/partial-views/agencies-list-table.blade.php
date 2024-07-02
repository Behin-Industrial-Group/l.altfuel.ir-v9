<table class="table table-stripped">
    <thead>
        <tr>
            <th>نام</th>
            <th>کد مرکز</th>
            <th>شماره صنف</th>
            <th>دسته بندی</th>
            <th>رسته</th>
            <th>آدرس</th>
            <th>لوکیشن</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($agencies as $agency)
            <tr>
                <td>{{ $agency['firstname'] }}</td>
                <td>{{ $agency['province'] }}</td>
                <td>{{ $agency['city'] }}</td>
                <td>{{ $agency['catagory'] }}</td>
                <td>{{ $agency['guild_catagory'] }}</td>
                <td>{{ $agency['address'] }}</td>
                <td><button class="btn btn-primary" onclick="open_edit_form({{$agency['parent_id']}})">{{__('Compelete Info')}}</button></td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    function open_edit_form(parent_id){
        url = '{{ route("myAgency.form", ["parent_id" => "parent_id"]) }}'
        url = url.replace('parent_id', parent_id)
        send_ajax_get_request(url,
            function(response){
                open_admin_modal_with_data(response)
            }
        )
    }
</script>
