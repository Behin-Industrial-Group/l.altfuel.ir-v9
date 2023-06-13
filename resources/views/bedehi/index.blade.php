@extends('layout.welcome_layout')


@section('content')
    <div class="col-sm-4"></div>
    <div class="col-sm-4" align='center' style="margin: 15% 0 0 0; background: white">
        <form method="POST" action="javascript:void(0)" style="margin: 50px" id="bedehi-form">
            @csrf
            <table class="table table-striped table-bordered">
                <tr>
                    <td class="col-sm-3">
                        <label for="" class="">نوع مرکز</label>
                    </td>
                    <td class="col-sm-9">
                        <input type="radio" name="type" value="agency" id="">مرکز خدمات فنی <br>
                        <input type="radio" name="type" value="kamfeshar" id="" >مرکز کم فشار<br>
                        <input type="radio" name="type" value="hidro" id="" >ازمایشگاه هیدرو استاتیک
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
                if(value == 'kamfeshar'){
                    code_label.html('شماره صنفی پروانه کسب ')
                }
                if(value == 'hidro'){
                    code_label.html('کد 5 رقمی آزمایشگاه هیدرواستاتیک')
                }
            })
        </script>
        <script>
            function submit_form(){
                const form = $('#bedehi-form')[0];
                var fd = new FormData(form);
                $.ajax({
                    type: 'post',
                    url: '{{ route("confirm-bedehi") }}',
                    processData: false,
                    contentType: false,
                    data:  fd,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data){
                        console.log(data);
                        show_success(data.msg);
                        location.href = data.url
                    },
                    error: function (data) {
                        console.log(data);
                        show_error(data.responseText)
                    }
                })
            }
        </script>
    </div>
@endsection