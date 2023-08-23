@extends('layouts.app')

@section('content')
{{-- {{ $_SERVER['REMOTE_ADDR'] }} --}}
{{-- {{ env('PM_SERVER') }} --}}
    @isset($error)
        <div class="alert alert-danger">{{$error}}</div>
    @endisset
    <iframe src="" frameborder="0"
        style="width: 100%; height: 85vh"
        id="iframeId"
    ></iframe>
@endsection
<script>
    $('iframe').attr('src', '{{$src}}');
</script>


