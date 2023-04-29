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
                          <th>آدرس</th>
                          <th>موبایل</th>
                          <th>شناسه صنفی</th>
                          <th>تاریخ صدور</th>
                          <th>تاریخ انقضا</th>
                          <th>حق عضویت 96</th>
                          <th>حق عضویت 97</th>
                          <th>حق عضویت 98</th>
                          <th>حق عضویت 99</th>
                          <th>حق عضویت 00</th>
                          <th>حق عضویت 01</th>
                          <th>قفل</th>
                          <th>سامانه</th>
                          <th>بدهی</th>
                          <th>سبز</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach ($Marakez as $markaz)
                            <tr aria-valuenow="{{ $markaz->id }}" onclick="open_admin_modal('{{ route('admin.markaz.edit-form', [ 'id' => $markaz->id ]) }}')" class="markaz-row" <?php if( $markaz->FinGreen == 'ok') echo "style='background: #06c238'"  ?>>
                                <td><?php echo $i ?></td>
                                <td><?php echo $markaz->Name ?></td>
                                <td><?php echo $markaz->NationalID ?></td>
                                <td><?php echo $markaz->Province ?></td>
                                <td><?php echo $markaz->City ?></td>
                                <td><?php echo $markaz->CodeEtehadie ?></td>
                                <td>{{ $markaz->Address }}</td>
                                <td><?php echo $markaz->Cellphone ?></td>
                                <td><?php echo $markaz->GuildNumber ?></td>
                                <td><?php echo $markaz->IssueDate ?></td>
                                <td><?php echo $markaz->ExpDate ?></td>
                                <td class="cama-seprator"><?php echo $markaz->MembershipFee96 ?></td>
                                <td class="cama-seprator"><?php echo $markaz->MembershipFee97 ?></td>
                                <td class="cama-seprator"><?php echo $markaz->MembershipFee98 ?></td>
                                <td class="cama-seprator"><?php echo $markaz->MembershipFee99 ?></td>
                                <td class="cama-seprator"><?php echo $markaz->Membership00 ?></td>
                                <td class="cama-seprator"><?php echo $markaz->Membership01 ?></td>
                                <td class="cama-seprator"><?php echo $markaz->LockFee ?></td>
                                <td class="cama-seprator"><?php echo $markaz->IrngvFee ?></td>
                                <td class="cama-seprator"><?php echo $markaz->debt ?></td>
                                <td><?php echo $markaz->FinGreen ?></td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        function click_tr_to_edit () { 
            $('.markaz-row').hover(function(){
                $(this).css('cursor', 'pointer')
            })
        }

        click_tr_to_edit()
    </script>
    <script>
        $('.cama-seprator').each(function(){
            var x = $(this).html();
            var y = x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $(this).html(y)
        })
    </script>
@endsection

