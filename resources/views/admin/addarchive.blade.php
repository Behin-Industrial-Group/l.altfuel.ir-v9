@extends('layouts.app')

@section('title')
    افزودن پرونده
@endsection

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-header">
                @if (!empty($message))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @endif
            </div>
            <div class="box-body">
                <form class="form-horizontal" method="POST" action="addarchive">
                    @csrf
                    <div class="from-group">
                        <label class="col-sm-2 control-lable">
                            نام: 
                        </label>
                        <input type="text" name="name" class="col-sm-10 form-control">
                    </div>
                    <div class="from-group">
                        <label class="col-sm-2 control-lable">
                            کدملی: 
                        </label>
                        <input type="text" name="nationalCode" class="col-sm-10 form-control">
                    </div>
                    <div class="from-group">
                        <label class="col-sm-2 control-lable">
                            استان
                        </label>
                        <select class="col-sm-10 form-control select2" name='province' dir="rtl">
                            @foreach ($Province as $province)
                                <option value="{{$province->Name}}">{{$province->Name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="from-group">
                        <label class="col-sm-2 control-lable">
                            رسته: 
                        </label>
                        <select class="col-sm-10 form-control select2" name='raste' dir="rtl">
                            @foreach ($Raste as $raste)
                                <option value="{{$raste->id}}">{{$raste->Name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="from-group">
                        <label class="col-sm-2 control-lable">
                            شماره همراه: 
                        </label>
                        <input type="text" name="cellphone" class="col-sm-10 form-control">
                    </div>
                    <div class="from-group">
                        <input type="submit" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection