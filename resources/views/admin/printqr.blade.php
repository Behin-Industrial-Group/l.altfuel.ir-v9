@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-header">

            </div>
            <div class="box-body table-responsive">
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام</th>
                            <th>کداتحادیه</th>
                            <th>دریافت کننده</th>
                            <th>بچ</th>
                            <th>پلاک خوان</th>
                            <th>نمایش</th>
                            <th>ویرایش</th>
                        </tr>
                    </thead>
                    <?php $i =1 ?>
                    @foreach ($rows as $row)
                        <tr>
                            <td> {{$i}} </td>
                            <td>{{$row->Name}}</td>
                            <td>{{$row->CodeEtehadie}}</td>
                            <td>{{$row->Receiver}}</td>
                            <td>{{$row->Batch}}</td>
                            <td>{{$row->PlateReader}}</td>
                            <td><a href="{{Url("public/qrimages/$row->CodeEtehadie.jpg")}}" target="_blank"><i class="fa fa-eye"></a></td>
                            <td><a href="{{Url("/admin/editqr/$row->id")}}"><i class="fa fa-edit"></a></td>
                        </tr>
                        <?php $i++ ?>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection