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
                            <div class="col-xs-6 col-xs-offset-3">
                                @if( isset( $error ) )
                                    <div class="alert alert-danger">
                                        {{ $error }}
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <form method="post" action="{{ Url( 'takmili/login' ) }}">
                                        @csrf
                                        <div class="form-group">
                                            <label>
                                                نام کاربری:
                                            </label>
                                            <input type="text" name="username" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                رمز عبور: 
                                            </label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit"  class="btn btn-success" value="ورود">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection