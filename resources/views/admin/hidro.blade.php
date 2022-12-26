@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-header">

            </div>
            <div class="box-body">
                <div class="table-responsive">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                          <th>ردیف</th>
                          <th>نام</th>
                          <th>استان</th>
                          <th>موبایل</th>
                          <th>کداتحادیه</th>
                          <th>شماره صنفی</th>
                          <th>تاریخ صدور</th>
                          <th>تاریخ انقضا</th>
                          <th>ویرایش</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach ($Marakez as $markaz)
                            <tr <?php if( $markaz->FinGreen == 'ok') echo "style='background: #06c238'"  ?>>
                                <td><?php echo $i ?></td>
                                <td><?php echo $markaz->Name ?></td>
                                <td><?php echo $markaz->Province ?></td>
                                <td><?php echo $markaz->Cellphone ?></td>
                                <td><?php echo $markaz->CodeEtehadie ?></td>
                                <td><?php echo $markaz->GuildNumber ?></td>
                                <td><?php echo $markaz->IssueDate ?></td>
                                <td><?php echo $markaz->ExpDate ?></td>

                                <td>
                                    <a href="hidro/show/{{$markaz->id}}">
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
