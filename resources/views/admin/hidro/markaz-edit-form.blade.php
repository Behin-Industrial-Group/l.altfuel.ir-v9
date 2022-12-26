<?php 
use App\CustomClasses\Access;
?>

<script>
    var markaz_id = $('input[name=markaz_id]').val();
    console.log(info);
    
</script>

<form action="javascript:void(0)" id="markaz-info-form">
    <input type="hidden" class="form-control" id="" name="id">
    <table class="table table-bordered table-striped">
        {{-- <tr>
            <td>فعال</td>
            <td><input type="checkbox" name="enable"> </td>
        </tr> --}}
        <tr>
            <td>سال دریافت کد</td>
            <td><input type="text" class="form-control" id="" name="ReceivingCodeYear"></td>
        </tr>
        <tr>
            <td>کدملی</td>
            <td><input type="text" class="form-control" id="" name="NationalID"></td>
        </tr>
        <tr>
            <td>نام</td>
            <td><input type="text" class="form-control" id="" name="Name"></td>
        </tr>
        <tr>
            <td>استان</td>
            <td><input type="text" class="form-control" id="Province" name="Province"></td>
        </tr>
        <tr>
            <td>شهرستان</td>
            <td><input type="text" class="form-control" id="" name="City" ></td>
        </tr>
        {{-- <tr>
            <td>کدمرکز</td>
            <td>
                <input type="text" class="form-control col-sm-9" id="CodeEtehadie" name="CodeEtehadie">
                <span id="gen_code" class="col-sm-3"  style="background: #db4f4f;padding-top:5px; height:32px; text-align:center; font-weight:bold; cursor:pointer">
                    تولید کد
                </span>
            </td>
        </tr> --}}
        <tr>
            <td>شماره صنفی</td>
            <td><input type="text" class="form-control" id="" name="GuildNumber"></td>
        </tr>
        <tr>
            <td>تاریخ صدور</td>
            <td><input type="text" class="form-control" id="" name="IssueDate" ></td>
        </tr>
        <tr>
            <td>تاریخ انقضا</td>
            <td><input type="text" class="form-control" id="" name="ExpDate" ></td>
        </tr>
        <tr>
            <td>کدپستی</td>
            <td><input type="text" class="form-control" id="" name="PostalCode" ></td>
        </tr>
        <tr>
            <td>شماره همراه</td>
            <td><input type="text" class="form-control" id="" name="Cellphone" ></td>
        </tr>
        <tr>
            <td>تلفن ثابت</td>
            <td><input type="text" class="form-control" id="" name="Tel" ></td>
        </tr>
        <tr>
            <td>آدرس</td>
            <td><input type="text" class="form-control" id="" name="Address" ></td>
        </tr>
        <tr>
            <td>موقعیت مکانی</td>
            <td><input type="text" class="form-control" id="" name="Location" ></td>
        </tr>
        <tr>
            <td>توضیحات</td>
            <td><input type="text" class="form-control" id="" name="Details" ></td>
        </tr>
        {{-- <tr>
            <td>یوزر بازرسی تحویل داده شد</td>
            <td><input type="checkbox" class="" id="" name="InsUserDelivered" ></td>
        </tr> --}}
    </table>
</form>
<button type="button" class="btn btn-primary" id="submit-markaz-form">ذخیره</button>

<script>
    $('#gen_code').on('click', function(){
        var province = $('#Province').val();
        $.get( "{{url('GenCode/markaz')}}/"+ province, function( data ) {
            alert('کد جدید:  ' + data)
        });
    })
</script>

<script>
    $('#submit-markaz-form').click(function(){
        var id = $('input[name=id]').val();
        $.ajax({
            url: `{{url("admin/hidro/edit-markaz-info")}}/${id}`,
            data: $('#markaz-info-form').serialize(),
            processData: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: 'post',
            success: function(data){
                alert(data);
                $('#modal-fin-edit').modal('hide');
            }
        })
    })
</script>