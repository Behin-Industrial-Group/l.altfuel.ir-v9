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
                </h5>
                <hr>
                <form action="javascript:void(0)" method="post" id="register-form">
                    @csrf
                    <input type="text" name="parent_id" id="" value="{{$agency_fields->first()->parent_id}}">
                    {{__("simfa code")}}:
                    <input type="text" name="" class="form-control" id="" value="{{$agency_fields->where('key', 'simfa_code')->first()->value ?? ''}}" readonly>

                    {{__("firstname")}}:
                    <input type="text" name="" class="form-control" id="" value="{{$agency_fields->where('key', 'firstname')->first()->value ?? ''}}" readonly>

                    {{__("address")}}:
                    <input type="text" name="" class="form-control" id="" value="{{$agency_fields->where('key', 'address')->first()->value ?? ''}}" readonly>

                    {{__("postal code")}}:
                    <input type="text" name="" class="form-control" id="" value="{{$agency_fields->where('key', 'postal_code')->first()->value ?? ''}}" readonly>

                    {{__("legal national id")}}:
                    <input type="text" name="" class="form-control" id="" value="{{$agency_fields->where('key', 'legal_national_id')->first()->value ?? ''}}" readonly>

                    {{__("phone")}}:
                    <input type="text" name="" class="form-control" id="" value="{{$agency_fields->where('key', 'phone')->first()->value ?? ''}}" readonly>

                    کدملی مدیرعامل:
                    <input type="text" name="NationalID" id="" class="form-control">

                    نام و نام خانوادگی مدیرعامل:
                    <input type="text" name="Name" id="" class="form-control">

                    موبایل:
                    <input type="text" name="Cellphone" id="" class="form-control">

                    استان:
                    <select name="Province" class="form-control select2 col-sm-12" id="province"></select>
                    <script>
                        send_ajax_get_request(
                            "{{ route('city.all') }}",
                            function(res) {
                                selec_element = $('#province')
                                res.forEach(function(item) {
                                    var opt = new Option(item.province + ' - ' + item.city, item.id)
                                    selec_element.append(opt)
                                })
                            }
                        )
                    </script>

                    شماره گواهی تاييد صلاحيت آزمایشگاه (اخذ شده از سازمان ملی استاندارد):
                    <input type="text" name="standardCertificateNumber" id="" class="form-control">

                    تاریخ اعتبار گواهی:
                    <input type="text" name="standardCertificateExpDate" id=""
                        class="form-control persian-date">

                    مبلغ قابل پرداخت(ریال):
                    <input type="text" name="debt1" class="form-control" id="" value="{{$agency_fields->where('key', 'debt1')->first()->value ?? ''}}" readonly>

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
        function submit() {
            var fd = new FormData($('#register-form')[0]);
            send_ajax_formdata_request(
                "{{ route('hidroReg.pay') }}",
                fd,
                function(res) {
                    console.log(res);
                    show_message("{{ __('Waiting...') }}");
                    window.location = res;
                }
            )
        }
        initial_view()
    </script>
@endsection
