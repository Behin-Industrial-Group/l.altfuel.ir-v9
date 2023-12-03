@extends('layouts.welcome')


@section('content')
    <div class="register-box card" id="body">
        {{-- <h3>
            با عرض پوزش لینک پرداخت بدهی موقتا غیرفعال است.

        </h3> --}}
        <form method="POST" action="javascript:void(0)" style="margin: 5px" id="bedehi-form">
            @csrf
            <table class="table table-striped table-bordered">
                <tr>
                    <td colspan="2">
                        @isset($message)
                            <div class="alert alert-success">{{ $message ?? '' }}</div>
                        @endisset
                        @isset($error)
                            <div class="alert alert-danger">{{ $error ?? '' }}</div>
                        @endisset
                    </td>
                </tr>
                <tr>
                    <td>{{__('Ref Id')}}:</td>
                    <td>{{$refId ?? ''}}</td>
                </tr>
            </table>
        </form>
    </div>
@endsection