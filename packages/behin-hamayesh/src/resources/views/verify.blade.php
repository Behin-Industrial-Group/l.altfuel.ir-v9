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

            <form action="javascript:void(0)" id="verify-form" method="POST">
                @csrf
                <div class="form-group">
                    @include('QrCodeView::qr-code-input')
                    <button type="submit" class="btn btn-primary w-100" onclick="verify()">پذیرش</button>
                </div>
                <div class="form-group p-0 mb-0">
                    <label for="national_code mb-0" style="margin-bottom: 0 ! important">National Code</label>
                    <input type="text" class="form-control" name="national_code" id="national_code">
                </div>
                <button type="submit" class="btn btn-primary w-100" onclick="verify()">پذیرش</button>
            </form>
        </div>
    </div>
    @if($eventId == 4)
        <div class="card mt-3">
            <div class="card-header">ثبت نام همایش</div>
            <div class="card-body">
                <form action="javascript:void(0)" id="register-form" method="POST">
                    @csrf
                    <div class="form-group p-0 mb-0">
                        <label for="national_code mb-0" style="margin-bottom: 0 ! important">نام</label>
                        <input type="text" class="form-control" name="first_name" id="first_name">
                    </div>
                    <div class="form-group p-0 mb-0">
                        <label for="national_code mb-0" style="margin-bottom: 0 ! important">نام خانوادگی</label>
                        <input type="text" class="form-control" name="last_name" id="last_name">
                    </div>
                    <div class="form-group p-0 mb-0">
                        <label for="national_code mb-0" style="margin-bottom: 0 ! important">کدملی</label>
                        <input type="text" class="form-control" name="national_code" id="national_code2">
                    </div>
                    <div class="form-group p-0 mb-0">
                        <label for="national_code mb-0" style="margin-bottom: 0 ! important">موبایل</label>
                        <input type="text" class="form-control" name="mobile" id="mobile">
                    </div>
                    <button type="submit" class="btn btn-primary w-100" onclick="register()">ثبت نام</button>
                </form>
            </div>
        </div>
    @endif
    <div class="card mt-3">

    </div>
</div>
@endsection

@push('scripts')
    <script>
        function verify(){
            var form = $('#verify-form')[0];
            var formData = new FormData(form);
            send_ajax_formdata_request(
                "{{ route('event-verification.verify', $eventId) }}",
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