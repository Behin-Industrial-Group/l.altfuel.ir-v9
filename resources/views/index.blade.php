@extends('layout.welcome_layout')

@section('content')
<div class="login-box">
    <div class="login-logo">
            <img src="public/lte-theme/dist/img/LOGO9.png" width="300px">
        
      <a href=""><h2>خرید برچسب سوخت گیری </h2></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">فرم زیر را تکمیل کنید و ادامه را بزنید</p>
      <div>
      </div>
      <form action="shopinglable" method="POST">
          @csrf
          <div class="form-group has-feedback">
              <div class="form-group">
                  <label>نام مدیر مرکز</label>
                  <select class="form-control select2" style="width: 100%;" name='name'>
                        @foreach ($marakez as $markaz)
                            <option>
                                {{ $markaz->Name }}
                            </option>
                        @endforeach
                  </select>
              </div>
          </div>
          <div class="form-group has-feedback">
              <div class="form-group">
                  <label>کدمرکز</label>
                  <select class="form-control select2" style="width: 100%;" name='code'>
                        @foreach ($marakez as $markaz)
                            <option>
                                {{ $markaz->CodeEtehadie }}
                            </option>
                        @endforeach
                  </select>
              </div>
          </div>
          <div class="form-group has-feedback">
              <div class="form-group">
                  <label>شماره موبایل</label>
                  <input type="number" class="form-control" id="" name="Mobile" required>
              </div>
          </div>
          <div class="form-group has-feedback">
              <div class="form-group">
                  <label>ظرفیت</label>
                  <select class="form-control select2" style="width: 100%;" name='package'>
                        <option value='0.5'>250 تایی</option>
                        <option value='1'>500 تایی</option>
                        <option value='2'>1000 تایی</option>
                  </select>
              </div>
          </div>
          
        <div class="row">
          <!-- /.col -->
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">ادامه</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
  
    </div>
    <!-- /.login-box-body -->
  </div>
@endsection