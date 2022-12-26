@extends('layouts.app')

@section('title')
    افزودن qr کد
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
                    <form method="POST" action="{{ Url('admin/addqr') }}" class="form-horizontal">
                        @csrf
                        <div class="from-group">
                            <label class="col-sm-2 control-lable">
                                کدمرکز: 
                            </label>
                            <input type="text" class="col-sm-10 form-control" name="CodeEtehadie">
                        </div>
                        <div class="from-group">
                            <label class="col-sm-2 control-lable">
                                دریافت کننده: 
                            </label>
                            <input type="text" class="col-sm-10 form-control" name="Receiver">
                        </div>
                        <div class="from-group">
                            <label class="col-sm-2 control-lable">
                                شماره بچ: 
                            </label>
                            <input type="text" class="col-sm-10 form-control" name="BatchNo">
                        </div>
                        <div class="from-group">
                            <input type="submit" class="btn btn-success" value="ثبت">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

