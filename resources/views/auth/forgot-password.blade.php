@extends('layouts.welcome')

@section('content')
<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <img src="https://altfuel.ir/fa/public/logo.png" class="col-sm-12" alt="">
        </div>
        <div class="card-body">
            <form action="javascript:void(0)" method="post" id="reset-pass-form">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="mobile" placeholder="موبایل">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-phone"></span>
                        </div>
                    </div>
                </div>
                <div class="col-12" id="send-code-btn">
                    <button type="submit" class="btn btn-primary col-sm-12" onclick="send_code()">ارسال کد</button>
                </div>
                <div class="input-group mb-3" style="display: none" id="code-input">
                    <input type="text" class="form-control" name="reset_code" placeholder="کدپیامک شده">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-check"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3" style="display: none" id="pass-input">
                    <input type="password" class="form-control" name="password" placeholder="رمز جدید">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-lock"></span>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-12" style="display: none" id="submit-btn">
                <button type="submit" class="btn btn-primary col-sm-12" onclick="submit()">تغییر رمز</button>
            </div>
            <hr>
            <div class="center-align" style="text-align: center">
                <a href="{{ route('login') }}" class="text-center">صفحه ورود</a>
            </div>
            <hr>
            <div class="center-align" style="text-align: center">
                <a href="{{ route('register') }}" class="text-center">صفحه ثبت نام</a>
            </div>
        </div>

    </div>
</div>

@endsection

@section('script')
    <script>
        function send_code(){
            send_ajax_request(
                "{{ route('password.sendCode') }}",
                $('#reset-pass-form').serialize(),
                function(response){
                    show_message("کد تایید پیامک شد");
                    $('#send-code-btn').hide();
                    $('#code-input').show();
                    $('#pass-input').show();
                    $('#submit-btn').show();
                },
                function(response){
                    show_error(response)
                }
            )
        }
        function submit() {
            send_ajax_request(
                "{{ route('password.update') }}",
                $('#reset-pass-form').serialize(),
                function(response) {
                    show_message("به صفحه داشبورد منتقل میشوید")
                    window.location = "{{ url('admin') }}"
                },
                function(response) {
                    // console.log(response);
                    show_error(response)
                    hide_loading();
                }
            )
        }
    </script>
@endsection
