<?php 
use App\CustomClasses\Access;
?>
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-header">
                @if (!empty($message))
                    <div class="alert alert-success">
                        {{$message}}
                    </div>
                @endif
                @if (!empty($error))
                    <div class="alert alert-danger">
                        {{$error}}
                    </div>
                @endif
            </div>
            <div class="box-body">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{Url("admin/hidro/edit/$markaz->id") }}" >
                    @csrf
                    <div class="col-sm-12">
                        فعال: <input type="checkbox" name="enable" @if($markaz->enable) {{'checked'}} @endif data-toggle="toggle" data-size="sm">                        
                    </div>
                    <div class="box-body col-md-6"  style="border:solid 1px">

                        <div class="form-group alert alert-warning">
                            <label for="" class="col-sm-2 control-label">سال دریافت کد</label>

                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" id="" name="FormType" value="SodurForm">
                                <input type="text" class="form-control" id="" name="ReceivingCodeYear" value="<?php echo $markaz->ReceivingCodeYear ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">کد ملی</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="NationalID" value="<?php echo $markaz->NationalID ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">نام</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="Name" value="<?php echo $markaz->Name ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">استان</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="Province" name="Province" value="<?php echo $markaz->Province ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">شهرستان</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="City" value="<?php echo $markaz->City ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">کدمرکز</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="CodeEtehadie" value="<?php echo $markaz->CodeEtehadie ?>">
                                <span id="gen_code" class="col-sm-3"  style="background: #db4f4f;padding-top:5px; height:32px; text-align:center; font-weight:bold; cursor:pointer">
                                    تولید کد
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">شماره صنفی</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="GuildNumber" value="<?php echo $markaz->GuildNumber ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">تاریخ صدور</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="IssueDate" value="<?php echo $markaz->IssueDate ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">تاریخ انقضا</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="ExpDate" value="<?php echo $markaz->ExpDate ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">کدپستی</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="PostalCode" value="<?php echo $markaz->PostalCode ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">شماره همراه</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="Cellphone" value="<?php echo $markaz->Cellphone ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">تلفن ثابت</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="Tel" value="<?php echo $markaz->Tel ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">آدرس</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="Address" value="<?php echo $markaz->Address ?>">
                            </div>
                        </div>
                        @if( !empty($markaz->DeliveryReceipts) )
                        <div class="from-group">
                            <label class="col-sm-2 control-lable">
                                رسید تحویل:
                            </label>
                            <p>
                                <a href="<?php echo Url( "/$markaz->DeliveryReceipts" ); ?>">نمایش</a>
                            </p>
                        </div>
                        @else

                        <div class="form-group alert alert-warning">
                            <label for="" class="col-sm-2 control-label">
                                رسید تحویل پروانه کسب
                            </label>

                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="" name="DeliveryReceipts">
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">موقعیت مکانی</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="Location" value="<?php echo $markaz->Location ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">توضیحات</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="Details" value="<?php echo $markaz->Details ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="box-footer">
                                <input type="submit" class="btn btn-info pull-right" value="ثبت">
                            </div>
                        </div>
                    </div>
                </form>
                @if(Access::checkView('show_fin_form'))
                <form class="form-horizontal" method="POST" action="{{Url("admin/hidro/edit/$markaz->id") }}">
                    @csrf
                    <input type="hidden" class="form-control" id="" name="id" value="<?php echo $markaz->id ?>">
                    <input type="hidden" class="form-control" id="" name="FormType" value="FinForm">
                    <div class="box-body col-md-6"  style="border:solid 1px">
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
                                    <input type="text" class="form-control price" id="" name="MembershipFee96" value="<?php echo $markaz->MembershipFee96 ?>">
                                    <p class="cama-seprator" style="font-size:10px"></p>
                                </td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="MembershipFee96_PayDate" value="<?php echo $markaz->MembershipFee96_PayDate ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="MembershipFee96_Refid" value="<?php echo $markaz->MembershipFee96_Refid ?>">
                                </td>
                            </tr>
                            <tr>
                                <td><label for="" class="col-sm-3 control-label">97</label></td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="MembershipFee97" value="<?php echo $markaz->MembershipFee97 ?>">
                                    <p class="cama-seprator" style="font-size:10px"></p>
                                </td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="MembershipFee97_PayDate" value="<?php echo $markaz->MembershipFee97_PayDate ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="MembershipFee97_Refid" value="<?php echo $markaz->MembershipFee97_Refid ?>">
                                </td>
                            </tr>
                            <tr>
                                <td><label for="" class="col-sm-3 control-label">98</label></td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="MembershipFee98" value="<?php echo $markaz->MembershipFee97 ?>">
                                    <p class="cama-seprator" style="font-size:10px"></p>
                                </td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="MembershipFee98_PayDate" value="<?php echo $markaz->MembershipFee98_PayDate ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="MembershipFee98_Refid" value="<?php echo $markaz->MembershipFee98_Refid ?>">
                                </td>
                            </tr>
                            <tr>
                                <td><label for="" class="col-sm-3 control-label">99</label></td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="MembershipFee99" value="<?php echo $markaz->MembershipFee99 ?>">
                                    <p class="cama-seprator" style="font-size:10px"></p>
                                </td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="MembershipFee99_PayDate" value="<?php echo $markaz->MembershipFee99_PayDate ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="MembershipFee99_Refid" value="<?php echo $markaz->MembershipFee99_Refid ?>">
                                </td>
                            </tr>
                            <tr>
                                <td><label for="" class="col-sm-3 control-label">00</label></td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="Membership00" value="<?php echo $markaz->Membership00 ?>">
                                    <p class="cama-seprator" style="font-size:10px"></p>
                                </td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="Membership00_PayDate" value="<?php echo $markaz->Membership00_PayDate ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="Membership00_Refid" value="<?php echo $markaz->Membership00_Refid ?>">
                                </td>
                            </tr>
                            <tr>
                                <td><label for="" class="col-sm-3 control-label">01</label></td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="Membership01" value="<?php echo $markaz->Membership01 ?>">
                                    <p class="cama-seprator" style="font-size:10px"></p>
                                </td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="Membership01_PayDate" value="<?php echo $markaz->Membership01_PayDate ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="Membership01_Refid" value="<?php echo $markaz->Membership01_Refid ?>">
                                </td>
                            </tr>
                            <tr>
                                <td><label for="" class="control-label" style="color: red">مبلغ بدهی</label></td>
                                <td colspan="3">
                                    <input type="text" class="form-control price" id="" name="debt" value="<?php echo $markaz->debt ?>" disabled>
                                    <p class="cama-seprator" style="font-size:10px"></p>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="" class="control-label" style="color: red">شرح بدهی</label></td>
                                <td colspan="3">
                                    <input type="text" class="form-control" id="" name="debt_description" value="<?php echo $markaz->debt_description ?>" disabled>
                                    <p class="cama-seprator" style="font-size:10px"></p>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="" class="control-label" style="color: red">کدرهگیری پرداخت بدهی</label></td>
                                <td colspan="3">
                                    <input type="text" class="form-control" id="" name="" value="<?php echo $markaz->debt_RefID ?>" disabled>
                                    <p class="cama-seprator" style="font-size:10px"></p>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="" class="control-label">پشتیبانی سامانه</label></td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="IrngvFee" value="<?php echo $markaz->IrngvFee ?>">
                                    <p class="cama-seprator" style="font-size:10px"></p>
                                </td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="IrngvFee_PayDate" value="<?php echo $markaz->IrngvFee_PayDate ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="IrngvFee_Refid" value="<?php echo $markaz->IrngvFee_Refid ?>">
                                </td>
                            </tr>
                            <tr>
                                <td><label for="" class="control-label">قفل</label></td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="LockFee" value="<?php echo $markaz->LockFee ?>">
                                    <p class="cama-seprator" style="font-size:10px"></p>
                                </td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="LockFee_PayDate" value="<?php echo $markaz->LockFee_PayDate ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control price" id="" name="LockFee_Refid" value="<?php echo $markaz->LockFee_Refid ?>">
                                </td>
                            </tr>
                            <tr>
                                <td><label for="" class="control-label">توضیحات مالی</label></td>
                                <td colspan="3">
                                    <input type="text" class="form-control" id="" name="FinDetails" value="<?php echo $markaz->FinDetails ?>">
                                    <p class="cama-seprator" style="font-size:10px"></p>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="" class="control-label">سبز</label></td>
                                <td>
                                    <input type="checkbox" class="" id="" name="FinGreen" <?php  if($markaz->FinGreen == 'ok') echo 'Checked' ?>>
                                    <p class="cama-seprator" style="font-size:10px"></p>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <input type="submit" class="btn btn-info pull-right" value="ثبت">
                    </div>
                    <!-- /.box-footer -->
                </form>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#gen_code').on('click', function(){
            var province = $('#Province').val();
            $.get( "{{url('GenCode/hidro')}}/"+ province, function( data ) {
                alert('کد جدید:  ' + data)
            });
        })
    </script>
    <script>
        cama_seprate_price()
        function cama_seprate_price(){
            $('.price').each(function(){
                var v = $(this).val();
                var v_s = v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                $($(this).parent().children()[1]).html(v_s)
            })
        }

        $('.price').on('keyup', function(){
            cama_seprate_price()
        })
        
    </script>
@endsection
