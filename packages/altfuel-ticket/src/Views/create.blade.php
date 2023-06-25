@extends('layouts.app')

@php
    $title = "ایجاد تیکت پشتیبانی";
@endphp

@section('content')
    <div class="card card-info">
        <div class="card-header">
            ایجاد تیکت پشتیبانی
        </div>
        <div class="card-body">
            <form action="javascript:void(0)" id="ticket-form">
                @csrf
                <div class="form-group">
                    <label for="">دسته بندی</label>
                    @include('ATView::partial-view.catagory')
                </div>
                <div class="form-group">
                    <label for="">عنوان</label>
                    <input type="text" name="title" id="" class="form-control">
                </div>
                @include('ATView::partial-view.add-comment-form', ['form_id' => 'ticket-form'])
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.filepond').filepond();
    $('.filepond').filepond('storeAsFile', true);
    </script>
@endsection
