@extends( 'layouts.app' )

@section( 'title' )
    لیست درخواست های تخصیص بازرس
@endsection

<?php
use App\Enums\EnumsEntity as Enum;
?>

@section( 'content' )
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    لیست درخواست های تخصیص بازرس
                    @if( isset( $message ) )
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif
                    @if( isset( $error ) )
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endif
                </div>
                <div class="box-body">
                    <div class="col-sm-12">
                        <a href="<?php echo url("admin/request/asign/ins/show/all") ?>"><button class="btn btn-success">همه</button></a>
                        <a href="<?php echo url("admin/request/asign/ins/show/0") ?>"><button class="btn btn-success">دیده نشده ها</button></a>
                        <a href="<?php echo url("admin/request/asign/ins/show/1") ?>"><button class="btn btn-success">تخصیص داده شده</button></a>
                        <a href="<?php echo url("admin/request/asign/ins/show/2") ?>"><button class="btn btn-success">رد شده</button></a>
                    </div>
                    <div class="col-sm-12">
                        <table class="table table-striped table-bordered" id="list">
                            <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>نوع</th>
                                    <th>شرکت بازرسی</th>
                                    <th>کدملی بازرس</th>
                                    <th>نام بازرس</th>
                                    <th>مرکز خدمات</th>
                                    <th>تخصیص</th>
                                    <th>توضیحات شرکت بازرسی</th>
                                    <th>توضیحات کارشناس اتحادیه</th>
                                    <th>یادداشت کارشناس اتحادیه</th>
                                    <th>تاریخ ایجاد</th>
                                    <th>ویرایش</th>
                                </tr>
                            </thead>
                            <?php $i=1; ?>
                            @foreach($asignInsRequest as $r)
                            <tr>
                                <th>{{ $r->id }}</th>
                                <th><?php
                                    if($r->type == "asign"){
                                        echo "تخصیص";
                                    }
                                    if($r->type == "remove"){
                                        echo "حذف";
                                    }
                                    ?>
                                </th>
                                <th>{{ $r->display_name }}</th>
                                <th>{{ $r->ins_nationalId }}</th>
                                <th>{{ $r->ins_fname }} {{ $r->ins_lname }}</th>
                                <th>{{ $r->markaz_code }}</th>
                                <th>{{ Enum::$AsignType[$r->asign]['value'] }}</th>
                                <td>{{ $r->ins_description }}</td>
                                <td>{{ $r->description }}</td>
                                <td>{{ $r->comment }}</td>
                                <td>
                                    @if($r->created_at == date('Y-m-d H:i:s'))
                                        تاریخ ثبت نشده است
                                    @elseif(in_array(explode("-", $r->created_at)[0], ['1397','1398','1399','1997','1998','1999']))
                                        <?php
                                        $created = "$r->created_at";
                                        $created[0] = 1;
                                        $created[1] = 3;
                                        $r->created_at = $created;
                                        ?>
                                        {{ $r->created_at }}
                                    @else
                                        {{ Verta::instance($r->created_at) }}
                                    @endif
                                </td>
                                <th><a href="<?php echo Url("admin/request/asign/ins/edit/$r->markaz_code") ?>">{{$r->markaz_code}}<li class="fa fa-edit"></li></a></th>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#list').DataTable({
                dom: 'Bfltip',
                buttons: [
                    { 'extend': 'excel', 'text': 'Excel', className: 'btn btn-info'},
                    { 'extend': 'pdf', 'PDF': 'Excel', className: 'btn btn-success'}
                ],
                'ajax': '',
                "order": [[ 0, 'desc' ]]
            });
        });
    </script>
@endsection
