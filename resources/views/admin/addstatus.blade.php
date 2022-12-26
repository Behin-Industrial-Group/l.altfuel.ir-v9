@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-header">
                @if (!empty($Message))
                    <div class="alert alert-success">
                        {{ $Message }}
                    </div>
                @endif
            </div>
            <div class="box-body">
                <form class="form-horizontal" method="POST" action="addstatus" >
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-2 control-lable">
                            پرونده: 
                        </label>
                        <select class="col-sm-10 form-control select2" name="archive_id" dir="rtl">
                            @foreach ($Archive as $archive)
                                <option value="{{ $archive->id}}">
                                    {{$archive->No ." - ". $archive->ostan ." - ".  $archive->name}}
                                </option> 
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-lable">
                            وضعیت: 
                        </label>
                        <select class="col-sm-10 form-control select2" name="Status_id" dir="rtl">
                            @foreach ($Status as $status)
                                <option value="{{ $status->id}}">
                                    {{$status->id ." - ". $status->status}}
                                </option> 
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="ثبت">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection