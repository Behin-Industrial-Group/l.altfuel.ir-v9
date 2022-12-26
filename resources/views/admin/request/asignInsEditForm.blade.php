@extends( 'layouts.app' )

<?php
use App\Enums\EnumsEntity as Enum;
?>

@section( 'title' )
    ثبت درخواست جدید تخصیص بازرس
@endsection


@section( 'content' )
    <div class="row">
        @include('includes.back-to-list', [ 'url' => route('request.show.all', [ 'id' => 'all']) ])
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
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
                    <div class="">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>نوع درخواست</th>
                                    <th>مشخصات شرکت بازرسی</th>
                                    <th>مرکز</th>
                                    <th>تاریخ ایجاد</th>
                                    <th>وضعیت</th>
                                    <th>تاریخ اقدام</th>
                                    <th>ارسال</th>
                                </tr>
                            </thead>
                            @foreach ($asignInsRequest as $item)
                                <form method="post" action="<?php echo Url( "admin/request/asign/ins/edit/$item->id" ) ?>">
                                    @csrf
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{Enum::$RequestType[$item->type]}}</td>
                                        <td>
                                            {{$item->ins_nationalId}} |
                                            {{$item->ins_fname}}
                                            {{$item->ins_lname}} |
                                            {{$item->ins_cellphone}} <br/>
                                            {{$item->display_name}} <br/>
                                            @if (empty($item->ins_description))
                                                توضیحات ندارد
                                            @else
                                                {{$item->ins_description}}
                                            @endif
                                        </td>
                                        <td>
                                            {{$item->markaz_code}}
                                        </td>
                                        <td>
                                            @if($item->created_at == date('Y-m-d H:i:s'))
                                                تاریخ ثبت نشده است
                                            @elseif(in_array(explode("-", $item->created_at)[0], ['1397','1398','1399','1997','1998','1999']))
                                                <?php
                                                $created = "$item->created_at";
                                                $created[0] = 1;
                                                $created[1] = 3;
                                                $item->created_at = $created;
                                                ?>
                                                {{ $item->created_at }}
                                            @else
                                                {{ Verta::instance($item->created_at) }}
                                            @endif
                                        </td>
                                        <td>
                                            <select class="col-sm-12 select2" name="asign" dir="rtl" required>
                                                @foreach (Enum::$AsignType as $option)
                                                    <option
                                                        value="{{$option['key']}}"
                                                        <?php if($item->asign == $option['key']) echo "selected"  ?>
                                                    >
                                                        {{$option['value']}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            توضیحات:
                                            <textarea type="text" name="description" class="form-control">{{ $item->description }}</textarea>
                                            یادداشت: (فقط به کارشناس اتحادیه نمایش داده میشود)
                                            <textarea type="text" name="comment" class="form-control">{{ $item->comment }}</textarea>
                                        </td>
                                        <td>
                                            {{Verta::instance($item->updated_at)}}
                                        </td>
                                        <td>
                                            <input type="submit"  class="btn btn-success" value="ثبت">
                                        </td>
                                    </tr>
                                </form>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
