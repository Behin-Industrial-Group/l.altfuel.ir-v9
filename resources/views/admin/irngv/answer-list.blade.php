@extends('layouts.app')

@php
    use App\Enums\EnumsEntity as Enums;
@endphp

@section('title')
    نمایش اطلاعات پاسخ ها
@endsection

@section('content')
    <div class="panel" style="padding: 3px">
        <button class="btn btn-default" onclick="show_filters()" data-toggle="tooltip" title="نمایش فیلترها">
            <i class="fa fa-filter" aria-hidden="true"></i>
        </button>
    </div>
    <div class="row" id="filters" style="display: none">
        <form action="javascript:void(0)" id="created-form">
            <div class="box box-default col-sm-12">
                <div class="col-sm-12 m-2">
                    تاریخ ایجاد:
                </div>
                <div class="col-sm-12 m-2">
                    <label for="created-from-view">از: </label>
                    <input type="hidden" id="created-from" name="created_from">
                    <input type="text" id="created-from-view">
                </div>
                <div class="col-sm-12 m-2">
                    <label for="created-to-view">تا: </label>
                    <input type="hidden" id="created-to" name="created_to">
                    <input type="text"  id="created-to-view">
                </div>
                <div class="col-sm-12 m-2">
                    <button class="btn btn-primary" onclick="filtered()">اعمال فیلتر</button>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="box table-responsive">
            <div class="box-body">
                <p>
                    !!! راهنما !!! مقدار عددی جواب: خیلی کم برابر 1 و خیلی زیاد برابر 5 - بله برابر 1 خیر برابر 2
                </p>
                <table class="table table-bordered" id="poll-answer-table">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>کاربر</th>
                            <th>خودرو</th>
                            <th>شاسی</th>
                            <th>ش.گواهی سلامت</th>
                            <th>موبایل مالک</th>
                            <th>مرکز خدمات</th>
                            <th>تاریخ صدور گواهی</th>
                            <th>سوال</th>
                            <th>مقدار عددی جواب</th>
                            <th>جواب</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($rows as $row)
                            <tr>
                                <td></td>
                                <td>{{ $row->user->owner_fullname }}</td>
                                <td>{{ $row->user->car_name }}</td>
                                <td>{{ $row->user->chassis }}</td>
                                <td>{{ $row->user->certificate_number }}</td>
                                <td>{{ $row->user->owner_mobile }}</td>
                                <td>{{ $row->user->car_name }}</td>
                                <td>{{ $row->user->agency_code }} - {{ $row->user->agency_name }}</td>
                                <td>{{ $row->user->issued_date }}</td>
                                <td>{{ $row->question }}</td>
                                <td>{{ $row->answer }}</td>
                                <td>{{ $row->answer_value }}</td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#created-from-view').persianDatepicker({
                format: 'YYYY-MM-DD',
                toolbox: {
                    calendarSwitch: {
                        enabled: true
                    }
                },
                initialValue: false,
                observer: true,
                altField: '#created-from'
            });


            $('#created-to-view').persianDatepicker({
                format: 'YYYY-MM-DD',
                toolbox: {
                    calendarSwitch: {
                        enabled: true
                    }
                },
                initialValue: false,
                observer: true,
                altField: '#created-to'
            });
        });

        // send_ajax_request(
        //         '{{ route("irngvPoll.getAnswers") }}',
        //         $('#created-form').serialize(),
        //         function(data){
        //             console.log(data);
        //         }
        //     );
        function filtered(){
            send_ajax_request(
                '{{ route("irngvPoll.getAnswers") }}',
                $('#created-form').serialize(),
                function(data){
                    console.log(data);
                    update_datatable(data);
                }
            );
        }

        var table = create_datatable(
            "poll-answer-table",
            '{{ route("irngvPoll.getAnswers") }}',
            [
                {data: 'id'},
                {data: 'irngv_user.customer_fullname'},
                {data: 'irngv_user.car_name'},
                {data: 'irngv_user.chassis'},
                {data: 'irngv_user.certificate_number'},
                {data: 'irngv_user.owner_mobile'},
                {data: 'irngv_user', 'render': function(irngv_user){
                    if(irngv_user != undefined){
                        return `${irngv_user.agency_code} - ${irngv_user.agency_name}`;
                    }
                }},
                {data: 'irngv_user.issued_date'},
                {data: 'question_value'},
                {data: 'answer'},
                {data: 'answer_string'},
            ],
            null,
            [1, 'asc'],
        );




        function show_filters(){
            // if ($("#filters").css("display") == "none") {
            //     $('#filters').fadeIn(500);
            // } else {
            //     $('#filters').fadeOut(500);
            // }
            $("#filters").fadeToggle(500);

        }
    </script>
@endsection

