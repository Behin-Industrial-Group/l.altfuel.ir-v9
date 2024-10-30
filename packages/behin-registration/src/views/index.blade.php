@extends('layouts.welcome')

@section('title')
    ثبت نام
@endsection
@section('style')

<style>
    body{
        background: rgb(81, 42, 79) !important;
    }
</style>

@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
            <h2 class="text-center mb-4">فرم ثبت نام</h2>
            <form action="{{ route('registration.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">نام:</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>

                <div class="mb-3">
                    <label for="national_id" class="form-label">کد ملی:</label>
                    <input type="text" class="form-control" name="national_id" id="national_id" required>
                </div>

                <div class="mb-3">
                    <label for="mobile" class="form-label">شماره موبایل:</label>
                    <input type="text" class="form-control" name="mobile" id="mobile" required>
                </div>

                <div class="mb-4">
                    <label for="price" class="form-label">نوع آزمون:</label>
                    <select name="price" id="price" class="form-select" required>
                        <option value="1">150 هزار تومان</option>
                        <option value="2">300 هزار تومان</option>
                        <option value="3">800 هزار تومان</option>
                        <option value="4">1200 هزار تومان</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">ادامه و پرداخت</button>
            </form>
        </div>
    </div>
@endsection
