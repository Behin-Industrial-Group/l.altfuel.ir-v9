@extends('layouts.app')

@section('title')
    نمایش اطلاعات پاسخ ها
@endsection

@section('content')
    <div class="row">
        <div class="box table-responsive">
            <div class="box-body">
                <p>
                    !!! راهنما !!! مقدار عددی جواب: خیلی کم برابر 1 و خیلی زیاد برابر 5 - بله برابر 1 خیر برابر 2
                </p>
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>کاربر</th>
                            <th>خودرو</th>
                            <th>شاسی</th>
                            <th>ش.گواهی سلامت</th>
                            <th>موبایل مالک</th>
                            <th>خودرو</th>
                            <th>مرکز خدمات</th>
                            <th>تاریخ صدور گواهی</th>
                            <th>سوال</th>
                            <th>مقدار عددی جواب</th>
                            <th>جواب</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $row)
                            <tr>
                                <td></td>
                                <td>{{ $row->user->owner_fullname }}</td>
                                <td>{{ $row->user->car_name }}</td>
                                <td>{{ $row->user->chassis }}</td>
                                <td>{{ $row->user->certificate_number }}</td>
                                <td>{{ $row->user->owner_mobile }}</td>
                                <td>{{ $row->user->car_name }}</td>
                                <td>{{ $row->user->agency_code }} - {{ $row->user->agency_name }}</td>
                                <td>{{ $row->user->issued_date }}</td>
                                <td>{{ $row->question }}</td>
                                <td>{{ $row->answer }}</td>
                                <td>{{ $row->answer_value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection