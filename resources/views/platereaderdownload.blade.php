@extends('layout.welcome_layout')

@section('title')
    دانلود نرم افزار پلاک خوان
@endsection


@section('content')
    <div class="row">
        <div class="box">
            <div class="box-header">
                @if(!empty($error))
                    <div class="alert alert-danger">
                        {{$error}}
                    </div>
                @endif
            </div>
            <div class="box-body">
                <div class="col-sm-6 col-sm-offset-3">
                    <form class="form-horizontal" method="post" action="/platereaderdownload">
                        @csrf
                        <div class="from-group">
                            <lable class="col-sm-3">
                                کد کارگاه: 
                            </lable>
                            <input type="text" name="CodeEtehadie">
                        </div>
                        <div class="from-group">
                            <lable class="col-sm-3">
                                شماره صنفی: 
                            </lable>
                            <input type="text" name="GuildNumber">
                        </div>
                        <input type="submit" class="btn btn-info" value="بررسی">
                    </form>
                </div>
                <div class="col-sm-6">
                    <div>
                        <p>
                            <a href="http://l.altfuel.ir/public/uploads/platereader/PlateReader.exe.config">دانلود اصلاحیه شماره 21-03-99</a>
                            <p>
                                توضیحات: فایل اصلاحیه را دانلود و در محل نصب برنامه پلاک خوان کپی کنید.
                            </p>
                        </p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
