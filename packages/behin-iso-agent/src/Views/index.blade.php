@extends('layouts.app')

@section('content')

@endsection

@section('script')

    <script>
        var table = create_datatable(
            'todos-table',
            "{{ route('todoList.list') }}",
            [
                {
                    data: 'task'
                },
                {
                    data: 'creator_name'
                },

                {
                    data: 'done',
                    visible: false
                },
                {
                    data: 'reminder_date',
                    render: function(data) {
                        if (data == null) {
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
                        if (data == null) {
                            return '';
                        }
                        let mydate = new Date(data);
                        let mypersiandate = mydate.toLocaleDateString('fa-IR');
                        return mypersiandate;
                    }
                },
            ],
            function(row, data) {
                // تغییر رنگ پس‌زمینه ردیف بر اساس مقدار فیلد done
                if (data.done == 1) {
                    $(row).css('background', 'lightgreen');
                    var first_col = $($(row).children()[0]);
                    first_col.css('text-decoration', 'line-through');
                    first_col.html('<i class="fa fa-check-circle"></i> ' + first_col.html())
                    console.log();
                }
                // if (data.done) {
                //     $(row).css('background', 'lightgreen');
                //     var first_col = $($(row).children()[0]);
                //     first_col.css('text-decoration', 'line-through');
                //     first_col.html('<i class="fa fa-check-circle"></i> ' + first_col.html())
                //     console.log();
                // }
            },
            [
                [2, 'asc'],
                [3, 'desc']
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
                    show_message(response);
                }
            )

        }

        function all_task() {
            send_ajax_get_request(
                '{{ route('todoList.list') }}',
                function(response) {
                    console.log(response);
                    update_datatable(response.data)
                }
            )
        }

        function today_task() {
            send_ajax_get_request(
                '{{ route('todoList.today') }}',
                function(response) {
                    console.log(response);
                    update_datatable(response.data)
                }
            )
        }

        function expired_task() {
            send_ajax_get_request(
                '{{ route('todoList.expired') }}',
                function(response) {
                    console.log(response);
                    update_datatable(response.data)
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
