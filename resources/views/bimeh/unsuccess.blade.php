@extends('layout.welcome_layout')

@section('title')
    خرید بیمه اتحادیه کشوری سوخت های جایگزین و خدمات وابسته
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="box box-info">
                <div class="box-body">
                    <section class="invoice">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-xs-12">
                                <h2 class="page-header">
                                <i class="fa fa-globe"></i> اتحادیه کشوری سوخت های جایگزین و خدمات وابسته
                                <small class="pull-left"></small>
                                </h2>
                            </div>
                            <!-- /.col -->
                        </div>
                
                        <div class="row">
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                        </div>
                        
                        <div class="row">
                                <a href="{{ Url('/bimeh') }}">
                                    <button class="btn btn-info">بازگشت</button>
                                </a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection