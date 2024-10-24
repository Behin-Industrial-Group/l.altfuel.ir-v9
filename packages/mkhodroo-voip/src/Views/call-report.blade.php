@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="">
            <form action="{{ route('voip.getCallReport') }}" method="get">
                {{ trans('start') }}: <input type="date" name="start_date" id="" class="form-control col-sm-3">
                {{ trans('end') }}: <input type="date" name="end_date" id="" class="form-control col-sm-3">
                <input type="submit" class="btn btn-default" name="" id="">
            </form>
        </div>
        <div class="mt-3">
            <h2>آمار تماس‌ها</h2>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>داخلی</th>
                        <th>کارشناس</th>
                        <th>تعداد تماس‌های پاسخ داده شده</th>
                        <th>تعداد تماس‌های مشغول</th>
                        <th>تعداد تماس‌های بی پاسخ</th>
                        <th>تعداد کل تماس‌ها</th>
                        <th>درصد پاسخگویی</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($callStats as $item)
                    @php
                        $total_calls  =  $item->answered_calls  + $item->busy_calls + $item->no_answered_calls;
                        $percentage = $item->answered_calls / ($total_calls - $item->busy_calls) * 100;
                        $percentage = round($percentage,1);
                    @endphp
                        <tr>
                            <td>{{ $item->dst }}</td>
                            <td>{{ $dstMapToExpert[$item->dst] }}</td>
                            <td>{{ $item->answered_calls }}</td>
                            <td>{{ $item->busy_calls }}</td>
                            <td>{{ $item->no_answered_calls }}</td>
                            <td>{{ $total_calls }}</td>
                            <td>{{ $percentage }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>
@endsection
