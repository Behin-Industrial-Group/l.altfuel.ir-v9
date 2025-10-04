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
                        <div class="mb-3 d-flex {{ $message->sender_type === 'agent' ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="message-bubble {{ $message->sender_type === 'agent' ? 'message-bubble-agent' : 'message-bubble-user' }}"
                                data-message-id="{{ $message->id }}"
                                data-message-preview="{{ e(Str::limit($message->message, 120)) }}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-semibold">
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
                                    <blockquote class="blockquote border-start ps-2 ms-2 reply-reference">
                                        <small class="text-muted">
                                            {{ Str::limit($message->replyTo->message, 120) }}
                                        </small>
                                    </blockquote>
                                @endif

                                <div class="message-content">{!! nl2br(e($message->message)) !!}</div>

                                <div class="text-end mt-3">
                                    <button type="button" class="btn btn-sm btn-outline-primary reply-button"
                                        data-message-id="{{ $message->id }}"
                                        data-message-preview="{{ e(Str::limit($message->message, 120)) }}">
                                        ریپلای
                                    </button>
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
                        <input type="hidden" name="reply_to_message_id" id="reply_to_message_id"
                            value="{{ old('reply_to_message_id') }}">

                        <div id="reply-preview" class="alert alert-secondary d-none align-items-center justify-content-between">
                            <div>
                                در حال پاسخ به:
                                <span id="reply-preview-text" class="fw-semibold"></span>
                            </div>
                            <button type="button" class="btn-close" aria-label="حذف" id="reply-preview-clear"></button>
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

@push('styles')
    <style>
        .conversation {
            background-color: #f7f8fa;
            padding: 1.5rem;
            border-radius: 1rem;
        }

        .message-bubble {
            max-width: 75%;
            padding: 1rem 1.25rem;
            border-radius: 1rem;
            position: relative;
            box-shadow: 0 0.5rem 1rem rgba(31, 45, 61, 0.08);
        }

        .message-bubble-user {
            background: #ffffff;
            border: 1px solid #e4e6ef;
        }

        .message-bubble-agent {
            background: linear-gradient(135deg, #e0f0ff 0%, #f3f9ff 100%);
            border: 1px solid #cfe2ff;
        }

        .reply-reference {
            border-color: #0d6efd !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const replyInput = document.getElementById('reply_to_message_id');
            const replyPreview = document.getElementById('reply-preview');
            const replyPreviewText = document.getElementById('reply-preview-text');
            const replyPreviewClear = document.getElementById('reply-preview-clear');

            function showPreview(messageId, messageText) {
                if (!replyPreview || !replyPreviewText || !replyInput) {
                    return;
                }

                replyInput.value = messageId || '';

                if (messageId) {
                    replyPreviewText.textContent = messageText || '';
                    replyPreview.classList.remove('d-none');
                    replyPreview.classList.add('d-flex');
                } else {
                    replyPreviewText.textContent = '';
                    replyPreview.classList.remove('d-flex');
                    replyPreview.classList.add('d-none');
                }
            }

            document.querySelectorAll('.reply-button').forEach(function (button) {
                button.addEventListener('click', function () {
                    const messageId = this.dataset.messageId;
                    const messageText = this.dataset.messagePreview || '';
                    showPreview(messageId, messageText);
                });
            });

            if (replyPreviewClear) {
                replyPreviewClear.addEventListener('click', function () {
                    showPreview('', '');
                });
            }

            if (replyInput && replyInput.value) {
                const selectedMessage = document.querySelector('.reply-button[data-message-id="' + replyInput.value + '"]');
                if (selectedMessage) {
                    showPreview(replyInput.value, selectedMessage.dataset.messagePreview || '');
                }
            }
        });
    </script>
@endpush
