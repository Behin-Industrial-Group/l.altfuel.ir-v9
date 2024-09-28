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
            'ajax': "{{ route('irngvPoll.getInfos') }}"
        });

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

        function show_filters(){
            // if ($("#filters").css("display") == "none") {
            //     $('#filters').fadeIn(500);
            // } else {
            //     $('#filters').fadeOut(500);
            // }

            $("#filters").fadeToggle(500);
        }

        function filtered(){
            var data = $('#created-form').serialize();
            send_ajax_request(
                "{{ route('irngvPoll.getInfos') }}",
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
