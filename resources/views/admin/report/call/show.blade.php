@extends('layouts.app')
@section('content')
    <div class="box table-responsive">
        <p id="test"></p>
        <div>
            <table class="table table-striped" id="report_tbl">
                <thead>
                    <tr>
                        <td><label for="date">تاریخ</label></td>
                        <td colspan="2"><input list="date_list" id="date" class="form-control"></td>
                        <td><button id="get_data">نمایش</button></td>
                    </tr>
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
                <tbody>

                </tbody>
                <tfoot>

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
        $('#get_data').on('click', function(){
            $('#report_tbl tbody').html('');
            var date = $('#date').val();
            if(date.length == 10){
                $.get("{{url('admin/report/call/show')}}/" + date, function(data){
                    data = jQuery.parseJSON(data);
                    $.each(data,function(index, value){
                        var answer_eff = parseFloat(data[index].answer_percent)*100 / (parseFloat(data[index].answer_percent) + parseFloat(data[index].unanswer_percent));
                        var a = data[index].answer_time / 8;
                        var b = parseFloat(data[index].busy_percent) * data[index].total /100;
                        var busy_eff = (a-b)/a *100;
                        var avg = (answer_eff + busy_eff) / 2;
                        var tr = "<tr>";
                            tr += "<td>"+ data[index].id + "</td>";
                            tr += "<td>"+ data[index].ext + "</td>";
                            tr += "<td>"+ data[index].name + "</td>";
                            tr += "<td>"+ data[index].answer_percent + "</td>";
                            tr += "<td>"+ data[index].answer_time + "</td>";
                            tr += "<td>"+ data[index].unanswer_percent + "</td>";
                            tr += "<td>"+ data[index].unanswer_time + "</td>";
                            tr += "<td>"+ data[index].busy_percent + "</td>";
                            tr += "<td>"+ data[index].total + "</td>";
                            tr += "<td>"+ parseInt(answer_eff) + "</td>";
                            tr += "<td>"+ parseInt(busy_eff)  + "</td>";
                            tr += "<td id='avg'>"+ parseInt(avg)  + "</td>";
                            tr += "</tr>";
                        $('#report_tbl').append(tr);
                    });
                });
            }
        });
    </script>
@endsection