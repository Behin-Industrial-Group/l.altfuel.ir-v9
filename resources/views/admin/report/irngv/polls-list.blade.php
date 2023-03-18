@extends('layouts.app')

@section('title')
    گزارش نظرسنجی irngv
@endsection

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>سوال</th>
                <th>میانگین جواب ها</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($report as $key => $value)
                <tr>
                    <td>{{ $questions[$key]['question'] }}</td>
                    <td>{{ $value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>سوال</th>
                <th>خیلی کم</th>
                <th>کم</th>
                <th>متوسط</th>
                <th>زیاد</th>
                <th>خیلی زیاد</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($number_report as $key => $value)
                @if ($key != "q5")
                    <tr>
                        <td>{{ $questions[$key]['question'] }}</td>
                        <td>{{ $value[1] ?? '' }}</td>
                        <td>{{ $value[2] ?? ''}}</td>
                        <td>{{ $value[3] ?? ''}}</td>
                        <td>{{ $value[4] ?? ''}}</td>
                        <td>{{ $value[5] ?? ''}}</td>
                    </tr>
                @endif
                @if ($key === "q5")
                    <tr>
                        <th>سوال</th>
                        <th>بله</th>
                        <th>خیر</th>
                    </tr>
                    <tr>
                        <td>{{ $questions[$key]['question'] }}</td>
                        <td>{{ $value[1] ?? '' }}</td>
                        <td>{{ $value[2] ?? ''}}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection