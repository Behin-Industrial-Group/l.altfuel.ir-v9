@extends('layouts.app')

@section('content')
    <div class="row ">
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
                    </div>
                </div>
            </div>
        </div>
        
        

        
    </div>
    <script>
        $.get('{{ url('admin/send-sms-3month-to-expired')}}', function(data){
            console.log(data);
            if(data > 0){
                alert('به ' + data + 'مرکز پیامک یاداوری تمدید پروانه کسب ارسال شد.')
            }
        })
        
    </script>
@endsection
