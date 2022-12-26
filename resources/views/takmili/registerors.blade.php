@extends('layout.welcome_layout')

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
                          <th>کدملی نسبت اصلی</th>
                          <th>نام</th>
                          <th>نام خانوادگی</th>
                          <th>کدملی</th>
                          <th>نسبت</th>
                          <th>تاریخ تولد</th>
                          <th>شماره شناسنامه</th>
                          <th>نام پدر</th>
                          <th>جنسیت</th>
                          <th>موبایل</th>
                          <th>تعداد افراد تحت تکفل</th>
                          <th>مبلغ پرداختی</th>
                          <th>کدرهگیری</th>
                          <th>تاریخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach ($registerors as $registeror)
                            <tr <?php if( !is_null( $registeror->mobile ) ) echo "style=' border-top: 5px solid red; '"; ?> >
                                <td><?php echo $i ?></td>
                                <td><?php echo $registeror->national_id ?></td>
                                <td><?php echo $registeror->takafol_fname ?></td>
                                <td><?php echo $registeror->takafol_lname ?></td>
                                <td><?php echo $registeror->takafol_nationalID ?></td>
                                <td><?php echo $registeror->takafol_relation ?></td>
                                <td><?php echo $registeror->takafol_birthDate ?></td>
                                <td><?php echo $registeror->takafol_birthCertificateNumber ?></td>
                                <td><?php echo $registeror->takafol_father ?></td>
                                <td><?php echo $registeror->takafol_gender ?></td>
                                <td><?php echo $registeror->mobile ?></td>
                                <td><?php echo $registeror->numberOfTakafolPerson ?></td>
                                <td><?php echo $registeror->price ?></td>
                                <td><?php echo $registeror->RefID ?></td>
                                <td><?php echo $registeror->created_at ?></td>
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