@extends('layouts.app')
@php
   use App\CustomClasses\Access;
@endphp
@section('content')
    <div class="row">
        <div class="box">
            <button class="btn btn-info" onclick="open_admin_modal('{{ route('agency.addForm') }}')">افزودن مرکز</button>
        </div>
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
        <div class="box">
            ستونها:
            <table class="table">
                <tr>
                    <td><input type="checkbox" name="name" checked onclick="columnVisible(1)">نام</td>
                    <td><input type="checkbox" name="name" checked onclick="columnVisible(2)">کداتحادیه</td>
                    <td><input type="checkbox" name="name" checked onclick="columnVisible(3)">شناسه صنفی</td>
                    <td><input type="checkbox" name="name" checked onclick="columnVisible(4)">استان</td>
                    <td><input type="checkbox" name="name" checked onclick="columnVisible(5)">شهرستان</td>
                    <td><input type="checkbox" name="name" checked onclick="columnVisible(6)">کدملی</td>
                    <td><input type="checkbox" name="name" checked onclick="columnVisible(7)">موبایل</td>
                    <td><input type="checkbox" name="name" checked onclick="columnVisible(8)">تاریخ صدور</td>
                    <td><input type="checkbox" name="name" checked onclick="columnVisible(9)">تاریخ انقضا</td>
                    
                </tr>
                @if (Access::checkView('show-fin-columns'))
                    <tr>
                        <td><input type="checkbox" name="name"  onclick="columnVisible(10)">آدرس</td>
                        <td><input type="checkbox" name="name"  onclick="columnVisible(11)">96</td>
                        <td><input type="checkbox" name="name"  onclick="columnVisible(12)">97</td>
                        <td><input type="checkbox" name="name"  onclick="columnVisible(13)">98</td>
                        <td><input type="checkbox" name="name"  onclick="columnVisible(14)">99</td>
                        <td><input type="checkbox" name="name"  onclick="columnVisible(15)">00</td>
                        <td><input type="checkbox" name="name"  onclick="columnVisible(16)">01</td>
                        <td><input type="checkbox" name="name"  onclick="columnVisible(17)" >02</td>
                        <td><input type="checkbox" name="name"  onclick="columnVisible(18)" >irngv</td>
                        <td><input type="checkbox" name="name"  onclick="columnVisible(19)" >قفل</td>
                        <td><input type="checkbox" name="name"  onclick="columnVisible(20)" >بدهی</td>
                        <td><input type="checkbox" name="name"  onclick="columnVisible(21)" >شرح بدهی</td>
                        <td><input type="checkbox" name="name"  onclick="columnVisible(22)" >کدرهگیری پرداخت بدهی</td>
                    </tr>
                @endif
            </table>
            
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
                    <th>آدرس</th>
                    <th>96</th>
                    <th>97</th>
                    <th>98</th>
                    <th>99</th>
                    <th>00</th>
                    <th>01</th>
                    <th>02</th>
                    <th>irngv</th>
                    <th>قفل</th>
                    <th>بدهی</th>
                    <th>شرح بدهی</th>
                    <th>کدرهگیری پرداخت بدهی</th>
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
            { data: 'Address', visible: false},
            { data: 'fin_info', visible: false, render: function(data){
                if(data[0] != undefined && data[0].name == "membership_96"){ return data[0].price; }else{ return "";}
            }}, 
            { data: 'fin_info', visible: false, render: function(data){
                if(data[1] != undefined && data[1].name == "membership_97"){ return data[1].price; }else{ return "";}
            }}, 
            { data: 'fin_info', visible: false, render: function(data){
                if(data[2] != undefined && data[2].name == "membership_98"){ return data[2].price; }else{ return "";}
            }}, 
            { data: 'fin_info', visible: false, render: function(data){
                if(data[3] != undefined && data[3].name == "membership_99"){ return data[3].price; }else{ return "";}
            }}, 
            { data: 'fin_info', visible: false, render: function(data){
                if(data[4] != undefined && data[4].name == "membership_00"){ return data[4].price; }else{ return "";}
            }}, 
            { data: 'fin_info', visible: false, render: function(data){
                if(data[5] != undefined && data[5].name == "membership_01"){ return data[5].price; }else{ return "";}
            }}, 
            { data: 'fin_info', visible: false, render: function(data){
                if(data[8] != undefined && data[8].name == "membership_02"){ return data[8].price; }else{ return "";}
            }},
            { data: 'fin_info', visible: false, render: function(data){
                if(data[6] != undefined && data[6].name == "irngv_fee"){ return data[6].price; }else{ return "";}
            }}, 
            { data: 'fin_info', visible: false, render: function(data){
                if(data[7] != undefined && data[7].name == "lock_fee"){ return data[7].price; }else{ return "";}
            }} ,
            { data: 'debt', visible: false},
            { data: 'debt_description', visible: false},
            { data: 'debt_RefID', visible: false},
            
        ], 
        function(row, data) {
            // تغییر رنگ پس‌زمینه ردیف بر اساس مقدار فیلد enable
            if (data.FinGreen == 'ok') {
                $(row).css('background-color', 'green');
            }
        }

    )

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

    function columnVisible(num){
        var column = table.column(num);
 
        column.visible(!column.visible());
    }

    function filter(){
        send_ajax_request(
            "{{ route('agency.list') }}",
            $('#agency-table-form').serialize(),
            function(data){
                console.log(data);
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