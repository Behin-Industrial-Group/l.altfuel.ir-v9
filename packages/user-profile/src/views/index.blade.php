@extends('layouts.app')

@section('title')
    کاربران
@endsection

@section('content')
    <div class="p-4">
        <div class="row m-10">
            <div class="col-sm-2">نام کاربری :</div>
            <div class="col-sm-10">{{ $user->display_name }}</div>
            <hr>
            <div class="col-sm-2">شماره موبایل :</div>
            <div class="col-sm-10">{{ $user->email }}</div>
            <hr>
            <a href="{{ route('user-profile.change-password') }}" class="col-sm-4 btn btn-primary btn-sm" >تغییر رمز عبور</a>
        </div>
    </div>
@endsection
