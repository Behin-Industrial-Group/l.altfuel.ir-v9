@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>لیست تیکت‌ها</h3>
        @if ($tickets->isEmpty())
            <p>هیچ تیکتی برای نمایش وجود ندارد.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>نام کاربر</th>
                        <th>آخرین پیام</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->user_id }}</td> {{-- Assuming user_id can act as a name or you have a relation --}}
                            <td>{{ Str::limit($ticket->messages, 50) }}</td>
                            <td>{{ $ticket->status == 'open' ? 'باز' : 'بسته' }}</td>
                            <td>
                                <a href="{{ route('telegram-tickets.show', $ticket->id) }}" class="btn btn-info btn-sm">مشاهده</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
