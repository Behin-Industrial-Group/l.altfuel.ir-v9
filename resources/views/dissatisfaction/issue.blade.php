@extends('layout.welcome_layout')

@section('title')
    ثبت عدم رضایت از پاسخگویی تلفن ها
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
                    
                    <div class="alert alert-warning">
                        <p style="font-size:20px">
                            به سوالهای نادقیق و مبهم و مواردی که قبلا  در پرسش های متداول پاسخ داده شده اند، پاسخ مجدد داده  نخواهد شد. لطفا قبلا پرسش های متداول را مطالعه کنید.
                        </p>
                    </div>
                    <form action="{{Url('dissatisfaction')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-4 control-lable">
                                نام و نام خانوادگی:
                            </label>
                            <input type="text" name="name" class="col-sm-8 form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-lable">
                                شماره ای که با آن با اتحادیه تماس گرفتید: 
                            </label>
                            <input type="text" name="cellphone" id="cellphone" class="col-sm-8 form-control" onkeyup="checkIsNumber('cellphone')" required>
                            <p id="cellphone_error"></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-lable">
                                توضیحات: (با کدام بخش تماس گرفتید؟ و جزئیات موضوع)
                            </label>
                            <textarea name="issue" rows="5" class="col-sm-8 form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-lable"></label>
                            <div class="g-recaptcha col-sm-8" name='recaptcha' id="recaptcha" data-sitekey="6Le-1VsUAAAAAIjZ05uH3BWml41aP7PBQmNGCh3X"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4"></label>
                            <input type="submit" class="btn btn-success" id="send" value="ارسال">
                        </div>
                    </form>
                </div>
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