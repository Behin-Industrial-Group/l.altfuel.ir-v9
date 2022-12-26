@extends('layout.welcome_layout')

@section('title')
    ثبت نام دوره آموزشی همایش یکم تیرماه
@endsection

@section('content')
    <div class="col-sm-12">
        <form action="javascript:void(0)" id="register_workshop_form">
            @csrf
        <span style="color: red; ">
            اولویت با پرسنل مراکز خدمات دارای پروانه کسب می باشد.
        </span><br>
        <span style="color: red">
            دقت فرمایید در کلاس هایی که  بطور همزمان برگزار می شود ثبت نام نکنید
        </span>
        <table class="table table-stripped">
            <tr>
                <td>نام دوره آموزشی</td>
                <td>
                    <select name="workshop_name" id="" class="form-control select2" dir="rtl">
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">
                                {{ $class->title }} -
                                @if ($class->day == 2)
                                    پنج شنبه دوم تیرماه
                                @elseif($class->day == 3)
                                    جمعه سوم تیرماه
                                @endif
                                -
                                {{ $class->time }}
                                الی 
                                {{ $class->end_time}}
                                -
                                مدرس: 
                                {{ $class->teacher}}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>نام و نام خانوادگی</td>
                <td>
                    <input type="text" name="name" id="" class="form-control">
                </td>
            </tr>
            <tr>
                <td>کدملی</td>
                <td>
                    <input type="text" name="national_id" id="" class="form-control">
                </td>
            </tr>
            <tr>
                <td>شماره موبایل</td>
                <td>
                    <input type="text" name="mobile" id="" class="form-control">
                </td>
            </tr>
            <tr>
                <td>استان</td>
                <td>
                    <select name="province" id="" class="form-control select2" dir="rtl">
                        @foreach ($provinces as $p)
                            <option value="{{ $p->Name }}">{{ $p->Name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="radio" name="type" id="" value="agency">مرکز خدمات فنی <br>
                    <input type="radio" name="type" id="" value="hidro">آزمایشگاه هیدرواستاتیک <br>
                    <input type="radio" name="type" id="" value="other">سایر<br>
                </td>
                <td>
                    <input type="text" name="type_des" id="type_des" class="form-control">
                </td>
            </tr>
            <tr>
                <td>
                    <button class="btn btn-info" onclick="register_workshop()">ثبت نام <i class="fa fa-spinner fa-spin"></i></button>
                </td>
            </tr>
        </table>
        </form>

        <script>
            hide_loading();
            function hide_loading(){
                $('.fa-spinner').hide()
            }
            function show_loading(){
                $('.fa-spinner').show()
            }

            $('input[name="type"]').change(function(){
                var type_des = $('#type_des');
                if($(this).val() == 'agency'){
                    type_des.attr('placeholder', 'کد مرکز خدمات را وارد کنید')
                }
                if($(this).val() == 'hidro'){
                    type_des.attr('placeholder', 'کد آزمایشگاه هیدرواستاتیک را وارد کنید')                }
                if($(this).val() == 'other'){
                    type_des.attr('placeholder', 'نام شرکت یا سازمان خود را وارد کنید')
                }
            })

            function register_workshop(){
                show_loading();
                var form = document.querySelector("#register_workshop_form");
                var formData = new FormData(form);
                formData.append('_token','{{csrf_token()}}');
                
                $.ajax({
                    type: 'post',
                    url: '{{ route("register_workshop") }}',
                    processData: false,
                    contentType: false,
                    data:  formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(data){
                        alert(data);
                        console.log(data);
                        hide_loading();
                    },
                    error:function(data){
                        alert(data.responseJSON.message);
                        console.log(data);
                        hide_loading();
                    }
                })
            }
        </script>
    </div>
@endsection