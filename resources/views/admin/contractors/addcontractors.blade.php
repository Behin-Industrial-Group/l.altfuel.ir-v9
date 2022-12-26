@extends('layout.dashboard')

@section('title')
    افزودن مرکز
@endsection

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-header">
                @if (!empty($message))
                    <div class="alert alert-success">
                        {{$message}}
                    </div>
                @endif
            </div>
            <div class="box-body">
                <form class="form-horizontal" method="POST" action="add">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-2 control-lable">
                            نام :
                        </label>
                        <input class="col-sm-8 form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-lable">
                            کد ملی: 
                        </label>
                        <input class="col-sm-8 form-control" name="nationalId">
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-lable">
                            تلفن: 
                        </label>
                        <input class="col-sm-8 form-control" name="phone">
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-lable">
                            آدرس: 
                        </label>
                        <input class="col-sm-8 form-control" name="address">
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-lable">
                        
                        </label>
                        <input type="submit" class="btn btn-success col-sm-2 form-control" value="ثبت">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection