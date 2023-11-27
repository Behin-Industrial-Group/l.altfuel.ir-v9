@extends('layouts.welcome')

@section('title')
    تایید خرید
@endsection

@section('content')
    <div class="row">
        <div class="card col-sm-12">
            @if ($status == 100)
                <div class="alert alert-success">خرید با موفقیت انجام شد</div>
            @else
                <div class="alert alert-danger"> فرایند خرید ناموفق بود</div>
            @endif
            <table class="table table-striped ">
                <tr>
                    <td>وضعیت</td>
                    <td>{{$status ?? ''}}</td>
                </tr>
                <tr>
                    <td>کدرهگیری</td>
                    <td>{{$refId ?? ''}}</td>
                </tr>
                @if ($authority)
                <tr>
                    <td>Authority</td>
                    <td>{{$authority ?? ''}}</td>
                </tr>
                @endif
            </table>
        </div>
    </div>
@endsection
