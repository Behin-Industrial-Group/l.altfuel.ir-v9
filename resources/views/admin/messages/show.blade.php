@extends('layouts.app')

@section('content')
    <style>
        #msg{
            border: 1px solid black;
            margin: 3px;
            border-radius: 3px;
            font-size: 12px;
            padding: 8px 5px 0 0;
            color: black;
        }
    </style>
    <div class='row'>
        <div class="col-sm-4"></div>
        <div class="col-sm-4" id="msg">
            <p>تاریخ: {{$message->created_at}}</p>
            <p>از طرف: {{$message->from}}-{{$message->display_name}}</p>
            <p>پیام: {{$message->message}}</p>
        </div>
    </div>
@endsection