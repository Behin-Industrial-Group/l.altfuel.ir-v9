@extends('layouts.app')

@section('title')
    ثبت نام دوره آموزشی همایش یکم تیرماه
@endsection

@section('content')
    <div class="col-sm-12">
        <table class="table table-stripped" id="table">
            <thead>
                <tr>
                    <th>کد کلاس</th>
                    <th>عنوان کلاس</th>
                    <th>روز</th>
                    <th>ساعت</th>
                    <th>مدرس</th>
                    <th>متولی</th>
                    <th>ظرفیت</th>
                    <th>استان</th>
                    <th>نام</th>
                    <th>کدملی</th>
                    <th>موبایل</th>
                    <th>نوع</th>
                    <th>توضیحات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $r)
                    <tr>
                        <td>{{ $r->workshop_name()->code }}</td>
                        <td>{{ $r->workshop_name()->title }}</td>
                        <td>{{ $r->workshop_name()->day }}</td>
                        <td>{{ $r->workshop_name()->time }} - {{ $r->workshop_name()->end_time }}</td>
                        <td>{{ $r->workshop_name()->teacher }}</td>
                        <td>{{ $r->workshop_name()->motevali }}</td>
                        <td>{{ $r->workshop_name()->capacity }}</td>
                        <td>{{ $r->province }}</td>
                        <td>{{ $r->name }}</td>
                        <td>{{ $r->national_id }}</td>
                        <td>{{ $r->mobile }}</td>
                        <td>{{ $r->type() }}</td>
                        <td>{{ $r->type_des }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection