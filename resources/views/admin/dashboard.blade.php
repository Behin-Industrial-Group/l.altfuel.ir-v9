@extends('layouts.app')

@section('style')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    {{-- تعداد مرخصی ها --}}
    @if (auth()->user()->access('MkhodrooProcessMaker.report.numberOfMyVacation'))
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>
                        <table>
                            <tr>
                                <td id="numberOfMyVacationDays">...</td>
                                <td>
                                    <p>روز</p>
                                </td>
                            </tr>
                            <tr>
                                <td id="numberOfMyVacationHours">...</td>
                                <td>
                                    <p>ساعت</p>
                                </td>
                            </tr>
                        </table>
                    </h3>
                    <p>تعداد مرخصی ها</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            <script>
                $.get('{{ route('MkhodrooProcessMaker.report.numberOfMyVacation') }}', function(response) {
                    console.log(response);
                    $('#numberOfMyVacationDays').html(response.daily);
                    $('#numberOfMyVacationHours').html(response.hourly);
                })
            </script>
        </div>
    </div>
    @endif

    <div class="row">
        @if (auth()->user()->access('report.tickets.numberOfEachCatagory'))
            <div class="col-sm-4">
                <canvas class="card" id="myChart"></canvas>
            </div>
            <script>
                send_ajax_get_request(
                    '{{ url('admin/report/tickets/number-of-each-catagory') }}',
                    function(response) {
                        var canvas = document.getElementById("myChart");
                        var ctx = canvas.getContext("2d");
                        var midX = canvas.width / 2;
                        var midY = canvas.height / 2

                        var myPieChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: response.labels,
                                datasets: [{
                                    label: '# تعداد',
                                    data: response.data,
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                onAnimationProgress: drawSegmentValues
                            }
                        });


                        function drawSegmentValues() {
                            for (var i = 0; i < myPieChart.segments.length; i++) {
                                ctx.fillStyle = "white";
                                var textSize = canvas.width / 10;
                                ctx.font = textSize + "px Verdana";
                                // Get needed variables
                                var value = myPieChart.segments[i].value;
                                var startAngle = myPieChart.segments[i].startAngle;
                                var endAngle = myPieChart.segments[i].endAngle;
                                var middleAngle = startAngle + ((endAngle - startAngle) / 2);
                                var posX = (radius / 2) * Math.cos(middleAngle) + midX;
                                var posY = (radius / 2) * Math.sin(middleAngle) + midY;
                                var w_offset = ctx.measureText(value).width / 2;
                                var h_offset = textSize / 4;
                                ctx.fillText(value, posX - w_offset, posY + h_offset);
                            }
                        }
                    }
                )
            </script>
        @endif
        @if (auth()->user()->access('report.tickets.statusInEachCatagory'))
            <div class="col-sm-8">
                <div class="card" id="statusInEachCatagory" style="height: 400px">در حال بارگیری...</div>
            </div>
            <script>
                send_ajax_get_request(
                    '{{ url('admin/report/tickets/status-in-each-catagory') }}',
                    function(response) {
                        console.log(response.labels);
                        var labels = [
                            ['دسته بندی', 'پاسخ داده شده', 'جدید']
                        ];
                        var i = 1;
                        response.labels.forEach(function(label) {
                            labels[i] = [label.catagory];
                            var answered = label.count.filter(function(status) {
                                if (status.status == "پاسخ داده شده") {
                                    return status.status;
                                }
                            })
                            if (answered.length > 0) {
                                labels[i][1] = parseInt(answered[0].total);
                            } else {
                                labels[i][1] = 0;
                            }

                            var newStatus = label.count.filter(function(status) {
                                if (status.status == "جدید") {
                                    return status.status;
                                }
                            })
                            if (newStatus.length > 0) {
                                labels[i][2] = parseInt(newStatus[0].total);
                            } else {
                                labels[i][2] = 0;
                            }
                            i++;
                        })
                        google.charts.load('current', {
                            packages: ['corechart', 'bar']
                        });
                        google.charts.setOnLoadCallback(drawBasic);

                        function drawBasic() {

                            var data = google.visualization.arrayToDataTable(labels);

                            var options = {
                                title: 'تعداد تیکت ها به تفکیک وضعیت در هفت روز گذشته',
                                chartArea: {
                                    width: '75%'
                                },
                                hAxis: {
                                    title: 'دسته بندی',
                                    minValue: 0
                                },
                                vAxis: {
                                    title: 'تعداد'
                                },
                                isStacked: true,
                                pieSliceText: 'label',
                            };

                            var chart = new google.visualization.ColumnChart(document.getElementById('statusInEachCatagory'));

                            chart.draw(data, options);
                        }
                    }
                )
            </script>
        @endif

    </div>


    {{-- <div class="row ">
        <div class="col-sm-4">
            <div class="box box-info box-solid">
                <div class="box-header"><h4>کد تخفیف ها</h4></div>
                
                <p id="mopon" style="overflow: auto; height: 500px"></p>
            </div>
            <script>
                $('#mopon').html('درحال دریافت اطلاعات...')
                $.get('https://one-api.ir/mopon/?token=171606:61ea9dd9560c33.10046944&action=all', function(data){
                    $('#mopon').html('')
                    var all = data.result;
                    console.log(all);
                    $.each(all, function(i, item){
                        $('#mopon').html( $('#mopon'). html() + `<a target='_blank' href='${all[i].data.link}'>${all[i].data.title} </a>*** کد: ${all[i].data.code}` + '<hr>' )
                    })
                })
            </script>
        </div>
        
        <div class="col-sm-8">
            <div class=" col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-aqua"><i class="fa fa-sort-numeric-asc"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">کل تیکتها</span>
                    <span class="info-box-number" id="issues-count">
                        <script>
                            $.get('{{ url('admin/report/count-issues')}}', function(data){
                                $('#issues-count').html(data)
                            })
                        </script>
                    </span>
                  </div>
                </div>
            </div>
            <div class=" col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-aqua"><i class="fa fa-sort-numeric-asc"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">تیکت های امروز</span>
                    <span class="info-box-number" id="today-issues-count">
                        <script>
                            $.get('{{ url('admin/report/count-today-issues')}}', function(data){
                                $('#today-issues-count').html(data)
                            })
                        </script>
                    </span>
                  </div>
                </div>
            </div>
            <div class=" col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-aqua"><i class="fa fa-sort-numeric-asc"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">جواب داده های من از 1400/11/01 تاکنون</span>
                    <span class="info-box-number" id="my-answered-issues">
                        <script>
                            $.get('{{ url('admin/report/count-my-answered-issues')}}', function(data){
                                $('#my-answered-issues').html(data)
                            })
                        </script>
                    </span>
                  </div>
                </div>
            </div>
            <div class=" col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-aqua"><i class="fa fa-sort-numeric-asc"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">جواب داده های امروز من</span>
                    <span class="info-box-number" id="my-today-answered-issues">
                        <script>
                            $.get('{{ url('admin/report/count-my-today-answered-issues')}}', function(data){
                                $('#my-today-answered-issues').html(data)
                            })
                        </script>
                    </span>
                  </div>
                </div>
            </div>
            <div class="col-sm-6" style="height: 250px; overflow:auto">
                <div class="box box-success box-solid">
                    <div class="box-header"><h4>پیامک های ارسال شده</h4></div>
                    <div class="box-body">
                        <table class="table" id="3month-sms">
                            <thead>
                                <tr>
                                    <th>شناسه</th>
                                    <th>کدمرکز</th>
                                    <th>تاریخ ارسال</th>
                                </tr>
                            </thead>
                        </table>
                        <script>
                            $(document).ready(function() {
                                $('#3month-sms').DataTable( {
                                    "ajax": "{{ url('admin/get-3month-sms-sended-list') }}",
                                    "columns": [
                                        { "data": "id" },
                                        { "data": "CodeEtehadie" },
                                        { "data": "SmsSended_3MonthsToExp" },
                                    ],
                                    "info": false,
                                    "lengthChange": false,
                                } );
                            } );
                        </script>
                    </div>
                </div>
                
            </div>
            <div class="col-sm-6">
                <div class="box box-danger box-solid">
                    <div class="box-header"><h4>بازی</h4></div>
                    <div class="box-body">
                        {{-- <iframe src="https://www.vaajoor.ir/" frameborder="0" width="100%" height="400px"></iframe> --}}
    {{-- </div>
    </div>
    </div>
    </div> --}}




    {{-- </div>
    <script>
        $.get('{{ url('admin/send-sms-3month-to-expired') }}', function(data) {
            console.log(data);
            if (data > 0) {
                alert('به ' + data + 'مرکز پیامک یاداوری تمدید پروانه کسب ارسال شد.')
            }
        })
    </script> --}}
@endsection
