@extends('layouts.app')

@section('title')
    ویرایش qr مرکز
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    @if (!empty($message))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif

                    @if (!empty($error))
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endif
                </div>
                <div class="box-body">
                    <form method="POST" action="<?php echo Url("admin/editqr/$info->id") ?>" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="from-group">
                            <label class="col-sm-2 control-lable">
                                کدمرکز: 
                            </label>
                            <input type="text" class="col-sm-10 form-control" name="CodeEtehadie" value="{{ $info->CodeEtehadie }}">
                        </div>
                        <div class="from-group">
                            <label class="col-sm-2 control-lable">
                                دریافت کننده: 
                            </label>
                            <input type="text" class="col-sm-10 form-control" name="Receiver" value="{{ $info->Receiver }}">
                        </div>
                        <div class="from-group">
                            <label class="col-sm-2 control-lable">
                                نرم افزار پلاک خوان
                            </label>
                            <input type="text" class="col-sm-10 form-control" name="PlateReader" value="{{ $info->PlateReader }}">
                        </div>
                        @if( !empty($info->DeliveryReceipts) )
                        <div class="from-group">
                            <label class="col-sm-2 control-lable">
                                رسید تحویل: 
                            </label>
                            <a href="<?php echo Url( "/$info->DeliveryReceipts" ); ?>">نمایش</a>
                        </div>
                        @else
                        <div class="from-group">
                            <label class="col-sm-2 control-lable">
                                رسید تحویل
                            </label>
                            <input type="file" class="col-sm-10 form-control" name="DeliveryReceipts" >
                        </div>
                        @endif
                        <div class="from-group">
                            <input type="submit" class="btn btn-success" value="ثبت">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

