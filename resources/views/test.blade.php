@extends('layouts.app')

@section('content')
{{ $_SERVER['REMOTE_ADDR'] }} <br>
{{$user}} <br>
{{$pass}}
    <iframe src="{{ $src }}" frameborder="0"
        style="width: 100%; height: 85vh"
        id="iframeId"
    ></iframe>
@endsection



