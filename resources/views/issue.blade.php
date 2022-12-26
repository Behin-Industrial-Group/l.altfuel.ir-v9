@extends('layout.welcome_layout')

@section('title')
    ثبت تیکت اتحادیه کشوری سوخت های جایگزین
@endsection

@section('CustomeCss')
    #lightbox {
      display: none;
      position: fixed;
      z-index: 100;
      height: 100vh;
      overflow: auto;
      background-color: rgba(76, 175, 80, 0.1);
    }
    
    /* Modal Content */
    #ligthboxcontent {
      position: relative;
      top: 20vh;
      padding: 100px;
      color:white;
      background-color: rgba(76, 175, 80);
    }
    #close {
      color: red;
      position: absolute;
      top: 10px;
      right: 25px;
      font-size: 35px;
      font-weight: bold;
    }
@endsection

@section('content')
    <script>
        function showlightbox(){
            document.getElementById("lightbox").style.display = "block";
        }
        function closelightbox(){
            document.getElementById("lightbox").style.display = "none";
        }
    </script>
    <div class="row">
        <div class="box">
            <div class="box-header">
                @if (!empty($message))
                    <div class='alert alert-success'>
                        {{ $message }}
                    </div>
                @endif
                @if (!empty($error))
                    <div class='alert alert-danger'>
                        {{ $error }}
                    </div>
                @endif
            </div>
            <div class="box-body" style="background-color: rgba(0, 0, 100, 0.1)">
                <div class="col-sm-8 col-sm-offset-2">
                    
                    @if(!isset($catagory))
                        
                    @endif
                    
                    @include('includes.answer-link')
                    <div class="alert alert-warning">
                        <p style="font-size:20px">
                            به سوالهای نادقیق و مبهم و مواردی که قبلا  در پرسش های متداول پاسخ داده شده اند، پاسخ مجدد داده  نخواهد شد. لطفا قبلا پرسش های متداول را مطالعه کنید.
                        </p>
                    </div>
                    <form action="javascript:void(0)" id="form" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                            @if(isset($catagories))
                                <div class="form-group">
                                    <label class="col-sm-4 control-lable">
                                        با کدام بخش کار دارید؟ انتخاب کنید
                                    </label>
                                    <select name="catagory" class="col-sm-4" dir="rtl" style="border: 1px solid" required>
                                        @foreach( $catagories as $catagory )
                                            <option value="{{ $catagory->name }}">{{ $catagory->fa_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-lable">
                                        نام و نام خانوادگی:
                                    </label>
                                    <input type="text" name="name" class="col-sm-8 form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-lable">
                                        کد ملی:
                                    </label>
                                    <input type="text" name="NationalID" id="NationalID" class="col-sm-8 form-control" onkeyup="checkIsNumber('NationalID')" placeholder="کد ملی خود را با اعداد انگلیسی وارد کنید" required>
                                    <p id="NationalID_error"></p>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-lable">
                                        شماره موبایل:
                                    </label>
                                    <input type="text" name="cellphone" id="cellphone" class="col-sm-6 form-control" onkeyup="checkIsNumber('cellphone')" placeholder="با اعداد انگلیسی وارد کنید: 09121234567" required>
                                    {{-- <span class="btn btn-danger" id="send_code">ارسال کد تایید <i class="fa fa-spinner fa-spin"></i></span> --}}
                                    <p id="cellphone_error"></p>
                                </div>
                                {{-- <div class="form-group">
                                    <label class="col-sm-4" id="mv_code_label">کد تایید پیامک شده</label>
                                    <input type="text" id="mv_code" name="mv_code" class="col-sm-4 form-control"/>
                                </div> --}}
                                <div class="form-group">
                                    <label class="col-sm-4 control-lable">
                                        پیام:
                                    </label>
                                    <textarea name="issue" rows="5" class="col-sm-8 form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-lable">
                                        آپلود تصویر:  
                                        (حجم فایل کمتر از 300 کیلوبایت و فقط فرمت های jpg,png,jpeg)
                                    </label>
                                    <input type="file" name="issue_file" class="col-sm-8 form-control">
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-4 control-lable">من ربات نیستم</label>
                                    <div class="g-recaptcha col-sm-8" name='recaptcha' id="recaptcha" data-sitekey="6Le-1VsUAAAAAIjZ05uH3BWml41aP7PBQmNGCh3X"></div>
                                </div>

                                <div class="form-group" id="submit" >
                                    <label class="col-sm-4"></label>
                                    <button class="btn btn-success" id="send">ثبت تیکت <i class="fa fa-spinner fa-spin"></i></button>
                                </div>
                            @else
                                <div class="form-group">
                                    <label class="col-sm-4 control-lable">
                                        با کدام بخش کار دارید؟ انتخاب کنید
                                    </label>
                                    <a href="{{url('issues/License')}}">
                                        <div class="alert alert-info col-sm-4">
                                            امور مربوط به پروانه کسب(مراکز)
                                        </div>
                                    </a>
                                    <a href="{{url('issues/irngv')}}">
                                        <div class="alert alert-info col-sm-4">
                                            امور مربوط به سامانه irngv
                                        </div>
                                    </a>
                                </div>
                            @endif
                    </form>
                    
                </div>
                
                <!-- 
                <div id="lightbox" class="lightbox col-sm-12" data-spy="affix" data-offset-top="197">
                    <div id="ligthboxcontent" class="col-sm-6 col-sm-offset-3">
                        <span id="close" class="close cursor" onclick="closelightbox()">&times;</span>
                        <p style="font-size:20px">
                            به سوالهای نادقیق و مبهم و مواردی که قبلا  در پرسش های متداول پاسخ داده شده اند، پاسخ مجدد داده  نخواهد شد. لطفا قبلا پرسش های متداول را مطالعه کنید.
                        </p>
                    </div>
                </div>
                -->
                
                <script>
                    hide_loading();
                    function hide_loading(){
                        $('.fa-spinner').hide()
                    }
                    function show_loading(){
                        $('.fa-spinner').show()
                    }

                    function checkIsNumber(id){
                        var input = document.getElementById(id);
                        var show_error = document.getElementById(id + '_error')
                        var l = input.value.length;
                        var a = input.value;
                        if(isNaN(a)){
                            input.style.border = '1px solid red';
                            input.value = '';
                            show_error.innerHTML = "<span style='color:red'>عدد انگلیسی وارد کنید</span>";
                            document.getElementById('recaptcha').style.display = 'none';
                            document.getElementById('send').style.display = 'none';
                        }else{
                            input.style.border = '1px solid green';
                            document.getElementById('recaptcha').style.display = 'block';
                            document.getElementById('send').style.display = 'block';
                        }
                    }
                </script>
                
                <script>
                    function goToIssues(){
                        window.location.replace("http://l.altfuel.ir/issues/License");
                    }
                </script>

                <script>
                    $('#send_code').on('click', function(){
                        show_loading();
                        var s = $('input[name=_token]').val();
                        var m = $('input[name=cellphone]').val();
                        $.ajax({
                            type: 'post',
                            url: '{{url('mv/send-code')}}',
                            data: {to: m, _token: s},
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data){
                                if(data === 'ok'){
                                    alert('لطفا کد پیامک شده را داخل کادر مربوطه وارد کنید')
                                    hide_loading();
                                }else{
                                    alert(data);
                                    hide_loading()
                                }
                            },
                            error: function(){
                                alert('تعداد درخواست ها از حد مجاز بیشتر است. لطفا دقایقی را صبر کنید'); 
                                hide_loading();
                            }
                        })
                    })
                </script>

                <script>
                    $('#send').on('click',function(){
                        show_loading();
                        var fd = $('form').serialize();
                        var form = document.querySelector("form");
                        var formData = new FormData(form);
                        formData.append('_token','{{csrf_token()}}');
                        
                        $.ajax({
                            type: 'post',
                            url: '{{url('issues')}}',
                            processData: false,
                            contentType: false,
                            data:  formData,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success:function(data){
                                if(data != 'ok'){
                                    alert(data);
                                    hide_loading();
                                }else{
                                    alert('تیکت ثبت شد.');
                                    $('form').trigger("reset");
                                    window.location = "{{url('issues')}}";
                                }
                            },
                            error:function(){
                                alert('تعداد درخواست ها بیش از حد مجاز است. لطفا حداقل 30 ثانیه صبر کنید');
                                hide_loading();
                            }
                        })
                    })
                </script>
                
                
            </div>
        </div>
    </div>
@endsection