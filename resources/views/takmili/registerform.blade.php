@extends('layout.welcome_layout')

<!-- CSS only -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
  integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<!-- JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
  integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
  integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
  integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<!-- Form actions layout section start -->

@section('content')
  <section id="box">
    <div class="row text-right">
      <div class="col-sm-12">
        <div class="content-header"> فرم ثبت نام </div>
      </div>
    </div>
    <div class="box box-body text-right">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h4 class="card-title" id="from-actions-top-left">فرم خوداظهاری کارکنان جهت خرید بیمه مکمل درمان</h4>
            <div class="alert alert-info" role="alert">
              <strong>لطفا موارد زیر را با به طور کامل و دقیق وارد نمایید</strong>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (isset($_GET['message']))
                <div class="alert alert-danger">
                    <ul>
                        <li>{{ $_GET['message']}}</li>
                    </ul>
                </div>
            @endif

          </div>
          <div class="box-body">
            <div class="px-3">
              <form class="form" method="post" action="{{ Url('/takmili') }}">
                @csrf

                <div class="form-body">
                  <h4 class="form-section"><i class="ft-user"></i>اطلاعات مربوط به بیمه شده اصلی (سرپرست خانواده)</h4>
                  <div class="row">
                    <div class="form-group col-md-6 mb-2">
                      <label for="projectinput1">نام</label>
                      <input type="text" id="projectinput1" class="form-control" value="{{ old('fname') }}" required
                      placeholder="نام" name="fname">
                    </div>
                    <div class="form-group col-md-6 mb-2">
                      <label for="projectinput2">نام خانوادگی</label>
                      <input type="text" id="projectinput2" class="form-control" value="{{ old('lname') }}" required
                      placeholder="نام خانوادگی"
                        name="lname">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6 mb-2">
                      <label for="national_id">کدملی</label>
                      <input type="text" id="national_id" class="form-control" value="{{ old('national_id') }}" onkeyup="isValidIranianNationalCode('national_id')" required
                        placeholder="کدملی" name="national_id"
                        >
                        <p id="national_id_error"></p>
                    </div>
                    <div class="form-group col-md-6 mb-2">
                      <label for="birthCertificateNumber">شماره شناسنامه</label>
                      <input type="number" id="birthCertificateNumber" class="form-control" value="{{ old('birthCertificateNumber') }}" required
                        placeholder="شناسنامه" name="birthCertificateNumber"
                        >
                        <p id="national_id_error"></p>
                    </div>
                    <div class="form-group col-md-6 mb-2">
                      <label for="projectinput4">نام پدر</label>
                      <input type="text" id="projectinput4" class="form-control" value="{{ old('father') }}" required
                      placeholder="نام پدر" name="father">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6 mb-2">
                      <label for="issueinput3">تاریخ تولد</label>
                      <div class="col-sm-12">
                          <input type="number" id="issueinput3" value="{{ old('dateopened_d') }}" name="dateopened_d" style="width:50px"   required placeholder="dd" dir='ltr' max="31" size="2">/
                          <input type="number" id="issueinput3" value="{{ old('dateopened_m') }}" name="dateopened_m" style="width:50px"   required placeholder="mm" dir='ltr' max="12" size="2">/
                          <input type="number" id="issueinput3" value="{{ old('dateopened_y') }}" name="dateopened_y" style="width:100px"   required placeholder="yyyy" dir='ltr' max="1399" size="4">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6 mb-2">
                      <label for="projectinput5">جنسیت</label>
                      <select id="projectinput6" name="gender" class="form-control" required>
                        <option value="none" disabled="">جنسیت</option>
                        <option value="male">مرد</option>
                        <option value="female">زن</option>
                      </select>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-md-6 mb-2">
                      <label for="projectinput4">شماره تلفن همراه</label>
                      <input type="number" id="mobile" class="form-control" value="{{ old('mobile') }}" onkeyup="checkIsNumber('mobile')" required
                        placeholder="موبایل" name="mobile">
                        <p id="mobile_error"></p>
                    </div>

                    <div class="form-group col-md-6 mb-2">
                      <label for="tel">تلفن ثابت</label>
                      <input type="number" id="tel" class="form-control" value="{{ old('tel') }}" onkeyup="checkIsNumber('tel')" required
                      placeholder="تلفن ثابت" name="tel">
                      <p id="tel_error"></p>

                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-md-6 mb-2">
                      <label for="postalCode">کد پستی</label>
                      <input type="text" id="postalCode" class="form-control" value="{{ old('postalCode') }}" onkeyup="checkIsNumber('postalCode')" required
                      placeholder="کد پستی" name="postalCode">
                      <p id="postalCode_error"></p>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-12 mb-2">
                      <label for="projectinput9">آدرس</label>
                      <textarea id="projectinput9" rows="2" class="form-control" name="address" required
                        placeholder="آدرس">{{ old('address') }}</textarea>
                    </div>
                  </div>
                  <h4 class="form-section"><i class="ft-user"></i>اطلاعات حساب بانکی</h4>
                  <div class="row">
                    <div class="form-group col-md-6 mb-2">
                      <label for="projectinput4"> نام بانک</label>
                      <input type="text" id="projectinput4" class="form-control" value="{{ old('bank') }}" required
                      placeholder="نام بانک" name="bank">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-12 mb-2">
                      <label for="projectinput4"> شماره شبا </label>
                      <input type="text" id="projectinput4" class="form-control" value="{{ old('sheba') }}" style="text-align: left;" required
                        placeholder="-----------------------IR" name="sheba">
                    </div>
                  </div>
                  <div class="row">
                    <h4 class="form-section"><i class="ft-user"></i>طرح انتخابی</h4>

                  </div>
                  <div class="row">
                    <table class="table-responsive">
                      <tr>
                        <td></td>
                        <td
                          style="text-align: center; height: 50px; background-color: forestgreen; border: solid 1px grey;">
                          <strong>طرح اول</strong></td>
                        <td
                          style="text-align: center; height: 50px;background-color: forestgreen; border:solid 1px grey;">
                          <strong>طرح دوم</strong></td>
                        <td
                          style="text-align: center; height: 50px;background-color: forestgreen; border:solid 1px grey;">
                          <strong>طرح سوم</strong></td>
                      </tr>
                      <tr>
                        <td
                          style="text-align: center;height: 50px; background-color: honeydew; padding:10px; border:solid 1px grey; ">
                          مبلغ حق بیمه سالیانه هر طرح به ریال</td>
                        <td
                          style="text-align: center;height: 50px; background-color: honeydew;padding:10px; border:solid 1px grey; ">
                          <label>13،600،000</label>
                        <td
                          style="text-align: center; height: 50px;background-color: honeydew;padding:10px; border:solid 1px grey; ">
                          <label>10،000،000</label> </td>
                        <td
                          style="text-align: center; height: 50px;background-color: honeydew;padding:10px; border:solid 1px grey;">
                          <label>7،000،000</label> </td>
                      </tr>
                      <tr>
                        <td
                          style="text-align: center; height:50px;background-color: honeydew;padding:10px; border:solid 1px grey;">
                          انتخاب</td>

                        <td
                          style="text-align: center;height: 50px; background-color: honeydew;padding:10px; border:solid 1px grey;">
                          <input type="radio" id="plan1" name="plan" value="plan1" required></td>
                        <td
                          style="text-align: center;height: 50px; background-color: honeydew;padding:10px; border:solid 1px grey;">
                          <input type="radio" id="plan2" name="plan" value="plan2"></td>
                        <td
                          style="text-align: center;height: 50px;background-color: honeydew;padding:10px; border:solid 1px grey;">
                          <input type="radio" id="plan3" name="plan" value="plan3"></td>

                      </tr>

                    </table>


                  </div>
                  <div class="row">
                    <div class="form-group col-12 mb-2">
                      <a href="{{ Url( '/public/uploads/takmili/taahodat.pdf' ) }}">
                          دانلود فایل تعهدات
                      </a>
                    </div>
                  </div>
                  <div class="row">
                    <h4 class="form-section"><i class="ft-user"></i>درج اطلاعات افراد تحت تکفل</h4>
                  </div>
                  <div class="row">
                    <table class="table-responsive">
                      <tr>
                        <td
                          style="text-align: center; height: 50px; background-color: forestgreen; border: solid 1px grey;">
                          <strong> </strong></td>
                        <td
                          style="text-align: center; height: 50px; background-color: forestgreen; border: solid 1px grey;">
                          <strong>نسبت </strong></td>
                        <td
                          style="text-align: center; height: 50px; background-color: forestgreen; border: solid 1px grey;">
                          <strong>نام </strong></td>
                        <td
                          style="text-align: center; height: 50px; background-color: forestgreen; border: solid 1px grey;">
                          <strong>نام خانوادگی </strong></td>
                        <td
                          style="text-align: center; height: 50px; background-color: forestgreen; border: solid 1px grey;">
                          <strong>تاریخ تولد </strong>
                          </td>
                        <td
                          style="text-align: center; height: 50px; background-color: forestgreen; border: solid 1px grey;">
                          <strong>کد ملی </strong></td>
                        <td
                          style="text-align: center; height: 50px; background-color: forestgreen; border: solid 1px grey;">
                          <strong>شماره شناسنامه </strong></td>
                        <td
                          style="text-align: center; height: 50px; background-color: forestgreen; border: solid 1px grey;">
                          <strong> نام پدر </strong></td>
                        <td
                          style="text-align: center; height: 50px; background-color: forestgreen; border: solid 1px grey;">
                          <strong>جنسیت </strong></td>
                      </tr>
                      <tr>
                        <td style="text-align: center;  background-color:honeydew ; border: solid 1px grey;"><input
                            type='button' class='AddNew' value='+'></td>
                            
                        <td style="text-align: center; background-color:honeydew ; border: solid 1px grey;">
                            <select id="projectinput6" name="takafol_ralation[]" class="form-control" >
                                <option value="1">همسر</option>
                                <option value="2">پدر</option>
                                <option value="3">مادر</option>
                                <option value="4">فرزند اول</option>
                                <option value="5">فرزند دوم</option>
                                <option value="6">فرزند سوم</option>
                            </select>
                        </td>
                            
                        <td style="text-align: center;  background-color:honeydew ; border: solid 1px grey;"><input
                            type='text' name="takafol_fname[]" value='' ></td>
                            
                        <td style="text-align: center;  background-color:honeydew ; border: solid 1px grey;"><input
                            type='text' name="takafol_lname[]" value='' ></td>
                            
                        <td style="text-align: center;  background-color:honeydew ; border: solid 1px grey;">
                            <div class="col-sm-12" style="width: 300px">
                                <input type='number' name="takafol_birthDate_d[]" placeholder="dd"      style="width:50px"       min="1"     max="31" value=''>/
                                <input type='number' name="takafol_birthDate_m[]" placeholder="mm"      style="width:50px"       min="1"     max="12" value=''>/
                                <input type='number' name="takafol_birthDate_y[]" placeholder="yyyy"    style="width:100px"       min="1300"  max="1399" value=''> 
                            </div>
                        </td>
                            
                        <td style="text-align: center; background-color:honeydew ; border: solid 1px grey;"><input
                            type='number' name="takafol_nationalID[]" value='' ></td>
                            
                        <td style="text-align: center;  background-color:honeydew ; border: solid 1px grey;"><input
                            type='number' min="1" name="takafol_birthCertificateNumber[]" value='' >
                        </td>
                            
                        <td style="text-align: center;  background-color:honeydew ; border: solid 1px grey;"><input
                            type='text' name="takafol_father[]" value='' ></td>
                            
                        <td style="text-align: center;  background-color:honeydew ; border: solid 1px grey;">
                            <select id="projectinput6" name="takafol_gender[]" class="form-control" >
                                <option value="male">مرد</option>
                                <option value="female">زن</option>
                            </select>
                        </td>

                      </tr>
                    </table>
                  </div>
                  <br>
                </div>
                <div class="row">
                  <input type="checkbox" id="acc" name="acc"> <label for="acc" required>
                      بعنوان سرپرست خانوار(بیمه شده اصلی ) پس از مطالعه و توجیه کامل نسبت به شرایط بیمه مکمل درمان مورد نظر اتحادیه، موافقت خود را در رابطه با خرید پوششهای این بیمه نامه برای خود و سایر افراد تحت تکفل به شرح جدول فوق اعلام نموده و مبلغ طرح مورد نظر را نقدا پرداخت می نمایم
                    </label><br>
                </div>
                <div class="row">
                  <p class="col-sm-12">
                      در صورت داشتن هرگونه سوال در خصوص نحوه پرداخت حق بیمه میتوانید با شماره های زیر تماس حاصل نمائید.
                  </p>
                  <p class="col-sm-12">آقای یوسفی ۰۹۱۲۶۱۳۶۲۸۲</p>
                  <p class="col-sm-12">آقای قشونی ۰۹۱۲۳۹۷۸۷۲۷</p>
                </div>
                <div class="form-actions bottom">
                  <button type="button" class="btn btn-raised btn-warning mr-1">
                    <i class="ft-x"></i> انصراف
                  </button>
                  <input type="submit" class="btn btn-raised btn-primary" value="پرداخت">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script>
      $('.AddNew').click(function () {
        var row = $(this).closest('tr').clone();
        row.find('input').val('');
        $(this).closest('tr').after(row);
        $('input[type="button"]', row).removeClass('AddNew')
          .addClass('RemoveRow').val('-');
      });
    
      $('table').on('click', '.RemoveRow', function () {
        $(this).closest('tr').remove();
      });
    </script>
  <!-- // Form actions layout section end -->
@endsection

<script>
    function checkIsNumber(id){
        var input = document.getElementById(id);
        var show_error = document.getElementById(id + '_error')
        var l = input.value.length;
        var a = input.value;
        if(isNaN(a)){
            input.style.border = '1px solid red';
            input.value = '';
            show_error.innerHTML = "<span style='color:red'>عدد انگلیسی وارد کنید</span>";
        }else{
            input.style.border = '1px solid green';
            show_error.innerHTML = "";
        }
    }
</script>