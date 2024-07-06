@extends('layouts.app')

@section('style')
    {{-- <link rel="stylesheet" href="{{ url('public/packages/behin-todo-list/style.css') }}"> --}}
@endsection

@section('content')
    <div id="myDIV" class="header">
        <h2>To Do List</h2>

        <form action="javascript:void(0)" id="task-form">
            <input type="text" class="d-none" name="creator" value="{{ Auth::id() }}">
            <div class="row col-sm-12">
                @csrf
                <div class="row col-sm-12">
                    <input type="text" id="task" name="task" placeholder="{{ __('Task Title') }}"
                        class="form-control col-sm-11 m-1">
                    <button type="button" class="btn btn-primary m-1" onclick="register()"><i
                            class="fa fa-paper-plane"></i></button>
                </div>
                <div class="row col-sm-12 mt-2">
                    <button class="btn btn-default m-2" onclick="show_element('description')"><i
                            class="fa fa-edit">{{ __(' Task Description') }}</i></button>
                    <button class="btn btn-default m-2" onclick="show_element('reminder_date_view')"><i
                            class="fa fa-calendar">{{ __(' Reminder Date') }}</i></button>
                    <button class="btn btn-default m-2" onclick="show_element('due_date_view')"><i
                            class="fa fa-calendar">{{ __(' Due Date') }}</i></button>

                    <button class="btn btn-default m-2" onclick="show_element('assign_to')"><i
                            class="fa fa-user">{{ __(' Assign To') }}</i></button>
                </div>
                <div class="col-sm-12 mt-2">
                    <textarea name="description" id="description" class="form-control m-1" placeholder="{{ __('Description') }}"></textarea>
                    <input type="hidden" id="reminder_date" name="reminder_date">
                    <input type="text" id="reminder_date_view" class="col-sm-10 form-control m-1" placeholder="{{__('Reminder Date')}}">
                    <input type="hidden" id="due_date" name="due_date">
                    <input type="text" id="due_date_view" class="col-sm-10 form-control m-1" placeholder="{{__('Due Date')}}">
                    <select name="user_id" id="assign_to" class="form-control form-control-sm m-1">
                        <option value="">کاربر را انتخاب کنید</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @if (Auth::id() == $user->id) selected @endif>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
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
        var table = create_datatable(
            'todos-table',
            "{{ route('todoList.list') }}",
            [{
                    data: 'id'
                },
                {
                    data: 'creator_name'
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
                    data: 'reminder_date',
                    render: function(data) {
                        if(data == null){
                            return '';
                        }
                        let mydate = new Date(data);
                        let mypersiandate = mydate.toLocaleDateString('fa-IR');
                        return mypersiandate;
                    }
                },
                {
                    data: 'due_date',
                    render: function(data) {
                        if(data == null){
                            return '';
                        }
                        let mydate = new Date(data);
                        let mypersiandate = mydate.toLocaleDateString('fa-IR');
                        return mypersiandate;
                    }
                },
            ],
            null,
            [
                [4, 'asc'],
                [5, 'desc']
            ]

        )

        $(document).ready(function() {
            $("#due_date_view").persianDatepicker({
                format: 'YYYY-MM-DD',
                toolbox: {
                    calendarSwitch: {
                        enabled: true
                    }
                },
                initialValue: false,
                observer: true,
                altField: '#due_date'
            });


            $("#reminder_date_view").persianDatepicker({
                format: 'YYYY-MM-DD',
                toolbox: {
                    calendarSwitch: {
                        enabled: true
                    }
                },
                initialValue: false,
                observer: true,
                altField: '#reminder_date'
            });
        });


        function register() {
            var form = $('#task-form')[0];
            var fd = new FormData(form);
            send_ajax_formdata_request(
                '{{ route('todoList.create') }}',
                fd,
                function(response) {
                    console.log(response);
                    table.ajax.reload();
                    form.reset();
                }
            )

        }



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
        }

        var des = $('#description');
        var reminder_date = $('#reminder_date_view');
        var due_date = $('#due_date_view');
        var assign_to = $('#assign_to');
        des.hide()
        reminder_date.hide();
        due_date.hide();
        assign_to.hide();

        function show_element(element) {
            if (element == 'description') {
                if (des.css('display') === 'none') {
                    des.show()
                } else {
                    des.hide()
                }
            }
            if (element == 'reminder_date_view') {
                if (reminder_date.css('display') === 'none') {
                    reminder_date.show()
                } else {
                    reminder_date.hide()
                }
            }
            if (element == 'due_date_view') {
                if (due_date.css('display') === 'none') {
                    due_date.show()
                } else {
                    due_date.hide()
                }
            }
            if (element == 'assign_to') {
                if (assign_to.css('display') === 'none') {
                    assign_to.show()
                } else {
                    assign_to.hide()
                }
            }

        }
    </script>
@endsection
