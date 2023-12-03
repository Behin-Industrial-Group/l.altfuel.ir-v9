@extends('layouts.welcome')


@section('content')
    <div class="register-box card" id="body">
        {{-- <h3>
            با عرض پوزش لینک پرداخت بدهی موقتا غیرفعال است.

        </h3> --}}
        <form method="POST" action="javascript:void(0)" style="margin: 5px" id="bedehi-form">
            @csrf
            <table class="table table-striped table-bordered">
                <tr>
                    <td class="col-sm-3">
                        <label for="" class="">نوع مرکز</label>
                    </td>
                    <td class="col-sm-9">
                        @foreach (config('agency_info.customer_type') as $key => $value)
                            <input type="radio" name="type" value="{{$key}}" id="">{{__($key)}}<br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3">
                        <label for="" class="">کدملی</label>
                    </td>
                    <td class="col-sm-9">
                        <input type="text" class="form-control" name="nid" />
                        کدملی صاحب امتیاز مرکز وارد شود
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3">
                        <label for="" class="">شماره موبایل</label>
                    </td>
                    <td class="col-sm-9">
                        <input type="text" class="form-control" name="mobile" />
                        شماره موبایلی که برای آن پیامک بدهی ارسال شده وارد کنید
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3">
                        <label for="" id="code_label" class=""></label>
                    </td>
                    <td class="col-sm-9">
                        <input type="text" class="form-control" name="code" />
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3"></td>
                    <td class="col-sm-9">
                        <input type="submit" class="btn btn-success" onclick="submit_form()" value="بررسی میزان بدهی" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div>
        <script>
            const type_input = $('input[name="type"]');
            type_input.click(function () {
                var value = $(this).val();
                const code_label = $('#code_label');
                if(value == 'agency'){
                    code_label.html('کد 5 رقمی مرکز خدمات فنی')
                }
                if(value == 'low-pressure'){
                    code_label.html('شماره صنفی پروانه کسب ')
                }
                if(value == 'hidrostatic'){
                    code_label.html('کد 7 رقمی آزمایشگاه هیدرواستاتیک')
                }
            })
        </script>
        <script>
            function submit_form(){
                const form = $('#bedehi-form')[0];
                var fd = new FormData(form);
                send_ajax_formdata_request(
                    '{{ route("confirmForm") }}',
                    fd,
                    function(data){
                        console.log(data);
                        $('#body').html(data)
                        // location.href = data.url
                    }
                )
            }
        </script>
    </div>
@endsection