@extends('layouts.app')


@php
    $title ="";
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="javascript:void(0)" id="cat-form">
                <div class="form-group">
                    <label for="">دسته بندی</label>
                    @include('ATView::partial-view.catagory')
                    <button class="btn btn-info" onclick="filter()">فیلتر</button>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-stripped" id="tickets-table">
                <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>عنوان</th>
                        <th>ثبت کننده</th>
                        <th>دسته بندی</th>
                        <th>وضعیت</th>
                        <th>آخرین تغییرات</th>
                    </tr>
                </thead>
            </table>
        </div>
        
    </div>
@endsection

@section('script')
    
    <script>
        function filter(){
            data = $('#cat-form').serialize();
            send_ajax_request(
                "{{ route('ATRoutes.get.getByCatagory') }}",
                data,
                function(data){
                    console.log(data);
                    update_datatable(data);
                }
            )
        }
        var table = create_datatable(
            'tickets-table',
            "{{ route('ATRoutes.get.getAll') }}",
            [
                {data: 'id'},
                {data: 'title', render: function(title){
                    return `<a href="#">${title}</a>`;
                }},
                {data: 'user'},
                {data: 'catagory.name'},
                {data: 'status', render: function(data){
                    if(data == "{{config('ATConfig.status.new')}}"){
                        return '1-' + data
                    }
                    else if(data == "{{config('ATConfig.status.in_progress')}}"){
                        return '2-' + data
                    }
                    else if(data == "{{config('ATConfig.status.answered')}}"){
                        return '3-' + data
                    }
                    else if(data == "{{config('ATConfig.status.closed')}}"){
                        return '4-' + data
                    }else{
                        return data
                    }
                }},
                {data: 'updated_at', render:function(data){
                    datetime = new Date(data);
                    date = datetime.toLocaleDateString('fa-IR');
                    time = datetime.toLocaleTimeString('fa-IR');
                    return '<span dir="auto" style="float: left">' + date + ' ' + time + '</span>';
                }}
            ],
            null,
            [4 ,'asc']
        );

        send_ajax_get_request(
            "{{ route('ATRoutes.get.getAll') }}",
            function(data){
                console.log(data);
            }
        )

        send_ajax_get_request(
            "{{ route('ATRoutes.get.getMyTickets') }}",
            function(data){
                update_datatable(data);
            }
        )

        table.on('click', 'tr', function(){
            var data = table.row( this ).data();
            if(data != undefined){
                show_comment_modal(data.id, data.title, data.user_id);
            }
        })
        function show_comment_modal(ticket_id, title ,user){
            var fd = new FormData();
            fd.append('ticket_id', ticket_id);
            send_ajax_formdata_request(
                "{{ route('ATRoutes.show.ticket') }}",
                fd,
                function(body){
                    open_admin_modal_with_data(body, title, function(){
                        $(".direct-chat-messages").animate({ scrollTop: $('.direct-chat-messages').prop("scrollHeight")}, 1);
                    });
                },
                function(data){
                    show_error(data);
                }
            )
        }
    </script>
@endsection