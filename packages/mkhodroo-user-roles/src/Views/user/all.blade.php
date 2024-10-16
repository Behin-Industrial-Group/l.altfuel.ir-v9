@extends('layouts.app')

@section('title', 'کاربران')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box mb-4">
                <div class="box-header d-flex justify-content-between align-items-center">
                    <h3 class="box-title">لیست کاربران</h3>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-user-plus"></i> ایجاد کاربر
                    </a>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>شناسه</th>
                                    <th>نام</th>
                                    <th>نام کاربری</th>
                                    <th>ویرایش</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->display_name }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            <a href="{{ $user->id }}" class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i> ویرایش
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
