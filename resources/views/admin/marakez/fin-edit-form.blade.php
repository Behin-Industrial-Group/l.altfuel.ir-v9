<?php 
use App\CustomClasses\Access;
?>

 
 {{-- <form class="form-horizontal" method="POST" action="javascript:void(0)" id="fin-form">
     @csrf
     <input type="hidden" class="form-control" id="" name="id">
     <input type="hidden" class="form-control" id="" name="FormType" value="FinForm">
         <table class="table table-striped table-bordered">
             <tr>
                 <th>عنوان</th>
                 <th>مبلغ</th>
                 <th>تاریخ واریز</th>
                 <th>کدپیگیری</th>
             </tr>
             <tr>
                 <td>96</td>
                 <td>
                     <input type="text" class="form-control price" id="" name="MembershipFee96">
                     <p class="cama-seprator" style="font-size:10px"></p>
                 </td>
                 <td>
                     <input type="text" class="form-control price" id="" name="MembershipFee96_PayDate">
                 </td>
                 <td>
                     <input type="text" class="form-control price" id="" name="MembershipFee96_Refid">
                 </td>
             </tr>
             <tr>
                 <td><label for="" class="col-sm-3 control-label">97</label></td>
                 <td>
                     <input type="text" class="form-control price" id="" name="MembershipFee97">
                     <p class="cama-seprator" style="font-size:10px"></p>
                 </td>
                 <td>
                     <input type="text" class="form-control price" id="" name="MembershipFee97_PayDate">
                 </td>
                 <td>
                     <input type="text" class="form-control price" id="" name="MembershipFee97_Refid">
                 </td>
             </tr>
             <tr>
                 <td><label for="" class="col-sm-3 control-label">98</label></td>
                 <td>
                     <input type="text" class="form-control price" id="" name="MembershipFee98">
                     <p class="cama-seprator" style="font-size:10px"></p>
                 </td>
                 <td>
                     <input type="text" class="form-control price" id="" name="MembershipFee98_PayDate">
                 </td>
                 <td>
                     <input type="text" class="form-control price" id="" name="MembershipFee98_Refid">
                 </td>
             </tr>
             <tr>
                 <td><label for="" class="col-sm-3 control-label">99</label></td>
                 <td>
                     <input type="text" class="form-control price" id="" name="MembershipFee99">
                     <p class="cama-seprator" style="font-size:10px"></p>
                 </td>
                 <td>
                     <input type="text" class="form-control price" id="" name="MembershipFee99_PayDate">
                 </td>
                 <td>
                     <input type="text" class="form-control price" id="" name="MembershipFee99_Refid">
                 </td>
             </tr>
             <tr>
                 <td><label for="" class="col-sm-3 control-label">00</label></td>
                 <td>
                     <input type="text" class="form-control price" id="" name="Membership00">
                     <p class="cama-seprator" style="font-size:10px"></p>
                 </td>
                 <td>
                     <input type="text" class="form-control price" id="" name="Membership00_PayDate">
                 </td>
                 <td>
                     <input type="text" class="form-control price" id="" name="Membership00_Refid">
                 </td>
             </tr>
             <tr>
                <td><label for="" class="col-sm-3 control-label">01</label></td>
                <td>
                    <input type="text" class="form-control price" id="" name="Membership01">
                    <p class="cama-seprator" style="font-size:10px"></p>
                </td>
                <td>
                    <input type="text" class="form-control price" id="" name="Membership01_PayDate">
                </td>
                <td>
                    <input type="text" class="form-control price" id="" name="Membership01_Refid">
                </td>
            </tr>
             <tr>
                 <td><label for="" class="control-label" style="color: red">مبلغ بدهی</label></td>
                 <td colspan="3">
                     <input type="text" class="form-control price" id="" name="debt">
                     <p class="cama-seprator" style="font-size:10px"></p>
                 </td>
             </tr>
             <tr>
                 <td><label for="" class="control-label" style="color: red">شرح بدهی</label></td>
                 <td colspan="3">
                     <input type="text" class="form-control" id="" name="debt_description">
                     <p class="cama-seprator" style="font-size:10px"></p>
                 </td>
             </tr>
             <tr>
                 <td><label for="" class="control-label" style="color: red">کدرهگیری پرداخت بدهی</label></td>
                 <td colspan="3">
                     <input type="text" class="form-control" id="" name="" disabled>
                     <p class="cama-seprator" style="font-size:10px"></p>
                 </td>
             </tr>
             <tr>
                 <td><label for="" class="control-label">پشتیبانی سامانه</label></td>
                 <td>
                     <input type="text" class="form-control price" id="" name="IrngvFee">
                     <p class="cama-seprator" style="font-size:10px"></p>
                 </td>
                 <td>
                     <input type="text" class="form-control price" id="" name="IrngvFee_PayDate">
                 </td>
                 <td>
                     <input type="text" class="form-control price" id="" name="IrngvFee_Refid">
                 </td>
             </tr>
             <tr>
                 <td><label for="" class="control-label">قفل</label></td>
                 <td>
                     <input type="text" class="form-control price" id="" name="LockFee">
                     <p class="cama-seprator" style="font-size:10px"></p>
                 </td>
                 <td>
                     <input type="text" class="form-control price" id="" name="LockFee_PayDate">
                 </td>
                 <td>
                     <input type="text" class="form-control price" id="" name="LockFee_Refid">
                 </td>
             </tr>
             <tr>
                 <td><label for="" class="control-label">توضیحات مالی</label></td>
                 <td colspan="3">
                     <input type="text" class="form-control" id="" name="FinDetails">
                     <p class="cama-seprator" style="font-size:10px"></p>
                 </td>
             </tr>
             <tr>
                 <td><label for="" class="control-label">سبز</label></td>
                 <td>
                     <input type="checkbox" class="" id="" name="FinGreen">
                     <p class="cama-seprator" style="font-size:10px"></p>
                 </td>
                 <td></td>
                 <td></td>
             </tr>
         </table>
 </form> --}}
 <button type="button" class="btn btn-primary" id="submit-fin-form">ذخیره</button>

 <script>
    $('#submit-fin-form').click(function(){
        var id = $('input[name=id]').val();
        $.ajax({
            url: `{{url("admin/marakez/edit-fin-info")}}/${id}`,
            data: $('#fin-form').serialize(),
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
@endif

