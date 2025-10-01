@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Ticket ID: {{ $ticket->id }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">User ID: {{ $ticket->user_id }}</h6>
                <p class="card-text">
                    وضعیت:
                    @switch($ticket->status)
                        @case('open')
                            باز
                        @break

                        @case('answered')
                            پاسخ داده‌شده
                        @break

                        @case('closed')
                            بسته شده
                        @break

                        @default
                            -
                    @endswitch
                </p>
                <hr>
                <p><strong>مکالمه:</strong></p>
                <pre>{{ $ticket->messages }}</pre>

                @if ($ticket->status !== 'closed')
                    <form action="{{ route('telegram-tickets.reply', $ticket->id) }}" method="POST">
                        @csrf
                        <div class="form-group mt-3">
                            <textarea name="reply" class="form-control" rows="3" placeholder="پاسخ خود را اینجا بنویسید..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">ارسال پاسخ</button>
                    </form>

                    <form action="{{ route('telegram-tickets.close', $ticket->id) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-danger">بستن تیکت</button>
                    </form>
                @else
                    <p class="mt-3">این تیکت بسته شده است.</p>
                @endif

                @if ($ticket->reply)
                    <p class="mt-3">آخرین پاسخ پشتیبان: {{ $ticket->reply }}</p>
                @endif
            </div>
        </div>
        <a href="{{ route('telegram-tickets.index') }}" class="btn btn-secondary mt-3">بازگشت به لیست تیکت‌ها</a>
    </div>
@endsection
