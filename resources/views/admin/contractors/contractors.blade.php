@extends('layout.dashboard')

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-header">

            </div>
            <div class="box-body">
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="fixed" >
                        <tr>
                          <th>ردیف</th>
                          <th>نام</th>
                          <th>کدملی</th>
                          <th>تلفن</th>
                          <th>آدرس</th>
                          <th>ویرایش</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach ($Marakez as $markaz)
                            <tr <?php if( $markaz->FinGreen == 'ok') echo "style='background: green'"  ?>>
                                <td><?php echo $i ?></td>
                                <td><?php echo $markaz->name ?></td>
                                <td><?php echo $markaz->nationalId ?></td>
                                <td><?php echo $markaz->phone ?></td>
                                <td><?php echo $markaz->adress ?></td>
                                <td>
                                    <a href="contractors/show/{{$markaz->id}}">
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