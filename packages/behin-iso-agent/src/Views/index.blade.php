@extends('layouts.app')

@section('content')
    <div id="chat-interface" class="container pt-5">
        <h2 class="text-center mb-4">دستیار ایزو</h2>
        <div id="chat-container" class="card shadow">
            <div id="messages" class="card-body overflow-auto" style="height: 300px;">
                <!-- پیام‌ها در اینجا نمایش داده می‌شوند -->
                {{-- @foreach ($messages as $message)
                    <div class="alert alert-primary">{{ $message->message }}</div>
                    <div class="alert alert-warning">{{ $message->response }}</div>
                @endforeach --}}
            </div>
            <div class="card-footer">
                <form id="chat-form" class="d-flex">
                    <input type="text" id="user-message" class="form-control me-2" placeholder="پیام خود را وارد کنید..." required>
                    <button type="submit" id="send-button" class="btn btn-primary">ارسال</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();
            var message = document.getElementById('user-message').value;
            if (message.trim() !== '') {
                var messagesContainer = document.getElementById('messages');

                // افزودن پیام کاربر
                var userMessageElement = document.createElement('div');
                userMessageElement.className = 'alert alert-primary';
                userMessageElement.textContent = message;
                messagesContainer.appendChild(userMessageElement);

                // شبیه‌سازی پاسخ بات
                var botResponseElement = document.createElement('div');
                botResponseElement.className = 'alert alert-warning mt-2';
                botResponseElement.textContent = 'پاسخ بات به: ' + message;
                messagesContainer.appendChild(botResponseElement);

                // پاک کردن ورودی کاربر
                document.getElementById('user-message').value = '';

                // اسکرول به پایین
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        });
    </script>
@endsection
