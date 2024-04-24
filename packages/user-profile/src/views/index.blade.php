@extends('layouts.app')

@section('title')
    کاربران
@endsection

@section('content')
    <div class="p-4">
        <div class="row m-10">
            <div class="col-sm-2">نام کاربری :</div>
            <div class="col-sm-10">{{ $user->display_name }}</div>
            <hr>
            <div class="col-sm-2">شماره موبایل :</div>
            <div class="col-sm-10">{{ $user->email }}</div>
            <hr>
            @if ($userProfile?->national_id)
                <div class="col-sm-2">کد ملی :</div>
                <div class="col-sm-10">{{ $userProfile->national_id }}</div>
            @else
            <form action="javascript:void(0)" method="POST" id="store-national-id-form">
                @csrf
                <section class="col-sm-12">
                    <div class="form-group">
                        <div class="col-sm-2">کد ملی :</div>
                        <input type="text" class="form-control form-control-sm my-2 col-sm-6" name="national_id" id="national_id">
                        <button class="btn btn-primary btn-sm col-sm-4" onclick="store_national_id()">ثبت</button>
                    </div>
                </section>
            </form>
            @endif
            <hr>
            <a href="{{ route('user-profile.change-password') }}" class="col-sm-12 btn btn-primary btn-sm" >تغییر رمز عبور</a>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function store_national_id(){
            var form = $('#store-national-id-form')[0];
            var data = new FormData(form);
            send_ajax_formdata_request(
                "{{ route('user-profile.storeNationalId') }}",
                data,
                function(response){
                    show_message("{{trans('ok')}}")
                    location.reload()
                }
            )
        }
    </script>
@endsection
