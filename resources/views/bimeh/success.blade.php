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
                            <!-- accepted payments column -->
                            <div class="col-xs-6">
                                <div class="alert alert-success text-muted">
                                    پرداخت با موفقیت انجام شد<br>
                                    بروزرسانی اطلاعات مالی در سایت چند روزی زمانبر خواهد بود. لطفا شکیبا باشید.
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                          <tr>
                                            <th style="width:50%">کد کارگاه: </th>
                                            <td>{{ $successfulPayInfo['codeEtehadie'] }} </td>
                                          </tr>
                                          <tr>
                                            <th style="width:50%">مبلغ پرداختی: </th>
                                            <td>{{ $successfulPayInfo['price'] }} تومان</td>
                                          </tr>
                                          <tr>
                                            <th style="width:50%">شماره پیگیری: </th>
                                            <td>{{ $successfulPayInfo['RefID'] }}</td>
                                          </tr>
                                          <tr>
                                            <th>تاریخ پرداخت: </th>
                                            <td>{{ $successfulPayInfo['date'] }}</td>
                                          </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection