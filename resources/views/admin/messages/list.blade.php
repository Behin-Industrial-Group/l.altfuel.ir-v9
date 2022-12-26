@extends('layouts.app')

@section('content')
    <style>
        .new{
            border: 2px solid black;
            margin: 3px;
            border-radius: 3px;
            height: 35px;
            font-size: 12px;
            padding: 8px 5px 0 0;
            color: black;
            overflow: hidden;
        }
        .read{
            border: 1px solid gray;
            margin: 3px;
            border-radius: 3px;
            height: 35px;
            font-size: 12px;
            padding: 8px 5px 0 0;
            color: gray;
            overflow: hidden;
        }
    </style>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-6">
            @foreach ($messages as $m)
                <a href="{{url('admin/messages/show')}}/{{$m->id}}">
                    <div class="col-sm-6 {{$m->status}}">
                        {{$m->display_name}}: {{$m->message}}
                    </div>
                    <div class="col-sm-4 {{$m->status}}"  dir="ltr" style="text-align: center">{{$m->created_at}}</div>
                </a>
            @endforeach
        </div>
    </div>
@endsection