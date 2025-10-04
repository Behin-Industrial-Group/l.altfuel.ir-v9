@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

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

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <hr>
                <p><strong>مکالمه:</strong></p>

                <div class="conversation" style="max-height: 400px; overflow-y: auto;">
                    @forelse ($ticket->messages as $message)
                        <div class="mb-3">
                            <div class="d-flex {{ $message->sender_type === 'agent' ? 'justify-content-end' : '' }}">
                                <div class="p-3 border rounded {{ $message->sender_type === 'agent' ? 'bg-light' : 'bg-white' }}"
                                    style="max-width: 75%;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>
                                            @switch($message->sender_type)
                                                @case('agent')
                                                    👨‍💼 پشتیبان
                                                @break

                                                @case('bot')
                                                    🤖 ربات
                                                @break

                                                @default
                                                    👤 کاربر
                                            @endswitch
                                        </span>
                                        <small class="text-muted">{{ optional($message->created_at)->format('Y-m-d H:i') }}</small>
                                    </div>

                                    @if ($message->replyTo)
                                        <blockquote class="blockquote border-start ps-2 ms-2">
                                            <small class="text-muted">
                                                {{ Str::limit($message->replyTo->message, 120) }}
                                            </small>
                                        </blockquote>
                                    @endif

                                    <div class="message-content">{!! nl2br(e($message->message)) !!}</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">پیامی برای این تیکت ثبت نشده است.</p>
                    @endforelse
                </div>

                @if ($ticket->status !== 'closed')
                    <form action="{{ route('telegram-tickets.reply', $ticket->id) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="form-group">
                            <label for="reply_to_message_id" class="form-label">ریپلای به پیام</label>
                            <select name="reply_to_message_id" id="reply_to_message_id" class="form-select">
                                <option value="">بدون ریپلای</option>
                                @foreach ($ticket->messages->sortByDesc('created_at') as $message)
                                    <option value="{{ $message->id }}" @selected(old('reply_to_message_id') == $message->id)>
                                        {{ Str::limit($message->message, 80) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <textarea name="reply" class="form-control" rows="3" placeholder="پاسخ خود را اینجا بنویسید..." required>{{ old('reply') }}</textarea>
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
            </div>
        </div>
        <a href="{{ route('telegram-tickets.index') }}" class="btn btn-secondary mt-3">بازگشت به لیست تیکت‌ها</a>
    </div>
@endsection
