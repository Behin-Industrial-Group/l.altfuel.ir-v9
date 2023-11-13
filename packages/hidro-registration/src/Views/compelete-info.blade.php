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
                    @foreach (array_keys($agency) as $key)
                        {{ __($key) }}
                        <input type="text" name="{{$key}}" id="" value="{{$agency[$key]}}" class="form-control" readonly>
                    @endforeach
                    کدملی مدیرعامل: 
                    <input type="text" name="NationalID" id="" class="form-control">

                    نام و نام خانوادگی مدیرعامل:
                    <input type="text" name="Name" id="" class="form-control">

                    موبایل:
                    <input type="text" name="Cellphone" id="" class="form-control">

                    استان:
                    <input type="text" name="Province" id="" class="form-control">

                    شهر:
                    <input type="text" name="City" id="" class="form-control">

                    شماره گواهی تاييد صلاحيت آزمایشگاه (اخذ شده از سازمان ملی استاندارد):
                    <input type="text" name="standardCertificateNumber" id="" class="form-control">

                    تاریخ اعتبار گواهی:
                    <input type="text" name="standardCertificateExpDate" id="" class="form-control persian-date">

                </form>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary col-sm-12" onclick="submit()">ثبت و پرداخت</button>
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
                "{{ route('hidroReg.pay') }}",
                fd,
                function(res){
                    show_message("{{__('Waiting...')}}");
                    window.location = res;
                }
            )
        }
        initial_view()
    </script>
   
@endsection
