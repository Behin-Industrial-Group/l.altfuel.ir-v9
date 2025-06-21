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
                        <br>
                        <br>
                        @if (auth()->user()->access('جستجو پیشرفته'))
                            @include('ATView::partial-view.filter-form')
                        @endif
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
                        <th>وضعیت</th>
                        <th>آخرین تغییرات</th>
                        {{-- <th>امتیاز</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($myTickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->title }}</td>
                            <td>{{ $ticket->user }}</td>
                            <td>{{ $ticket->catagory }}</td>
                            <td>{{ $ticket->status }}</td>
                            <td dir="ltr">{{ verta($ticket->updated_at)->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection

@section('script')
    <script>
        var table = $('#tickets-table').DataTable({
            "order": [
                [5, "desc"]
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.5/i18n/fa.json"
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'title'
                },
                {
                    data: 'user'
                },
                {
                    data: 'catagory'
                },
                {
                    data: 'status'
                },
                {
                    data: 'updated_at'
                }
            ]
        })

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

        table.on('click', 'tr', function() {
            data = table.row(this).data();
            show_comment_modal(data.id, data.title, data.user);
        })

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

        function filterWithAgent() {
            let data = $('#cat-form').serialize(); // اگر فیلترها داخل همون فرم هستن

            send_ajax_request(
                "{{ route('ATRoutes.filterByAgent') }}", // این رو باید توی Route تعریف کنی
                data,
                function(data) {
                    update_datatable(data);
                }
            )
        }


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
