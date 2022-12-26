@extends('layout.welcome_layout')

@section('title')
    خرید بیمه اتحادیه کشوری سوخت های جایگزین و خدمات وابسته
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="box box-info">
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                            <i class="fa fa-globe"></i> اتحادیه کشوری سوخت های جایگزین و خدمات وابسته
                            <small class="pull-left"></small>
                            </h2>
                        </div>
                        <!-- /.col -->
                    </div>
                    <form class="form-horizontal" method="post" action="{{ Url('/bimeh') }}">
                        @csrf
                        <div class="form-group col-sm-12" style="width:100%">
                            <label>
                                
                            </label>
                            <select class="select2 form-control" name="CodeEtehadie" dir="rtl">
                                @foreach( $marakez as $markaz )
                                <option value="{{ $markaz->CodeEtehadie }}">{{ $markaz->CodeEtehadie }} - {{ $markaz->Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-12" style="width:100%">
                            <label>
                                
                            </label>
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                              </div>
                              <input type="text" class="form-control" name="mobile" required>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>
                                نوع بیمه: 
                            </label>
                            <div class="col-sm-12">
                                <input type="radio" name="insType" value="2" class="form-control" required> 
                                <label>
                                    بیمه مسولیت و تضمین کیفیت
                                </label>
                            </div>
                            <div class="col-sm-12">
                                <input type="radio" name="insType" value="1" class="form-control">
                                <label>
                                    فقط بیمه مسولیت
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>
                                تعداد بیمه:
                            </label>
                            <select class="select2 form-control" name="number" dir="rtl">
                                <option value="1">25</option>
                                <option value="2">50</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12">
                            <input type="submit" class="btn btn-info" value="محاسبه">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection