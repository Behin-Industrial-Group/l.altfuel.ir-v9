@extends('layouts.welcome')

@section('content')
<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <img src="https://altfuel.ir/fa/public/logo.png" class="col-sm-12" alt="">
        </div>
        <div class="card-body">
            <form action="javascript:void(0)" method="post" id="register-form">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="fname" placeholder="نام">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="lname" placeholder="نام خانوادگی">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="nid" placeholder="کدملی">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-id-card"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="father_name" placeholder="نام پدر">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control datepicker" name="birth_date" placeholder="تاریخ تولد" value="{{ date('Y') - 18 . '/' . date('m/d') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-calendar"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="mobile" placeholder="شماره موبایل">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-phone"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input  list="catagories" id="catagory" class="form-control" name="asnaf_catagory" autocomplete="off" placeholder="رسته صنفی">
                    <datalist id="catagories" style="display: none">
                        <option value="کرایه یا اجاره اتومبیل بدون راننده">
                        <option value="گاز رساني واحدهاي تجاري ومسكوني">
                        <option value="لباس عروس دوزي">
                        <option value="لباس كار دوزي">
                        <option value="لبوپزي">
                        <option value="لحاف و تشک و بالش و پشتی دوزی">
                        <option value="لحیم کاری فلزات">
                        <option value="لعاب کاری و رنگ کاری فلزات">
                        <option value="لوبيا- عدسي پزي">
                        <option value="گوني و کيسه دوزي">
                        <option value="گالري هنري">
                        <option value="گچبري هنري">
                        <option value="گرمابه داران">
                        <option value="گل زني روي ظروف ملامين">
                        <option value="كله پاچه، سيرابي و روده پاك كني">
                        <option value="كلوپ بازي هاي غير رايانه اي">
                        <option value="مشاور فني ساختماني">
                        <option value="مشاوره املاك و مستغلات">
                        <option value="مشاوره سازه هاي آب">
                        <option value="مشاوره مهندسي">
                        <option value="مشبك بري چوب">
                        <option value="معرق و مشبك كاري">
                        <option value="نان لواش ماشيني">
                        <option value="نان لواش سنتي">
                        <option value="نان سوخاري">
                        <option value="طباخي (كله، پاچه، سيراب و شيردان پزي)">
                        <option value="مجالس جشن">
                        <option value="نان سنگكي ماشيني">
                        <option value="نان سنگكي سنتي">
                        <option value="نان روغني پزي">
                    </datalist>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-list-alt"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="monthly_use" placeholder="میزان مصرف در ماه">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-question-circle"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <select name="city_id" id="" aria-placeholder="city" class="select2" style="width: 100%">
                    @foreach ($cities as $item)
                        <option value="{{ $item->id }}">{{ $item->province . ' - ' . $item->city }}</option>
                    @endforeach
                    </select>
                    
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="postal_code" placeholder="کدپستی">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-map-pin"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <textarea type="text" class="form-control" name="address" placeholder="آدرس"></textarea>
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-12">
                <button type="submit" class="btn btn-primary col-sm-12" onclick="submit()">ثبت نام</button>
            </div>
        </div>

    </div>
</div>
@endsection

@section('script')
    <script>
        function submit() {
            send_ajax_request(
                "{{ route('asnafLPGRegistration') }}",
                $('#register-form').serialize(),
                function(response) {
                    show_message("ثبت نام انجام شد")
                    // console.log(response);
                    setTimeout(() => {
                        window.location.reload()
                    }, 1000);
                },
                function(response) {
                    show_error(response)
                    hide_loading();
                }
            )
        }
        $('.datepicker').pDatepicker({
            format: 'YYYY/MM/DD',
            initialValueType: 'gregorian'
        });
    </script>
@endsection