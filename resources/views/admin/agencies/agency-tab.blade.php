
<form action="javascript:void(0)" id="agency-info-form">
    <input type="hidden" class="form-control" id="" name="id" value="{{ $agency->id }}">
    <input type="hidden" class="form-control" id="" name="agency_table" value="{{ $agency_table }}">
    <table class="table table-bordered table-striped">
        <tr>
            <td>فعال</td>
            <td><input type="checkbox" name="enable" {{ ($agency->enable) ? 'checked' : '' }}> </td>
        </tr>
        <tr>
            <td>سال دریافت کد</td>
            <td><input type="text" class="form-control" id="" name="ReceivingCodeYear" value="{{ $agency->ReceivingCodeYear }}"></td>
        </tr>
        <tr>
            <td>کدملی</td>
            <td><input type="text" class="form-control" id="" name="NationalID"  value="{{ $agency->NationalID }}"></td>
        </tr>
        <tr>
            <td>نام</td>
            <td><input type="text" class="form-control" id="" name="Name" value="{{ $agency->Name }}"></td>
        </tr>
        <tr>
            <td>استان</td>
            <td><input type="text" class="form-control" id="Province" name="Province" value="{{ $agency->Province }}"></td>
        </tr>
        <tr>
            <td>شهرستان</td>
            <td><input type="text" class="form-control" id="" name="City" value="{{ $agency->City }}"></td>
        </tr>
        <tr>
            <td>کدمرکز</td>
            <td>
                <input type="text" class="form-control col-sm-9" id="CodeEtehadie" name="CodeEtehadie" value="{{ $agency->CodeEtehadie }}">
                <span id="gen_code" class="col-sm-3"  style="background: #db4f4f;padding-top:5px; height:32px; text-align:center; font-weight:bold; cursor:pointer">
                    تولید کد
                </span>
            </td>
        </tr>
        <tr>
            <td>شماره صنفی</td>
            <td><input type="text" class="form-control" id="" name="GuildNumber" value="{{ $agency->GuildNumber }}"></td>
        </tr>
        <tr>
            <td>تاریخ صدور</td>
            <td><input type="text" class="form-control" id="" name="IssueDate" value="{{ $agency->IssueDate }}"></td>
        </tr>
        <tr>
            <td>تاریخ انقضا</td>
            <td><input type="text" class="form-control" id="" name="ExpDate" value="{{ $agency->ExpDate }}"></td>
        </tr>
        <tr>
            <td>کدپستی</td>
            <td><input type="text" class="form-control" id="" name="PostalCode" value="{{ $agency->PostalCode }}"></td>
        </tr>
        <tr>
            <td>شماره همراه</td>
            <td><input type="text" class="form-control" id="" name="Cellphone" value="{{ $agency->Cellphone }}"></td>
        </tr>
        <tr>
            <td>تلفن ثابت</td>
            <td><input type="text" class="form-control" id="" name="Tel" value="{{ $agency->Tel }}"></td>
        </tr>
        <tr>
            <td>آدرس</td>
            <td><textarea type="text" class="form-control" id="" name="Address">{{ $agency->Address }}</textarea></td>
        </tr>
        <tr>
            <td>موقعیت مکانی</td>
            <td><input type="text" class="form-control" id="" name="Location" value="{{ $agency->Location }}"></td>
        </tr>
        <tr>
            <td>توضیحات</td>
            <td><textarea type="text" class="form-control" id="" name="Details">{{ $agency->Details }}</textarea></td>
        </tr>
        @isset($agency->InsUserDelivered)
            <tr>
                <td>یوزر بازرسی تحویل داده شد</td>
                <td><input type="checkbox" class="" id="" name="InsUserDelivered" {{ ($agency->InsUserDelivered == 'ok') ? 'checked' : '' }}></td>
            </tr>
        @endisset
        
    </table>
</form>
<button type="button" class="btn btn-primary" id="submit-markaz-form" onclick="save_agency_info()">ذخیره</button>

<script>
    $('#gen_code').on('click', function(){
        var province = $('#Province').val();
        $.get( "{{url('GenCode/markaz')}}/"+ province, function( data ) {
            alert('کد جدید:  ' + data)
        });
    })
</script>

<script>

    function save_agency_info(){
        send_ajax_request(
            "{{ route('agency.edit') }}",
            $('#agency-info-form').serialize(),
            function(data){
                toastr.success("اطلاعات مرکز ویرایش شد")
                // refresh_table()
                // open_admin_modal("{{ route('admin.markaz.edit-form', [ 'id' => $agency->id ]) }}")
            },
            function(data){
                console.log(data);
                show_error(data);
                // open_admin_modal("{{ route('admin.markaz.edit-form', [ 'id' => $agency->id ]) }}")
            }
        )
    }
</script>