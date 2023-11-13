@extends('layouts.welcome')

@section('content')
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="https://altfuel.ir/fa/public/logo.png" class="col-sm-12" alt="">
            </div>
            <div class="card-body">
                <h5 style="text-align: center">
                    تکمیل ثبت نام مرکز هیدرو استاتیک
                </h5><hr>
                <form action="javascript:void(0)" method="post" id="register-form">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="simfaCode" placeholder="کد سیمفا">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-phone"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="legalNationalId" placeholder="شناسه ملی شرکت">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary col-sm-12" onclick="submit()">ورود</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        function submit(){
            var fd = new FormData($('#register-form')[0]);
            send_ajax_formdata_request(
                "{{ route('hidroReg.compeleteInfoForm') }}",
                fd,
                function(res){
                    console.log(res);
                    document.write(res);
                }
            )
        }
    </script>
@endsection
