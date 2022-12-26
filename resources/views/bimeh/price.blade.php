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
                
                        <!-- Table row -->
                        <div class="row">
                            <div class="col-xs-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>تعداد</th>
                                            <th>محصول</th>
                                            <th>شماره همراه</th>
                                            <th>توضیحات</th>
                                            <th>قیمت کل (تومان)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                          <td>{{ $paymentInfo['number'] }}</td>
                                          <td>{{ $paymentInfo['productName'] }}</td>
                                          <td>{{ $paymentInfo['mobile'] }}</td>
                                          <td>کدکارگاه: {{ $paymentInfo['purchaser'] }}</td>
                                          <td>{{ $paymentInfo['price'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                
                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-xs-6">
                                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                    پرداخت از طریق کلیه کارت های بانکی عضو شتاب امکان پذیر می باشد.
                                </p>
                            </div>
                            <div class="col-xs-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody><tr>
                                            <th style="width:50%">مبلغ کل:</th>
                                            <td>{{ $paymentInfo['price'] }} تومان</td>
                                          </tr>
                                          <tr>
                                            <th>تخفیف</th>
                                            <td></td>
                                          </tr>
                                          <tr>
                                            <th>مبلغ قابل پرداخت:</th>
                                            <td>{{ $paymentInfo['price'] }} تومان</td>
                                          </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                      </div>
                
                      <!-- this row will not appear when printing -->
                      <div class="row no-print">
                        <div class="col-xs-12">
                            <form method="post" action="{{ Url('/bimeh/pay') }}">
                                @csrf
                                <input type="hidden" name="amount" value="{{ $paymentInfo['price'] }}">
                                <input type="hidden" name="description" value="{{ $paymentInfo['description'] }}">
                                <input type="hidden" name="mobile" value="{{ $paymentInfo['mobile'] }}">
                                <input type="hidden" name="callbackUrl" value="
                                    <?php 
                                    echo Url("/bimeh/success/".$paymentInfo['purchaser']. "/" .$paymentInfo['price'] . "/" . $paymentInfo['productType'] . "/" . $paymentInfo['number']  ."") 
                                    ?>
                                    ">
                                <input type="submit" class="btn btn-success" value="تایید و پرداخت">
                            </form>
                        </div>
                      </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection