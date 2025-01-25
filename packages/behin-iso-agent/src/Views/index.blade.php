@extends('layouts.app')

@section('content')
    <div id="chat-interface" class="container pt-5">
        <h2 class="text-center mb-4">دستیار ایزو</h2>
        <div id="chat-container" class="card shadow">
            <div id="messages" class="card-body overflow-auto p-3" style="height: 300px; overflow-y: auto;">
                <!-- پیام‌ها در اینجا نمایش داده می‌شوند -->
                @foreach ($messages as $message)
                    <div class="alert alert-primary">{{ $message->message }}</div>
                    <div class="alert alert-warning">{{ $message->response }}</div>
                @endforeach
            </div>
            <div class="card-footer">
                <form id="chat-form" class="d-flex">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="text" name="message" id="message" class="form-control me-2"
                        placeholder="پیام خود را وارد کنید..." required>
                    <button id="submit-btn" onclick="callLangflow()" class="btn btn-primary">ارسال</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function callLangflow() {

            let f = new FormData($('#chat-form')[0]);
            send_ajax_formdata_request(
                "{{ route('isoAgent.sendMessage') }}",
                f,
                function(response) {

                    // افزودن پیام کاربر
                    var userMessageElement = document.createElement('div');
                    userMessageElement.className = 'alert alert-primary';
                    userMessageElement.textContent = message;
                    messagesContainer.appendChild(userMessageElement);

                    // پاک کردن ورودی کاربر
                    document.getElementById('message').value = '';

                    // شبیه‌سازی پاسخ بات
                    var botResponseElement = document.createElement('div');
                    botResponseElement.className = 'alert alert-warning mt-2';
                    botResponseElement.textContent = response.response;
                    messagesContainer.appendChild(botResponseElement);

                    console.log(response);
                },
                function(data) {
                    show_error(data);
                    console.log(data);
                }
            )


            // اسکرول به پایین
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    </script>
    <script>
        document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
    </script>
@endsection
