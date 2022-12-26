@extends('layouts.app')

@section('title')
    فرم ها
@endsection

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-header">
                
            </div>
            <div class="box-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        
                    </div>
                    <div class="panel-body">
                        <div>
                            <a href="{{Url('public/forms/sodur.pdf')}}">فرم صدور پروانه</a>
                        </div>
                        <div>
                            <a href="{{Url('public/forms/tamdid.pdf')}}">تمدید</a>
                        </div>
                        <div>
                            <a href="{{Url('public/forms/taqir-raste.pdf')}}">تغییر رسته</a>
                        </div>
                        <div>
                            <a href="{{Url('public/forms/taqir-neshani.pdf')}}">تغییر نشانی</a>
                        </div>
                        <div>
                            <a href="{{Url('public/forms/taviz.pdf')}}">تعویض از همگن به اتحادیه کشوری</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

