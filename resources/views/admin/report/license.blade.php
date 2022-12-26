@extends('layouts.app')
@section('content')
    <div class="box table-responsive">
        <p id="test"></p>
        <div>
            <table class="table table-striped" id="report_tbl">
                
                <tbody>
                    <tr>
                        <form action="javascript:void(0)" id="license_request_form">
                            @csrf
                            <td>فایل تمامی درخواست ها: </td>
                            <td><input type="file" name="LicenseRequest" id=""></td>
                            <td><input type="submit" name="" id="upload_license_request" value="Upload"></td>
                        </form>
                    </tr>
                    <tr>
                        <form action="javascript:void(0)" id="license_form">
                            @csrf
                            <td>فایل اکسل تمامی پروانه کسب های غیر ایثارگری:</td>
                            <td><input type="file" name="License" id=""></td>
                            <td><input type="submit" name="" id="upload_license" value="Upload"></td>
                        </form>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <button class="btn btn-success form-control" id="calculate_time">محاسبه میانگین زمان صدور پروانه کسب</button>
                        </td>
                    </tr>

                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>
    <div class="box table-responsive">
        <label for=""> درخواست هایی که صادر نشده اند و بیشتر از 90 روز از تاریخ درخواست آنها گذشته است</label>
        <table class="table table-striped" id="more_than_90_days_non_issued_record">
            <thead>
                <tr>
                    <th>کدرهگیری</th>
                    <th>نام</th>
                    <th>نام خانوادگی</th>
                    <th>استان</th>
                    <th>تاریخ درخواست</th>
                    <th>وضعیت</th>
                    <th>فاصله تا امروز(روز)</th>
                </tr>
            </thead>
            <tbody id="">

            </tbody>
        </table>
    </div>
    <div class="box table-responsive">
        <label for="">صادر شده ها</label>
        <table class="table table-striped" id="issued_time_avg_records">
            <thead>
                <tr>
                    <th>کدرهگیری</th>
                    <th>نام</th>
                    <th>نام خانوادگی</th>
                    <th>استان</th>
                    <th>تاریخ درخواست</th>
                    <th>تاریخ صدور</th>
                    <th>نوع درخواست</th>
                    <th>مدت زمان صدور(روز)</th>
                </tr>
            </thead>
            <tbody id="">

            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $('#upload_license_request').click(function(){
            var form = document.querySelector('#license_request_form');
            var fd = new FormData(form);
            $.ajax({
                url: '{{ url("admin/report/license/upload-license-request") }}',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(data){
                    alert(data);
                }
            });
        })

        $('#upload_license').click(function(){
            var form = document.querySelector('#license_form');
            var fd = new FormData(form);
            $.ajax({
                url: '{{ url("admin/report/license/upload-license") }}',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(data){
                    alert(data);
                }
            });
        })

        $('#calculate_time').click(function(){
            $.get('{{ url("admin/report/license/calculate-time") }}', function(data){
                alert(data.issued_time_avg)
                console.log(data);
                var tbody = $('#more_than_90_days_non_issued_record');
                $('#more_than_90_days_non_issued_record').DataTable({
                    data: data.more_than_90_days_non_issued_record,
                    columns: [
                        { data: 'tracking_code' },
                        { data: 'name' },
                        { data: 'fname' },
                        { data: 'province' },
                        { data: 'request_date' },
                        { data: 'status' },
                        { data: 'diff' }
                    ],
                    dom: 'Bfltip',
                    buttons: [
                        { 'extend': 'excel', 'text': 'Excel', className: 'btn btn-info'},
                    ],
                });
                $('#issued_time_avg_records').DataTable({
                    data: data.issued_time_avg_records,
                    columns: [
                        { data: 'tracking_code' },
                        { data: 'name' },
                        { data: 'fname' },
                        { data: 'province' },
                        { data: 'request_date' },
                        { data: 'issued_date' },
                        { data: 'request_type' },
                        { data: 'diff' }
                    ],
                    dom: 'Bfltip',
                    buttons: [
                        { 'extend': 'excel', 'text': 'Excel', className: 'btn btn-info'},
                    ],
                })
                
            });
        })
    </script>
@endsection