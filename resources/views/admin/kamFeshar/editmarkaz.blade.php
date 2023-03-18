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
                <form class="form-horizontal" method="POST" action="{{Url("admin/kamfeshar/edit/$markaz->id") }}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-sm-12">
                        فعال: <input type="checkbox" name="enable" @if($markaz->enable) {{'checked'}} @endif data-toggle="toggle" data-size="sm">                        
                    </div>
                    <div class="box-body col-md-6"  style="border:solid 1px">

                        <div class="form-group alert alert-warning">
                            <label for="" class="col-sm-2 control-label">سال دریافت کد</label>

                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" id="" name="id" value="<?php echo $markaz->id ?>">
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
                            <label for="" class="col-sm-2 control-label">یوزر بازرسی تحویل داده شد</label>

                            <div class="col-sm-10">
                                <input type="checkbox" class="form-control" id="" name="InsUserDelivered" <?php  if($markaz->InsUserDelivered == 'ok') echo 'Checked' ?>>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10">
                                <input type="submit" class="btn btn-info pull-right" value="ثبت">
                            </div>
                        </div>
                    </div>
                </form>
                @if(Access::checkView('show_fin_form'))
                <form class="form-horizontal" method="POST" action="{{Url("admin/kamfeshar/edit/$markaz->id") }}">
                    @csrf
                    <div class="box-body col-md-6"  style="border:solid 1px">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">حق عضویت 96</label>

                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" id="" name="id" value="<?php echo $markaz->id ?>">
                                <input type="hidden" class="form-control" id="" name="FormType" value="FinForm">
                                <input type="text" class="form-control price" id="" name="MembershipFee96" value="<?php echo $markaz->MembershipFee96 ?>">
                            </div>
                            <label class="cama-seprator"></label>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">حق عضویت 97</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control price" id="" name="MembershipFee97" value="<?php echo $markaz->MembershipFee97 ?>">
                            </div>
                            <label class="cama-seprator"></label>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">حق عضویت 98</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control price" id="" name="MembershipFee98" value="<?php echo $markaz->MembershipFee98 ?>">
                            </div>
                            <label class="cama-seprator"></label>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">حق عضویت 99</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control price" id="" name="MembershipFee99" value="<?php echo $markaz->MembershipFee99 ?>">
                            </div>
                            <label class="cama-seprator"></label>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">حق عضویت 1400</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control price" id="" name="MembershipFee00" value="<?php echo $markaz->Membership00 ?>">
                            </div>
                            <label class="cama-seprator"></label>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">پشتیبانی سامانه</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control price" id="" name="IrngvFee" value="<?php echo $markaz->IrngvFee ?>">
                            </div>
                            <label class="cama-seprator"></label>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">هزینه قفل</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control price" id="" name="LockFee" value="<?php echo $markaz->LockFee ?>">
                            </div>
                            <label class="cama-seprator"></label>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">توضیحات مالی</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="" name="FinDetails" value="<?php echo $markaz->FinDetails ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">سبز</label>

                            <div class="col-sm-6">
                                <input type="checkbox" class="" id="" name="FinGreen" <?php  if($markaz->FinGreen == 'ok') echo 'Checked' ?>>
                            </div>
                        </div>

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
        cama_seprate_price()
        function cama_seprate_price(){
            $('.price').each(function(){
                var v = $(this).val();
                var v_s = v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                $($(this).parent().parent().children()[2]).html(v_s)
            })
        }

        $('.price').on('keyup', function(){
            cama_seprate_price()
        })
        
    </script>
    <script>
        $('#gen_code').on('click', function(){
            var province = $('#Province').val();
            $.get( "{{url('GenCode/kamfeshar')}}/"+ province, function( data ) {
                alert('کد جدید:  ' + data)
            });
        })
    </script>
@endsection
