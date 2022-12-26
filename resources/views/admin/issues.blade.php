@extends('layouts.app')
<?php
use App\Models\IssuesCatagoryModel;
use Illuminate\Support\Str;
$catagories = IssuesCatagoryModel::get();
?>

@section('title')
    تیکت ها - {{$catagory}}
@endsection

<style>
#date{
    direction: ltr
}
</style>

@section('content')
    <div class="row">
        <div class="box table-responsive">
            <div class="box-header">
                <a href=<?php echo Url("admin/issues/show/$catagory/tracking-later") ?>>
                    <button class="btn btn-danger">
                        تیکت های نیاز به پیگیری
                    </button>
                </a>
                
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="issue_tbl">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>شماره</th>
                            <th>نام و نام خانوادگی</th>
                            <th>موبایل</th>
                            <th id="date">تاریخ آپدیت</th>
                            <th>متن پیام</th>
                            <th>وضعیت</th>
                            <th>نمایش</th>
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
            <?php
                if($tracking_later == 'tracking-later'){
                    $url = url("admin/issues/get/$catagory/tracking-later");
                }
                else{
                    $url = url("admin/issues/get/$catagory");
                }
                    
            ?>
            'ajax': "{{$url}}"
        });
    </script>
@endsection