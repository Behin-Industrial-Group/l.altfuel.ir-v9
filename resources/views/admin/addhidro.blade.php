@extends('layouts.app')

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
                            نام و نام خانوادگی:
                        </label>
                        <input class="col-sm-8 form-control" name="Name" required>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-lable">
                            کد ملی: 
                        </label>
                        <input class="col-sm-8 form-control" name="NationalID">
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-lable">
                            استان
                        </label>
                        <select class="col-sm-8 from-control select2" dir="rtl" name="Province">
                            @foreach ($Provinces as $province)
                                <option>{{$province->Name}}</option>
                            @endforeach
                        </select>
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