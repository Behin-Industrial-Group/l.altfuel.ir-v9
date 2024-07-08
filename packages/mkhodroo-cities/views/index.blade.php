@extends('layouts.app')

@section('content')
    <div>
        <h2 class="col-12">اضافه کردن شهر</h2>
        <form action="javascript:void(0)" id="city-form">
            <label for="province" class="col-6">استان :</label>
            <input type="text" id="province" name="province" placeholder="{{__('province')}}" class="col-6">
            <label for="city" class="col-6">شهر :</label>
            <input type="text" id="city" name="city" placeholder="{{__('City')}}" class="col-6">
            <button onclick="add()">اضافه کردن</button>
        </form>
    </div>
@endsection
