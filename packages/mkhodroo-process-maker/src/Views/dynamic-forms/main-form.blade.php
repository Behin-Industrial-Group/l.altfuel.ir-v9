@extends('PMViews::dyna-form-layout')
@section('content')
    <div class="row form-group">
        <div class="col-sm-3">{{ __('warning_number') }}</div>
        <div class="col-sm-9">
            <input type="text" name="warning_number" value="{{ $vars->warning_number ?? '' }}" class="form-control" id="">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-3">{{ __('warning_register_date') }}</div>
        <div class="col-sm-9">
            <input type="text" name="warning_register_date" value="{{ $vars->warning_register_date ?? '' }}" class="form-control" id="">
        </div>
    </div>
@endsection
