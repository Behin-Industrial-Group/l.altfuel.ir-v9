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
                    <select name="city_id" id="" aria-placeholder="city" class="select2" style="width: 100%">
                    @foreach ($cities as $item)
                        <option value="{{ $item->id }}">{{ $item->province . ' - ' . $item->city }}</option>
                    @endforeach
                    </select>
                    
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="mobile" placeholder="شماره تماس">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-phone"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="asnaf_catagory" placeholder="رسته صنفی">
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
    </script>
@endsection