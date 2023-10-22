@extends('layouts.app')

@section('style')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    {{-- تعداد مرخصی ها --}}

    <div class="row">
        @if (auth()->user()->access('MkhodrooProcessMaker.report.numberOfMyVacation'))
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
                        <p> مرخصی ها</p>
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
        @endif

        {{-- اطلاعات نظرسنجی تلفن ها --}}
        @foreach ($voip_poll_info as $key => $value)
            @if (auth()->user()->access('اطلاعات نظرسنجی تلفنها - ' . $value['name']))
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>
                                <table>
                                    <tr>
                                        <td id="numberOfTotal">{{ $value['count'] }}</td>
                                        <td>
                                            <p>تعداد</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td id="score">{{ number_format($value['score_avg'], 2) }}</td>
                                        <td>
                                            <p>میانگین امتیاز</p>
                                        </td>
                                    </tr>
                                </table>
                            </h3>
                            <p> {{ $value['name'] }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <p style="text-align: center" onclick="getPeerPollInfo('{{ $value['queue_num'] }}')">More info <i
                                class="fa fa-arrow-circle-right"></i></p>
                    </div>
                </div>
            @endif
        @endforeach
        <script>
            function getPeerPollInfo(queue_num) {
                url = '{{ route('voip.getPeerPollInfo', ['queue_num' => 'queue_num']) }}';
                url = url.replace('queue_num', queue_num);
                open_admin_modal(url)
            }
        </script>



        {{-- آنلاین بودن تلفن روی سرور --}}
        <script>

            var intervalId = window.setInterval(function() {
                const d = new Date();
                let hour = d.getHours();

                if (hour == "8" || hour == "9") {
                    console.log(hour);
                    $.get('{{ route('voip.sipShowPeers') }}', function(response) {
                        console.log(response);
                    })
                }
            }, 60000);
        </script>



    </div>



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
@endsection
