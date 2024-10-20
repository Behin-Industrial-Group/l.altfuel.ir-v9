@extends('layouts.app')

@section('title', 'پروفایل')

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

    <div class="container pt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="profile-info">
                    <div class="row mb-3">
                        <label class="col-sm-4 font-weight-bold">نام کاربری:</label>
                        <div class="col-sm-8">{{ $user->display_name }}</div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 font-weight-bold">شماره موبایل:</label>
                        <div class="col-sm-8">{{ $user->email }}</div>
                    </div>

                    @if ($userProfile?->national_id)
                        <div class="row mb-3">
                            <label class="col-sm-4 font-weight-bold">کد ملی:</label>
                            <div class="col-sm-8">{{ $userProfile->national_id }}</div>
                        </div>
                    @else
                        <div class="row mb-3">
                            <label class="col-sm-4 font-weight-bold">کد ملی:</label>
                            <div class="col-sm-8">
                                <form id="store-national-id-form" class="d-flex">
                                    @csrf
                                    <input type="text" class="form-control mr-2" name="national_id" placeholder="کد ملی" required>
                                    <button class="btn btn-primary btn-sm" onclick="store_national_id()">ثبت</button>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if ($userProfile->national_id && $user->email && $user->role_id != 4)
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <form id="role-update-form" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm" onclick="role_update()">ارتقای سطح کاربری</button>
                                </form>
                            </div>
                        </div>
                    @endif

                    @include('UserProfileViews::partial-views.mobile-verification')
                    @include('UserProfileViews::partial-views.role-name')
                </div>
            </div>

            <div class="col-md-6 text-right">
                <a href="{{ route('user-profile.change-password') }}" class="btn btn-danger btn-sm mb-3">تغییر رمز عبور</a>
            </div>
        </div>

        @if ($userProfile?->national_id && auth()->user()->access('Show My Agencies'))
            <div class="row mt-4">
                <div class="col-sm-12">
                    <button class="btn btn-info" onclick="getAgencies()">{{ __('Show My Agencies') }}</button>
                </div>
                <div id="agenciesInfo" class="col-sm-12 mt-3"></div>
            </div>

            <script>
                function getAgencies() {
                    var data = new FormData();
                    data.append('national_id', '{{ $userProfile->national_id }}');
                    data.append('mobile', '{{ $user->email }}');
                    send_ajax_formdata_request(
                        "{{ route('user-profile.getUserAgencies') }}",
                        data,
                        function(response) {
                            $('#agenciesInfo').html(response);
                        }
                    );
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
                    show_message("{{ trans('ok') }}");
                    location.reload();
                }
            );
        }

        function role_update() {
            var form = $('#role-update-form')[0];
            var data = new FormData(form);
            send_ajax_formdata_request(
                "{{ route('user-profile.level-setter', $user->id) }}",
                data,
                function(response) {
                    show_message("{{ trans('ok') }}");
                    location.reload();
                }
            );
        }
    </script>
@endsection
