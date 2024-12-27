@extends('layouts.app')

@php
    use Behin\Hamayesh\Http\EventEnum as EventEnum;
@endphp

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">پذیرش رویداد {{ EventEnum::Title[$eventId] }} شماره {{ $eventId }}</div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="javascript:void(0)" id="sms-form" method="POST">
                @csrf
                <div class="form-group p-0 mb-0">
                    <label for="national_code mb-0" style="margin-bottom: 0 ! important">متن پیامک</label>
                    <textarea name="message" id="message" class="form-control" rows="10"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100" onclick="sendSms()">ارسال</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        function sendSms(){
            var form = $('#sms-form')[0];
            var formData = new FormData(form);
            send_ajax_formdata_request(
                "{{ route('event-verification.sms', $eventId) }}",
                formData,
                function(response) {
                    show_message(response.message)
                    console.log(response);
                    $('#qr_code').val('');
                    $('#national_code').val('');
                    $('#national_code2').val('');
                    $('#first_name').val('');
                    $('#last_name').val('');
                    $('#mobile').val('');
                    // location.reload()
                },
                function(error) {
                    show_error(error)
                    console.log(error);
                    $('#qr_code').val('');
                    $('#national_code').val('');
                    $('#national_code2').val('');
                    $('#first_name').val('');
                    $('#last_name').val('');
                    $('#mobile').val('');
                }
            )
        }
        function register(){
            var form = $('#register-form')[0];
            var formData = new FormData(form);
            send_ajax_formdata_request(
                "{{ route('event-verification.register', $eventId) }}",
                formData,
                function(response) {
                    show_message(response.message)
                    console.log(response);
                    $('#qr_code').val('');
                    $('#national_code').val('');
                    $('#national_code2').val('');
                    $('#first_name').val('');
                    $('#last_name').val('');
                    $('#mobile').val('');
                    
                    // location.reload()
                },
                function(error) {
                    show_error(error)
                    console.log(error);
                    $('#qr_code').val('');
                    $('#national_code').val('');
                    $('#national_code2').val('');
                    $('#first_name').val('');
                    $('#last_name').val('');
                    $('#mobile').val('');
                }
            )
        }
    </script>