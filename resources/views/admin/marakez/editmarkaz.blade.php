<?php 

use App\CustomClasses\Access;
?>
                <form class="form-horizontal" method="POST" action="{{url("admin/marakez/edit/$markaz->id")}}" enctype="multipart/form-data">
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
                                <input type="text" class="form-control col-sm-9" id="CodeEtehadie" name="CodeEtehadie" value="<?php echo $markaz->CodeEtehadie ?>">
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
                
                @endif

                <div class="col-sm-6">
                    <div class="box box-info box-solid">
                        <div class="box-header">
                            اطلاعات قفل سخت افزاری و نرم افزار پلاک خوان مرکز
                        </div>
                        <div class="box-body">
                            <form action="{{url('admin/marakez/edit-pelakkhan')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{$markaz->id}}">
                                <table class="table table-striped">
                                    <tr>
                                        <td>تحویل گیرنده: </td>
                                        <td>
                                            <input type="text" class="form-control" name="Receiver" value="{{$markaz->Receiver}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>سری قفل: </td>
                                        <td>
                                            <input type="text" class="form-control" name="Batch" value="{{$markaz->Batch}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>رسید تحویل: </td>
                                        <td>
                                            @if (empty($markaz->DeliveryReceipts))
                                                <input type="file" class="form-control" name="DeliveryReceipts">
                                            @else
                                                <a href="{{url("$markaz->DeliveryReceipts")}}">تصویر</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> نرم افزار پلاک خوان: </td>
                                        <td>
                                            <input type="text" class="form-control" name="PlateReader" value="{{$markaz->PlateReader}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>بارکد: </td>
                                        <td>
                                            @if (!empty($markaz->PlateReader))
                                                <a href="{{url('public/qrimages')}}/{{$markaz->CodeEtehadie}}.jpg">نمایش</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="submit" class="btn btn-info">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="box box-info box-solid">
                        <div class="box-header">
                            پیامک های یاداوری ارسال شده به مراکز
                        </div>
                        <div class="box-body">
                            <div class="col-sm-6">
                                پیامک 3 ماه مانده به تاریخ انقضا
                            </div>
                            <input type="text" name="" dir="ltr" class="form-control col-sm-6" value="{{ $markaz->SmsSended_3MonthsToExp }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#gen_code').on('click', function(){
            var province = $('#Province').val();
            $.get( "{{url('GenCode/markaz')}}/"+ province, function( data ) {
                alert('کد جدید:  ' + data)
            });
        })
    </script>
@endsection
