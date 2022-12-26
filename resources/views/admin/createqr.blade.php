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
                <form method="POST" action="createqr" class="form-horizontal">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-2 control-lable">
                            کد مرکز: 
                        </label>
                        <input type="text" class="col-sm-2 form-control" name="code">
                        <input type="submit" class="btn btn-success" value="ثبت">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@endsection