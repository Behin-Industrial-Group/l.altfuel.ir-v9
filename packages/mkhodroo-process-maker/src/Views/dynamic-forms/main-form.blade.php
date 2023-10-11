@extends('PMViews::dyna-form-layout')
@section('content')
    @foreach ($vars as $var)
    @php
        $var_name = $var->var_title;
    @endphp
        <div class="row form-group">
            <div class="col-sm-3">{{ __($var_name) }}</div>
            <div class="col-sm-9">
                <input type="text" name="{{$var_name}}" value="{{ $variable_values->$var_name ?? '' }}" class="form-control" id="">
            </div>
        </div>
    @endforeach
@endsection
