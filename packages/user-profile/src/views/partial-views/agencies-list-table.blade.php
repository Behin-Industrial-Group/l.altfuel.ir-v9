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
            <th>نظر سنجی</th>
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

                <td><a href="{{ route('user-profile.getLocation', ['parent_id' => $agency['parent_id']]) }}">ویرایش لوکیشن</a></td>
                <td>
                    @if (isset($agency['participation']) and $agency['participation'] == 1)
                    شما قبلا در طرح شرکت کرده اید
                    @else
                    <form action="javascript:void(0)">
                        <button class="btn btn-primary btn-sm" onclick="create_ticket()">شرکت در طرح رتبه بندی</button>
                    </form>
                    @endif

                <td><button class="btn btn-primary" onclick="open_edit_form({{$agency['parent_id']}})">{{__('Compelete Info')}}</button></td>

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
            data.append('parent_id', '{{ $agency["parent_id"] }}')
            send_ajax_formdata_request(
                "{{ route('user-profile.participation') }}",
                data,
                function(response) {
                    console.log(response);
                    show_message("{{ trans('participation successfull') }}");
                    getAgencies()
                }
            )
        }

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
