@extends('layout.dashboard')

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
                <form class="form-horizontal" method="POST" action="{{Url("admin/contractors/edit/$markaz->id") }}" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body col-md-6"  style="border:solid 1px">
                        
                        <div class="form-group alert alert-warning">
                            <input type="hidden" class="form-control" id="" name="id" value="<?php echo $markaz->id ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">کد ملی</label>
        
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="nationalId" value="<?php echo $markaz->nationalId ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">نام</label>
        
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="name" value="<?php echo $markaz->name ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">تلفن</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="phone" value="<?php echo $markaz->phone ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">آدرس</label>
        
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="address" value="<?php echo $markaz->address ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input type="submit" class="btn btn-info pull-right" value="ثبت">
                            </div>
                        </div>
                    </div>
                </form>
                @can('Level3')
                <form class="form-horizontal" method="POST" action="editmarkaz">
                    @csrf  
                    <div class="box-body col-md-6"  style="border:solid 1px">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">حق عضویت 96</label>
        
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" id="" name="id" value="<?php echo $markaz->id ?>">
                                <input type="hidden" class="form-control" id="" name="FormType" value="FinForm">
                                <input type="text" class="form-control" id="" name="MembershipFee96" value="<?php echo $markaz->MembershipFee96 ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">حق عضویت 97</label>
        
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="MembershipFee97" value="<?php echo $markaz->MembershipFee97 ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">حق عضویت 98</label>
        
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="MembershipFee98" value="<?php echo $markaz->MembershipFee98 ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">حق عضویت 99</label>
        
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="MembershipFee99" value="<?php echo $markaz->MembershipFee99 ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">پشتیبانی سامانه</label>
        
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="IrngvFee" value="<?php echo $markaz->IrngvFee ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">هزینه قفل</label>
        
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="LockFee" value="<?php echo $markaz->LockFee ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">توضیحات مالی</label>
        
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="FinDetails" value="<?php echo $markaz->FinDetails ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">سبز</label>
        
                            <div class="col-sm-10">
                                <input type="checkbox" class="form-control" id="" name="FinGreen" <?php  if($markaz->FinGreen == 'ok') echo 'Checked' ?>>
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <input type="submit" class="btn btn-info pull-right" value="ثبت">
                    </div>
                    <!-- /.box-footer -->
                </form>
                @endcan
                
            </div>
        </div>
    </div>
@endsection