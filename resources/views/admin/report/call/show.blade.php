@extends('layouts.app')
@section('content')
    <div class="box box-info">
        <form action="javascript:void(0)" id="date-form"></form>
        <table>
            <tr>
                <td>
                    <label for="date">تاریخ:</label>        
                </td>
                <td>
                    <input list="date_list" id="date" class="form-control">
                </td>
                <td>
                    <button id="get_data" onclick="get_data()">نمایش</button>
                </td>
            </tr>
        </table>
    </div>
    <div class="box table-responsive">
        
        <p id="test"></p>
        <div>
            <table class="table table-striped" id="report_tbl" style="text-align: center">
                <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>داخلی</th>
                        <th>نام</th>
                        <th>پاسخ</th>
                        <th>مدت پاسخ</th>
                        <th>بی پاسخ</th>
                        <th>مشغولی</th>
                        <th>تعداد کل</th>
                        <th>عملکرد پاسخ</th>
                        <th>عملکرد مشغولی</th>
                        <th>میانگین</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="13">
                            <div class="alert alert-danger">حداکثر تعداد تماس بی پاسخ مجاز = {{ config('app.report.call.max_unanswer_number') }}</div>
                        </td>
                    </tr>
                </tfoot>
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
                {data: 'answer', render: function(data){
                    return `${data.number}<br><span style="color: rgba(0,0,0,0.3)">(${data.percent} %)</span>`;
                }},
                {data: 'answer_time', render: function(data){
                    var answer_min = Math.round(data /60);
                    return `${answer_min} دقیقه`;
                }},
                {data: 'unanswer', render: function(data){
                    return `<span style="width: 100%; display: block;background: rgba(252, 3, 3,${data.percent/100})">${data.number}
                        <br> <span style="color: rgba(0,0,0,0.3)">(${data.percent} %)</span></span>`;
                }},
                {data: 'busy', render: function(data){
                    return `${data.number}<br> <span style="color: rgba(0,0,0,0.3)">(${data.percent} %)</span>`;
                }},
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