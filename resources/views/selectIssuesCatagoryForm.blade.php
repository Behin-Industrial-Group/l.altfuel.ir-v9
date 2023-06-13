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
                            show_error.innerHTML = a;
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
                
                
            </div>
        </div>
    </div>
@endsection