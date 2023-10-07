@extends('PMViews::dyna-form-layout')
@section('content')
    @foreach ($vars as $var)
        {{ $var->var_title }} <br>
    @endforeach
@endsection
