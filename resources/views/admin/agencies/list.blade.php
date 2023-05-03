@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="box">
            <form action="javascript:void(0)" id="agency-table-form">
                <select name="agency_name" id="agency_name">
                    @foreach (config('app.agencies') as $agency)
                        <option value="{{ $agency['name'] }}">{{ $agency['fa_name'] }}</option>
                    @endforeach
                </select>
                <button class="btn btn-info" onclick="filter()">نمایش</button>
            </form>
        </div>
        <div class="box table-responsive">
            <table class="table table-striped" id="agency-table">
                <thead>
                  <tr>
                    <th>ردیف</th>
                    <th>نام</th>
                    <th>کد اتحادیه</th>
                    <th>شناسه صنفی</th>
                    <th>استان</th>
                    <th>شهرستان</th>
                    <th>کدملی</th>
                    <th>موبایل</th>
                    <th>تاریخ صدور</th>
                    <th>تاریخ انقضا</th>
                  </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
<script>
    var table = create_datatable(
        'agency-table',
        "{{ route('agency.list') }}",
        [
            { data: 'id'},
            { data: 'Name'},
            { data: 'CodeEtehadie'},
            { data: 'GuildNumber'},
            { data: 'Province'},
            { data: 'City'},
            { data: 'NationalID'},
            { data: 'Cellphone'},
            { data: 'IssueDate'},
            { data: 'ExpDate'},
        ], 
        function(row, data) {
            // تغییر رنگ پس‌زمینه ردیف بر اساس مقدار فیلد enable
            if (data.FinGreen == 'ok') {
                $(row).css('background-color', 'green');
            }
        }

    )

    function open(){
        alert()
        // var fd = {
        //     'agency_table' : $agency_name,
        //     'agency_id': $id
        // }
        // send_ajax_formdata_request(
        //     "{{ route('agency.edit-form') }}",
        //     fd,
        //     function(body){
        //         console.log(body);
        //         // open_admin_modal_with_data(body);
        //     }
        // )
    }

    table.on('click', 'tr', function(){
        var data = table.row( this ).data();
        var fd = new FormData();
        fd.append('agency_name', $('#agency_name').val());
        fd.append('agency_id', data.id);
        console.log(fd);
        send_ajax_formdata_request(
            "{{ route('agency.edit-form') }}",
            fd,
            function(body){
                open_admin_modal_with_data(body, "اطلاعات مرکز " + data.Name);
            },
            function(data){
                show_error(data);
                console.log(data);
            }
        )
    })

    function filter(){
        send_ajax_request(
            "{{ route('agency.list') }}",
            $('#agency-table-form').serialize(),
            function(data){
                update_datatable(data);
            },
            function(data){
                show_error(data);
                console.log(data);
            }
        )
    }
</script>
@endsection