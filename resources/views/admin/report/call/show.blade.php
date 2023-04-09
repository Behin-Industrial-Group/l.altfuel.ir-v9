@extends('layouts.app')
@section('content')
    <div class="box table-responsive">
        <div class="box ">
            <form action="javascript:void(0)" id="date-form"></form>
            <label for="date">تاریخ:</label>        
            <input list="date_list" id="date" class="form-control">
            <button id="get_data" onclick="get_data()">نمایش</button>
        </div>
        <p id="test"></p>
        <div>
            <table class="table table-striped" id="report_tbl">
                <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>داخلی</th>
                        <th>نام</th>
                        <th>درصد پاسخ</th>
                        <th>مدت پاسخ</th>
                        <th>درصد بی پاسخ</th>
                        <th>مدت بی پاسخ</th>
                        <th>درصد مشغولی</th>
                        <th>تعداد کل</th>
                        <th>عملکرد پاسخ</th>
                        <th>عملکرد مشغولی</th>
                        <th>میانگین</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#date').persianDatepicker({
                altFormat: 'X',
                format: 'YYYY-MM-D',
                observer: true,
                timePicker: {
                    enabled: true
                },
            });
        });
        var table = create_datatable(
            'report_tbl',
            "{{ route('report.call.get_data') }}",
            [
                {data: 'id'},
                {data: 'ext'},
                {data: 'name'},
                {data: 'answer_percent'},
                {data: 'answer_time'},
                {data: 'unanswer_percent'},
                {data: 'unanswer_time'},
                {data: 'busy_percent'},
                {data: 'total'},
                {data: 'answer_eff'},
                {data: 'busy_eff'},
                {data: 'avg'},
            ]
        )

        

        function get_data(){
            var url = "{{ route('report.call.get_data', [ 'date' => 'date' ]) }}";
            url = url.replace('date', $('#date').val() );
            send_ajax_get_request(
                url,
                function(data){
                    console.log(data);
                    update_datatable(data)
                }
            );
        }
    </script>
@endsection