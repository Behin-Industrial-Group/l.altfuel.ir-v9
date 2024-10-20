@extends('layouts.app')

@section('title', 'کاربران')

@section('content')
    <div class="row">
        <div class="col-sm-12 mb-2">
            <a href="all" class="btn btn-info">Back To List</a>
        </div>

        <div class="col-sm-12 mb-2">
            @if ($user->disabled)
                <form method="POST" action="enable" id="enable-form">
                    @method('patch')
                    @csrf
                    <input type="hidden" value="{{ $user->id }}" name="id">
                    <button type="button" onclick="toggleStatus('enable-form')" class="btn btn-primary">فعال سازی کاربر</button>
                </form>
            @else
                <form method="POST" action="disable" id="disable-form">
                    @method('patch')
                    @csrf
                    <input type="hidden" value="{{ $user->id }}" name="id">
                    <button type="button" onclick="toggleStatus('disable-form')" class="btn btn-danger">غیر فعال سازی کاربر</button>
                </form>
            @endif
        </div>

        <div class="col-sm-6">
            <div class="box">
                <div class="box-body">
                    <table class="table table-striped">
                        <tr>
                            <th>شناسه</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>نام</th>
                            <td>{{ $user->display_name }}</td>
                        </tr>
                        <tr>
                            <th>نام کاربری</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>ایمیل</th>
                            <td>{{ $user->email }}</td>
                        </tr>

                        <tr>
                            <form method="post" action="{{ route('change-user-ip', ['id' => $user->id]) }}">
                                @csrf
                                <td>valid ip: <input type="text" name="valid_ip" value="{{ $user->valid_ip }}"></td>
                                <td><input type="submit" value="ثبت IP" class="btn btn-sm btn-success"></td>
                            </form>
                        </tr>

                        <tr>
                            <form method="post" action="{{ route('change-pm-username', ['id' => $user->id]) }}">
                                @csrf
                                <td>نام کاربری Process Maker: <input type="text" name="pm_username" value="{{ $user->pm_username }}"></td>
                                <td><input type="submit" value="تغییر نام کاربری PM" class="btn btn-sm btn-warning"></td>
                            </form>
                        </tr>

                        <tr>
                            <form method="post" action="{{ $user->id }}/changepass">
                                @csrf
                                <td>رمز عبور: <input type="password" name="pass"></td>
                                <td><input type="submit" value="تغییر رمز" class="btn btn-sm btn-danger"></td>
                            </form>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="box mt-3">
                <div class="box-body">
                    <form method="post" action="{{ $user->id }}/changeShowInReport">
                        @csrf
                        <label>
                            <input type="checkbox" name="showInReport" @if ($user->showInReport) checked @endif>
                            نمایش در گزارش‌ها
                        </label>
                        <input type="submit" class="btn btn-sm btn-success" value="ثبت">
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h3>دسترسی‌ها</h3>
                </div>
                <div class="box-body">
                    <button class="btn btn-sm btn-info mb-2" id="check_all">انتخاب همه</button>
                    <form class="form-horizontal" method="post" id="role-table">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="form-group">
                            <select name="role_id" class="form-control">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" @if ($user->role_id == $role->id) selected @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <button class="btn btn-sm btn-primary" onclick="change_role()">تغییر نقش</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function toggleStatus(formId) {
            var form = $('#' + formId)[0];
            var data = new FormData(form);
            var url = form.action;
            send_ajax_formdata_request(url, data, function(response) {
                show_message("{{ trans('ok') }}");
                location.reload();
            });
        }

        function change_role() {
            send_ajax_request(
                "{{ route('role.changeUserRole') }}",
                $('#role-table').serialize(),
                function(response) {
                    console.log(response);
                }
            );
        }

        $("#check_all").on('click', function() {
            $('#access_tbl input:checkbox').prop('checked', true);
        });
    </script>
@endsection
