@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>تیکت‌های باز</h3>
        @foreach ($tickets as $ticket)
            <div class="card mb-3">
                <div class="card-body">
                    <pre>{{ $ticket->messages }}</pre>

                    <form action="{{ route('telegram-tickets.reply', $ticket->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="reply" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">ارسال پاسخ</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
