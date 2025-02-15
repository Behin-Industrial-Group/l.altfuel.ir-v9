@extends('layouts.app')

@section('title')
    پروفایل
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="p-4">
        <div class="row m-10">
            <div class="col-sm-6 row">
                <div class="col-sm-4">نام کاربری :</div>
                <div class="col-sm-6">{{ $user->display_name }}</div>
                <hr>
                <div class="col-sm-4">شماره موبایل :</div>
                <div class="col-sm-6">{{ $user->email }}</div>
                <hr>
                @if ($userProfile?->national_id)
                    <div class="col-sm-4">کد ملی :</div>
                    <div class="col-sm-6">{{ $userProfile->national_id }}</div>
                @else
                    <div class="col-sm-4">کد ملی :</div>
                    <div class="col-sm-6">
                        <form action="javascript:void(0)" class="row" id="store-national-id-form">
                            @csrf
                            <input type="text" class="form-control col-sm-9" name="national_id" id="national_id">
                            <button class="btn btn-primary btn-sm col-sm-3" onclick="store_national_id()">ثبت</button>
                        </form>
                    </div>
                @endif
                @if ($userProfile->national_id and $user->email and $user->role_id != 4)
                    <div class="col-12">
                        <form action="javascript:void(0)" class="row" id="role-update-form">
                            @csrf
                            <button class="btn btn-primary btn-sm col-sm-3" onclick="role_update()">ارتقای سطح
                                کاربری</button>
                        </form>
                    </div>
                @endif
                @include('UserProfileViews::partial-views.mobile-verification')
                @include('UserProfileViews::partial-views.role-name')
            </div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3">
                <a href="{{ route('user-profile.change-password') }}" class="col-sm-10 btn btn-danger btn-sm">تغییر رمز
                    عبور</a>
            </div>
        </div>

        @if ($userProfile?->national_id and auth()->user()->access('Show My Agencies'))
            <div class="row">
                <div class="col-sm-12">
                    <button class="btn btn-info" onclick="getAgencies()">{{ __('Show My Agencies') }}</button>
                </div>
                <div id="agenciesInfo" class="col-sm-12"></div>
            </div>
            <script>
                function getAgencies() {
                    var data = new FormData();
                    data.append('national_id', '{{ $userProfile->national_id }}')
                    data.append('mobile', '{{ $user->email }}')
                    send_ajax_formdata_request(
                        "{{ route('user-profile.getUserAgencies') }}",
                        data,
                        function(response) {
                            console.log(response);
                            $('#agenciesInfo').html(response)
                        }
                    )
                }
            </script>
        @endif

    </div>
@endsection

@section('script')
    <script>
        function store_national_id() {
            var form = $('#store-national-id-form')[0];
            var data = new FormData(form);
            send_ajax_formdata_request(
                "{{ route('user-profile.storeNationalId') }}",
                data,
                function(response) {
                    show_message("{{ trans('ok') }}")
                    location.reload()
                }
            )
        }

        function role_update() {
            var form = $('#role-update-form')[0];
            var data = new FormData(form);
            send_ajax_formdata_request(
                "{{ route('user-profile.level-setter', $user->id) }}",
                data,
                function(response) {
                    show_message("{{ trans('ok') }}")
                    location.reload()
                }
            )
        }
    </script>
@endsection
