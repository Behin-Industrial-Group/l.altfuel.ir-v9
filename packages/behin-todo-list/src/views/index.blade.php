@extends('layouts.app')

@section('style')
    {{-- <link rel="stylesheet" href="{{ url('public/packages/behin-todo-list/style.css') }}"> --}}
@endsection

@section('content')
    <div id="myDIV" class="header">
        <h2>To Do List</h2>
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
                    <th>کار</th>
                    <th>توضیحات کار</th>
                    <th>وضعیت</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('script')
    {{-- <script src="{{ url('public/packages/behin-todo-list/script.js') }}"></script> --}}
    <script>
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
