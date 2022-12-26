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
        </div>
    </div>
@endsection