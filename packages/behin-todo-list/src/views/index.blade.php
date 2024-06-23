@extends('layouts.app')

@section('style')
    {{-- <link rel="stylesheet" href="{{ url('public/packages/behin-todo-list/style.css') }}"> --}}
@endsection

@section('content')
    <div id="myDIV" class="header">
        <h2>To Do List</h2>

        <form action="javascript:void(0)" method="POST" id="new-task">
            @csrf
            <div class="col-sm-12 mt-2">
                <label for="task" class="col-sm-12">کار :</label>
                <input type="text" id="task" name="task" placeholder="Task..." class="col-sm-12 mb-2">
            </div>
            <div class="col-sm-12 mt-2">
                <label for="description" class="col-sm-12">توضیحات کار :</label>
                <textarea name="description" id="description" cols="30" rows="10" class="col-sm-12"></textarea>
            </div>
            <div class="col-sm-12 mt-2">
                <label for="reminder_date" class="col-sm-2">تاریخ یادآوری :</label>
                <input type="date" id="reminder_date" name="reminder_date" class="col-sm-10">
            </div>
            <div class="col-sm-12 mt-3">
                <label for="due_date">تاریخ تحویل :</label class="col-sm-2">
                <input type="date" id="due_date" name="due_date" class="col-sm-10">
            </div>
            <div class="col-sm-12 mt-4">
                <select name="user_id" id="" class="form-control form-control-sm">
                    <option value="">کاربر را انتخاب کنید</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @if (Auth::id() == $user->id) selected @endif>
                            {{ $user->name }}
                        </option>
                    @endforeach

                </select>
            </div>
            <button type="submit" onclick="add()" class="col-sm-12 mt-2 btn btn-primary">اضافه کردن</button>

        <form action="javascript:void(0)" id="task-form">

            <div class="row col-sm-12">
                @csrf
                <div class="row col-sm-12">
                    <input type="text" id="task" name="task" placeholder="{{ __('Task') }}"
                        class="form-control col-sm-11">
                    <button type="button" class="btn btn-primary" onclick="register()"><i class="fa fa-paper-plane"></i></button>
                </div>
                <div class="row col-sm-12 mt-2">
                    <button class="btn btn-default m-1" onclick="show_element('description')"><i
                            class="fa fa-edit">{{ __('Task Desctiption') }}</i></button>
                    <button class="btn btn-default m-1" onclick="show_element('reminder_date')"><i
                            class="fa fa-calendar">{{ __('Remember Me') }}</i></button>
                    <button class="btn btn-default m-1" onclick="show_element('due_date')"><i
                            class="fa fa-calendar">{{ __('Due Date') }}</i></button>
                </div>
                <div class="col-sm-12 mt-2">
                    <textarea name="description" id="description" class="form-control" placeholder="{{ __('Description') }}"></textarea>
                    <input type="text" id="reminder_date"  name="reminder_date" class="col-sm-10 pdate form-control"
                        placeholder="{{ __('Remember Me') }}">
                    <input type="text" id="due_date" name="due_date" class="col-sm-10 pdate form-control"
                        placeholder="{{ __('Due Date') }}">
                </div>
            </div>

        </form>
    </div>
    <hr>
    <div class="table-responsive">
        <table class="table table-stripped" id="todos-table">
            <thead>
                <tr>
                    <th>شناسه</th>
                    <th>ایجاد کننده</th>
                    <th>کار</th>
                    <th>توضیحات کار</th>
                    <th>وضعیت</th>
                    <th>تاریخ یادآوری</th>
                    <th>تاریخ تحویل</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('script')
    {{-- <script src="{{ url('public/packages/behin-todo-list/script.js') }}"></script> --}}
    <script>

        function add() {
            fd = new FormData($('#new-task')[0])
            send_ajax_formdata_request(
                "{{ route('todoList.create') }}",
                fd,
                function(res) {
                    show_message(res);
                    refresh_table();
                }
            )
        }

        var table = create_datatable(
            'todos-table',
            "{{ route('todoList.list') }}",
            [{
                    data: 'id'
                },
                {
                    data: 'creator'
                },
                {
                    data: 'task'
                },
                {
                    data: 'description'
                },
                {
                    data: 'done'
                },
                {
                    data: 'reminder_date'
                },
                {
                    data: 'due_date'
                },

        // initial_view()
        $(".pdate").persianDatepicker({
            initialValue: false,
            viewMode: 'day',
            format: 'YYYY-MM-DD H:m',
            timePicker: {
                enabled: true
            },
            calendar: {
                persian: {
                    locale: 'en'
                }
            }
        });
        function register(){
            var form = $('#task-form')[0];
            var fd = new FormData(form);
            send_ajax_formdata_request(
                '{{ route("todoList.create") }}',
                fd,
                function(response){
                    console.log(response);
                    table.ajax.reload()
                }
            )
        }
        var table = create_datatable(
            'todos-table',
            "{{ route('todoList.list') }}",
            [
                {data: 'task'},
                {data: 'description'},
                {data: 'done'},

            ],
            null,
            [
                [2, 'asc']
            ]
        );



        table.on('dblclick', 'tr', function() {
            var data = table.row(this).data();
            if (data != undefined) {
                show_task_modal(data.id);
            }
        });

        function show_task_modal(id) {
            var fd = new FormData();
            fd.append('id', id);
            send_ajax_formdata_request(
                "{{ route('todoList.edit') }}",
                fd,
                function(body) {
                    open_admin_modal_with_data(body, '', function() {
                        $(".direct-chat-messages").animate({
                            scrollTop: $('.direct-chat-messages').prop("scrollHeight")
                        }, 1);
                    });
                },
                function(data) {
                    show_error(data);
                }
            )

        var des = $('#description');
        var reminder_date = $('#reminder_date');
        var due_date = $('#due_date');
        des.hide()
        reminder_date.hide();
        due_date.hide();
        function show_element(element) {
            if (element == 'description') {
                if (des.css('display') === 'none') {
                    des.show()
                } else {
                    des.hide()
                }
            }
            if (element == 'reminder_date') {
                if (reminder_date.css('display') === 'none') {
                    reminder_date.show()
                } else {
                    reminder_date.hide()
                }
            }
            if (element == 'due_date') {
                if (due_date.css('display') === 'none') {
                    due_date.show()
                } else {
                    due_date.hide()
                }
            }

        }
    </script>
@endsection
