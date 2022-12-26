@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-header">

            </div>
            <div class="box-body">
                <div class="table-responsive">
                <table class="table table-striped" id="table">
                    <thead >
                        <tr>
                          <th>ردیف</th>
                          <th>نام</th>
                          <th>کدملی</th>
                          <th>استان</th>
                          <th>شهر</th>
                          <th>کداتحادیه</th>
                          <th>تلفن</th>
                          <th>موبایل</th>
                          <th>شماره صنفی</th>
                          <th>ادرس</th>
                          <th>تاریخ صدور</th>
                          <th>تاریخ انقضا</th>
                          <th>فعال</th>
                          <th>تحویل گیرنده قفل</th>
                          <th>ویرایش</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach ($Marakez as $markaz)
                            <tr <?php if( $markaz->FinGreen == 'ok') echo "style='background: #06c238'"  ?>>
                                <td><?php echo $i ?></td>
                                <td><?php echo $markaz->Name ?></td>
                                <td><?php echo $markaz->NationalID ?></td>
                                <td><?php echo $markaz->Province ?></td>
                                <td><?php echo $markaz->City ?></td>
                                <td><?php echo $markaz->CodeEtehadie ?></td>
                                <td><?php echo $markaz->Tel ?></td>
                                <td><?php echo $markaz->Cellphone ?></td>
                                <td><?php echo $markaz->GuildNumber ?></td>
                                <td><?php echo $markaz->Address ?></td>
                                <td><?php echo $markaz->IssueDate ?></td>
                                <td><?php echo $markaz->ExpDate ?></td>
                                <td><?php echo $markaz->enable ? 'فعال' : 'غیرفعال' ?></td>
                                <td><?php echo $markaz->Receiver ?></td>
                                <td>
                                    <a href="{{url("admin/marakez/edit/$markaz->id")}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
@endsection

