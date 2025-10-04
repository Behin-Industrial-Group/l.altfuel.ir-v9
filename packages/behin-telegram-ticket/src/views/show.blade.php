@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="container-md ticket-wrapper py-4">
        <div class="ticket-surface">
            <div class="ticket-header mb-4">
                <div>
                    <h5 class="ticket-title">تیکت شماره {{ $ticket->id }}</h5>
                    <p class="ticket-subtitle mb-1">کاربر: {{ $ticket->user_id }}</p>
                    <span class="chip chip-status chip-status-{{ $ticket->status }}">
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
                    </span>
                </div>
                <div class="ticket-actions text-end">
                    <a href="{{ route('telegram-tickets.index') }}" class="btn btn-outline-secondary btn-sm">
                        بازگشت به لیست
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success material-alert">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger material-alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="conversation" style="max-height: 420px; overflow-y: auto;">
                @forelse ($ticket->messages as $message)
                    <div class="message-row {{ $message->sender_type === 'agent' ? 'message-row-agent' : 'message-row-user' }}">
                        <div class="message-avatar">
                            @switch($message->sender_type)
                                @case('agent')
                                    <span class="material-avatar material-avatar-agent" title="پشتیبان">👨‍💼</span>
                                @break

                                @case('bot')
                                    <span class="material-avatar material-avatar-bot" title="ربات">🤖</span>
                                @break

                                @default
                                    <span class="material-avatar material-avatar-user" title="کاربر">👤</span>
                            @endswitch
                        </div>
                        <div class="message-bubble {{ $message->sender_type === 'agent' ? 'message-bubble-agent' : 'message-bubble-user' }}"
                            data-message-id="{{ $message->id }}"
                            data-message-preview="{{ e(Str::limit($message->message, 140)) }}">
                            <div class="message-meta">
                                <span class="message-author">
                                    @switch($message->sender_type)
                                        @case('agent')
                                            پشتیبان
                                        @break

                                        @case('bot')
                                            ربات
                                        @break

                                        @default
                                            کاربر
                                    @endswitch
                                </span>
                                <span class="message-time">{{ optional($message->created_at)->format('Y-m-d H:i') }}</span>
                            </div>

                            @if ($message->replyTo)
                                <div class="message-reply-chip">
                                    <span class="material-icon">↩</span>
                                    <span class="text-truncate">{{ Str::limit($message->replyTo->message, 120) }}</span>
                                </div>
                            @endif

                            <div class="message-content">{!! nl2br(e($message->message)) !!}</div>

                            <div class="message-actions">
                                <button type="button" class="md-text-button reply-button"
                                    data-message-id="{{ $message->id }}"
                                    data-message-preview="{{ e(Str::limit($message->message, 140)) }}">
                                    <span class="material-icon">↩</span>
                                    <span>پاسخ</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">پیامی برای این تیکت ثبت نشده است.</p>
                @endforelse
            </div>

                @if ($ticket->status !== 'closed')
                    <form action="{{ route('telegram-tickets.reply', $ticket->id) }}" method="POST" class="mt-4 material-form">
                        @csrf
                        <input type="hidden" name="reply_to_message_id" id="reply_to_message_id"
                            value="{{ old('reply_to_message_id') }}">

                        <div id="reply-preview" class="material-reply-banner d-none">
                            <div class="material-reply-body">
                                <span class="material-icon">↩</span>
                                <div class="material-reply-text">
                                    <p class="mb-0 text-muted">در حال پاسخ به:</p>
                                    <p id="reply-preview-text" class="mb-0 fw-semibold"></p>
                                </div>
                            </div>
                            <button type="button" class="md-icon-button" aria-label="حذف" id="reply-preview-clear">
                                <span class="material-icon">✕</span>
                            </button>
                        </div>

                        <div class="form-group mt-3 material-textarea-group">
                            <textarea name="reply" id="reply" class="material-textarea" rows="4" placeholder=" " required>{{ old('reply') }}</textarea>
                            <label for="reply" class="material-label">پیام شما</label>
                        </div>

                        <button type="submit" class="md-raised-button md-raised-button-primary mt-3">ارسال پاسخ</button>
                    </form>
                    <form action="{{ route('telegram-tickets.close', $ticket->id) }}" method="POST" class="mt-3 d-inline-block">
                        @csrf
                        <button type="submit" class="md-raised-button md-raised-button-danger">بستن تیکت</button>
                    </form>
                @else
                    <p class="mt-3">این تیکت بسته شده است.</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .ticket-wrapper {
            max-width: 960px;
        }

        .ticket-surface {
            background: #fafbfc;
            border-radius: 24px;
            padding: 2.5rem 2rem;
            box-shadow: 0px 20px 45px -24px rgba(15, 23, 42, 0.35);
            border: 1px solid rgba(148, 163, 184, 0.15);
        }

        .ticket-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
        }

        .ticket-title {
            font-weight: 700;
        }

        .ticket-subtitle {
            color: #6b7280;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .chip-status-open {
            background: rgba(16, 185, 129, 0.1);
            color: #047857;
        }

        .chip-status-answered {
            background: rgba(37, 99, 235, 0.1);
            color: #1d4ed8;
        }

        .chip-status-closed {
            background: rgba(239, 68, 68, 0.1);
            color: #b91c1c;
        }

        .material-alert {
            border-radius: 14px;
            border: none;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .conversation {
            background: #ffffff;
            padding: 1.75rem 1.5rem;
            border-radius: 20px;
            box-shadow: inset 0 1px 0 rgba(148, 163, 184, 0.12);
        }

        .message-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            align-items: flex-start;
        }

        .message-row-agent {
            flex-direction: row-reverse;
        }

        .message-avatar {
            flex-shrink: 0;
        }

        .material-avatar {
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 1.2rem;
            background: #e5e7eb;
            box-shadow: inset 0 1px 2px rgba(15, 23, 42, 0.18);
        }

        .material-avatar-agent {
            background: rgba(37, 99, 235, 0.12);
        }

        .material-avatar-bot {
            background: rgba(168, 85, 247, 0.15);
        }

        .material-avatar-user {
            background: rgba(14, 165, 233, 0.14);
        }

        .message-bubble {
            position: relative;
            width: 100%;
            max-width: 640px;
            background: #f8fafc;
            border-radius: 20px;
            padding: 1rem 1.25rem 1.25rem;
            box-shadow: 0 16px 30px -18px rgba(15, 23, 42, 0.4);
            border: 1px solid transparent;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        .message-bubble-user {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.08), rgba(14, 165, 233, 0.02));
        }

        .message-bubble-agent {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.08), rgba(59, 130, 246, 0.02));
        }

        .message-bubble.selected-reply {
            border-color: rgba(37, 99, 235, 0.55);
            box-shadow: 0 20px 45px -20px rgba(37, 99, 235, 0.4);
            transform: translateY(-2px);
        }

        .message-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
            font-size: 0.85rem;
            color: #64748b;
        }

        .message-author {
            font-weight: 600;
            color: #0f172a;
        }

        .message-content {
            color: #1f2937;
            line-height: 1.7;
        }

        .message-reply-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            background: rgba(99, 102, 241, 0.12);
            border-radius: 12px;
            font-size: 0.78rem;
            color: #4338ca;
            margin-bottom: 0.75rem;
            max-width: 100%;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .message-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 1rem;
        }

        .material-icon {
            font-size: 1.05rem;
            vertical-align: middle;
        }

        .md-text-button {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.6rem;
            border-radius: 999px;
            border: none;
            background: transparent;
            color: #2563eb;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .md-text-button:hover {
            background: rgba(37, 99, 235, 0.08);
            color: #1d4ed8;
        }

        .material-reply-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            background: rgba(37, 99, 235, 0.08);
            border-radius: 16px;
            padding: 0.75rem 1rem;
            margin-top: 1.5rem;
            transition: opacity 0.2s ease;
        }

        .material-reply-body {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .md-icon-button {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background: transparent;
            color: #475569;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .md-icon-button:hover {
            background: rgba(15, 23, 42, 0.08);
        }

        .material-form {
            margin-top: 2.5rem;
        }

        .material-textarea-group {
            position: relative;
        }

        .material-textarea {
            width: 100%;
            border: none;
            border-bottom: 2px solid rgba(148, 163, 184, 0.5);
            border-radius: 0;
            padding: 1.5rem 0.75rem 0.75rem;
            resize: vertical;
            background: transparent;
            color: #0f172a;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .material-textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 2px 0 0 #2563eb;
        }

        .material-label {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            color: #64748b;
            transition: all 0.2s ease;
            pointer-events: none;
        }

        .material-textarea:focus + .material-label,
        .material-textarea:not(:placeholder-shown) + .material-label {
            transform: translateY(-0.75rem);
            font-size: 0.8rem;
            color: #2563eb;
        }

        .material-textarea-group .material-label {
            right: auto;
            left: 0.75rem;
        }

        .md-raised-button {
            border: none;
            border-radius: 999px;
            padding: 0.65rem 1.75rem;
            font-weight: 600;
            letter-spacing: 0.01em;
            cursor: pointer;
            box-shadow: 0 10px 30px -18px rgba(15, 23, 42, 0.6);
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }

        .md-raised-button-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
        }

        .md-raised-button-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #fff;
        }

        .md-raised-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 24px 32px -20px rgba(37, 99, 235, 0.45);
        }

        .md-raised-button-danger:hover {
            box-shadow: 0 24px 32px -20px rgba(239, 68, 68, 0.45);
        }

        @media (max-width: 768px) {
            .ticket-surface {
                padding: 1.5rem 1.25rem;
            }

            .message-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .message-row-agent {
                flex-direction: column;
                align-items: flex-end;
            }

            .message-bubble {
                max-width: 100%;
            }
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
            const messageBubbles = document.querySelectorAll('.message-bubble');

            function showPreview(messageId, messageText) {
                if (!replyPreview || !replyPreviewText || !replyInput) {
                    return;
                }

                replyInput.value = messageId || '';

                if (messageId) {
                    replyPreviewText.textContent = messageText || '';
                    replyPreview.classList.remove('d-none');

                    messageBubbles.forEach((bubble) => {
                        bubble.classList.toggle('selected-reply', bubble.dataset.messageId === messageId);
                    });
                } else {
                    replyPreviewText.textContent = '';
                    replyPreview.classList.add('d-none');

                    messageBubbles.forEach((bubble) => {
                        bubble.classList.remove('selected-reply');
                    });
                }
            }

            document.querySelectorAll('.reply-button').forEach(function (button) {
                button.addEventListener('click', function () {
                    const messageId = this.dataset.messageId;
                    const messageText = this.dataset.messagePreview || '';

                    if (replyInput && replyInput.value === messageId) {
                        showPreview('', '');
                        return;
                    }

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
