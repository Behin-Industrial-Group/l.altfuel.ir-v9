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
                            {{$message}}
                        </div>
                    @endif
                    @if( isset( $error ) )
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endif
                </div>
                <div class="box-body">
                    <div class="col-sm-10">
                        <table class="table table-striped table-bordered" id="table">
                            <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>کدملی بازرس</th>
                                    <th>نام بازرس</th>
                                    <th>مرکز خدمات</th>
                                    <th>تخصیص</th>
                                    <th>توضیحات شرکت بازرسی</th>
                                    <th>توضیحات کارشناس اتحادیه</th>
                                    <th>تاریخ ایجاد</th>
                                    <th>تاریخ اقدام</th>
                                </tr>
                            </thead>
                            @foreach($asignInsRequest as $r)
                            <tr>
                                <td></td>
                                <td>{{ $r->ins_nationalId }}</td>
                                <td>{{ $r->ins_fname }} {{ $r->ins_lname }}</td>
                                <td>{{ $r->markaz_code }}</td>
                                <td>{{ Enum::$AsignType[$r->asign]['value'] }}</td>
                                <td>{{ $r->ins_description }}</td>
                                <td>{{ $r->description }}</td>
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
                                <td>
                                    @if($r->updated_at == date('Y-m-d H:i:s'))
                                        تاریخ ثبت نشده است
                                        @elseif(in_array(explode("-", $r->updated_at)[0], ['1397','1398','1399','1997','1998','1999']))
                                        <?php
                                        $updated = "$r->updated_at";
                                        $updated[0] = 1;
                                        $updated[1] = 3;
                                        $r->updated_at = $updated;
                                        ?>
                                        {{ $r->updated_at }}
                                    @else
                                        {{ Verta::instance($r->updated_at) }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
