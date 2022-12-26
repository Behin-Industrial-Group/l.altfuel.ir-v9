@extends('layout.welcome_layout')

@section('title')
    مشاهده پاسخ تیکت های ثبت شده
@endsection

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-header">
                @if (!empty($message))
                    <div class='alert alert-success'>
                        {{ $message }}
                    </div>
                @endif
                @if (!empty($Error))
                    <div class='alert alert-danger'>
                        {{ $Error }}
                    </div>
                @endif
            </div>
            <div class="box-body">
                <div class="col-sm-8 col-sm-offset-2">
                    <form action="{{Url('answer')}}" method="POST" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-4 control-lable">
                                کد ملی: (عدد انگلیسی وارد کنید)
                            </label>
                            <input type="text" name="NationalID" class="col-sm-8 form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-lable">
                                شماره موبایل: (عدد انگلیسی وارد کنید)
                            </label>
                            <input type="text" name="cellphone" class="col-sm-8 form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-lable"></label>
                            <div class="g-recaptcha col-sm-8" name='recaptcha' data-sitekey="6Le-1VsUAAAAAIjZ05uH3BWml41aP7PBQmNGCh3X"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4"></label>
                            <input type="submit" class="btn btn-success" value="ارسال">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection