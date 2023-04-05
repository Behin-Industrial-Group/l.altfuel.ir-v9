@extends('layouts.app')
<?php
use App\Models\IssuesCatagoryModel;
use Illuminate\Support\Str;
$catagories = IssuesCatagoryModel::get();
?>

@section('title')
@endsection

<style>
#date{
    direction: ltr
}
</style>

@section('content')
    <div class="row">
        <form action="javascript:void(0)" id="created-form">
            <div class="box box-default col-sm-12">
                <div class="col-sm-3">
                    تاریخ ایجاد:
                </div>
                <div class="col-sm-3">
                    <label for="">از: </label>
                    <input type="text" name="created_from" id="created-from">
                </div>
                <div class="col-sm-3">
                    <label for="">تا: </label>
                    <input type="text" name="created_to" id="created-to">
                </div>
                <div class="col-sm-3">
                    <button class="btn btn-default" onclick="filtered()">اعمال فیلتر</button>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="box table-responsive">
            <div class="box-body">
                <table class="table table-bordered" id="issue_tbl">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>شماره گواهی سلامت</th>
                            <th>تاریخ صدور گواهی</th>
                            <th>کدملی مالک</th>
                            <th>نام مالک</th>
                            <th>موبایل مالک</th>
                            <th>نام متقاضی</th>
                            <th>موبایل متقاضی</th>
                            <th>نام خودرو</th>
                            <th>شاسی</th>
                            <th>پلاک</th>
                            <th>کد مرکز</th>
                            <th>نام مرکز</th>
                            <th>تاریخ ایجاد</th>
                            <th>تاریخ اپدیت</th>
                            <th>لینک</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $.get(`{{ route('admin.irngv.get.users.info') }}`, function(data){
            console.log(data);
        })
        $('#issue_tbl').DataTable({
            dom: 'Bfltip',
            buttons: [
                { 'extend': 'excel', 'text': 'Excel', className: 'btn btn-info'},
                { 'extend': 'pdf', 'PDF': 'Excel', className: 'btn btn-success'}
            ],
            columns: [
                { data: 'id' },
                { data: 'certificate_number' },
                { data: 'issued_date' },
                { data: 'owner_national_id' },
                { data: 'owner_fullname' },
                { data: 'owner_mobile' },
                { data: 'customer_fullname' },
                { data: 'customer_mobile' },
                { data: 'car_name' },
                { data: 'chassis' },
                { data: 'plaque' },
                { data: 'agency_code' },
                { data: 'agency_name' },
                { data: 'created_at' },
                { data: 'updated_at' },
                { data: 'link' , render: function(link){
                    return "{{ config('irngv.irngv-poll-link') }}" + link;
                } },
            ],
            'ajax': "{{ route('admin.irngv.get.users.info') }}"
        });

        $(document).ready(function () {
            $('#created-from').persianDatepicker({
                altFormat: 'X',
                format: 'YYYY-MM-D',
                observer: true
            });
        });
        $(document).ready(function () {
            $('#created-to').persianDatepicker({
                altFormat: 'X',
                format: 'YYYY-MM-D',
                observer: true
            });
        });

        function filtered(){
            var data = $('#created-form').serialize();
            send_ajax_request(
                "{{ route('admin.irngv.get.users.info') }}",
                data,
                function(data){
                    console.log(data);
                    $('#issue_tbl').dataTable().fnClearTable();
                    $('#issue_tbl').dataTable().fnAddData(data);
                }
            )
        }
    </script>
@endsection