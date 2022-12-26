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
                                </h2>
                            </div>
                            <!-- /.col -->
                        </div>
                
                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-xs-6">
                                <alert class="alert alert-success text-muted">
                                    پرداخت با موفقیت انجام شد
                                </alert>
                            </div>
                            <div class="col-xs-6">
                                <div class="table-responsive">
                                    <div class="">
                                        <p>
                                            جهت تکمیل ثبت نام و پرداخت وجه با شماره های زیر تماس حاصل فرمایید:
                                        </p>
                                        <p>
                                            آقای یوسفی ۰۹۱۲۶۱۳۶۲۸۲
                                        </p>
                                        <p>
                                            آقای قشونی ۰۹۱۲۳۹۷۸۷۲۷
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection