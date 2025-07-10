@extends('layouts.app')

@section('style')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endsection

@section('content')
    @if (auth()->user()->access('پذیرش همایش'))
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <p>پذیرش همایش</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('event-verification.verify-form', 4) }}" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    @endif
@endsection
