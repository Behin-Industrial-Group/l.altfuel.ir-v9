@extends('layouts.app')


@php
    $title = '';
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="javascript:void(0)" id="cat-form">
                <div class="form-group">
                    <label for="">دسته بندی</label>

                    @if (auth()->user()->access('Ticket-Actors'))
                    @include('ATView::partial-view.category-for-actor')
                        <button class="btn btn-primary mt-2" onclick="filterAll()">فیلتر تمام تیکت ها</button>
                        <button class="btn btn-info mt-2" onclick="filter()">فیلتر تیکت های جدید و درحال بررسی</button>
                        <button class="btn btn-secondary mt-2" onclick="oldTicket()">فیلتر تیکت های پاسخ داده شده و بسته
                            شده</button>
                    @else
                    @include('ATView::partial-view.catagory')
                        <button class="btn btn-info" onclick="filter()">فیلتر</button>
                    @endif
                </div>
            </form>
        </div>
        <div class="table-responsive mt-2">
            <table class="table table-stripped" id="tickets-table">
                <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>عنوان</th>
                        <th>ثبت کننده</th>
                        <th>دسته بندی</th>
                        <th>کارشناس</th>
                        <th>وضعیت</th>
                        <th>آخرین تغییرات</th>
                        {{-- <th>امتیاز</th> --}}
                    </tr>
                </thead>
            </table>
        </div>

    </div>
@endsection

@section('script')
    <script>
        function filterAll() {
            data = $('#cat-form').serialize();
            send_ajax_request(
                "{{ route('ATRoutes.get.getAllByCatagory') }}",
                data,
                function(data) {
                    console.log(data);
                    update_datatable(data);
                }
            )
        }

        function filter() {
            data = $('#cat-form').serialize();
            send_ajax_request(
                "{{ route('ATRoutes.get.getByCatagory') }}",
                data,
                function(data) {
                    console.log(data);
                    update_datatable(data);
                }
            )
        }

        function oldTicket() {
            data = $('#cat-form').serialize();
            send_ajax_request(
                "{{ route('ATRoutes.get.oldGetByCatagory') }}",
                data,
                function(data) {
                    console.log(data);
                    update_datatable(data);
                }
            )
        }

        var table = create_datatable(
            'tickets-table',
            "{{ route('ATRoutes.get.getAll') }}",
            [{
                    data: 'id'
                },
                {
                    data: 'title',
                    render: function(title) {
                        return `<a href="#">${title}</a>`;
                    }
                },
                {
                    data: 'user',
                    render: function(data, type, row) {
                        if (row.user_level == 2) {
                            return data + ' <i style="color:royalblue" class="fa fa-check-circle"></i>'
                        }
                        return data
                    }
                },
                {
                    data: 'catagory'
                },
                {
                    data: 'actor'
                },
                {
                    data: 'status',
                    render: function(data) {
                        if (data == "{{ config('ATConfig.status.new') }}") {
                            return '1-' + data
                        } else if (data == "{{ config('ATConfig.status.in_progress') }}") {
                            return '2-' + data
                        } else if (data == "{{ config('ATConfig.status.answered') }}") {
                            return '3-' + data
                        } else if (data == "{{ config('ATConfig.status.closed') }}") {
                            return '4-' + data
                        } else {
                            return data
                        }
                    }
                },
                {
                    data: 'updated_at',
                    render: function(data) {
                        datetime = new Date(data);
                        date = datetime.toLocaleDateString('fa-IR');
                        time = datetime.toLocaleTimeString('fa-IR');
                        return '<span dir="auto" style="float: left">' + date + ' ' + time + '</span>';
                    }
                },
                // {data: 'score'}
            ],
            null,
            [
                [5, 'asc'],
                [6, 'desc']
            ]
        );

        send_ajax_get_request(
            "{{ route('ATRoutes.get.getMyTickets') }}",
            function(data) {
                update_datatable(data);
            }
        )

        table.on('click', 'tr', function() {
            var data = table.row(this).data();
            if (data != undefined) {
                show_comment_modal(data.id, data.title, data.user_id);
            }
        })

        function show_comment_modal(ticket_id, title, user) {
            var fd = new FormData();
            fd.append('ticket_id', ticket_id);
            send_ajax_formdata_request(
                "{{ route('ATRoutes.show.ticket') }}",
                fd,
                function(body) {
                    open_admin_modal_with_data(body, title, function() {
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
    </script>
@endsection
