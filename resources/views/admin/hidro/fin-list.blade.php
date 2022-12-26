@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-header">
                هیدرو - لیست مالی
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
                          <th>موبایل</th>
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
                            <tr aria-valuenow="{{ $markaz->id }}" class="markaz-row" <?php if( $markaz->FinGreen == 'ok') echo "style='background: #06c238'"  ?>>
                                <td><?php echo $i ?></td>
                                <td><?php echo $markaz->Name ?></td>
                                <td><?php echo $markaz->NationalID ?></td>
                                <td><?php echo $markaz->Province ?></td>
                                <td><?php echo $markaz->City ?></td>
                                <td><?php echo $markaz->CodeEtehadie ?></td>
                                <td><?php echo $markaz->Cellphone ?></td>
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
    @include('admin.hidro.edit-modal')
    <script>
        // $.get('{{ route("get-all-marakez") }}', function (rows) {
        //     $('#marakez').DataTable({
        //         data: rows, 
        //         columns: [
        //                 { data: 'id' },
        //                 { data: 'Name' },
        //                 { data: 'NationalID' },
        //                 { data: 'Province' },
        //                 { data: 'City' },
        //                 { data: 'CodeEtehadie' },
        //                 { data: 'Cellphone' },
        //                 { data: 'IssueDate' },
        //                 { data: 'ExpDate' },
        //                 { data: 'MembershipFee96' },
        //                 { data: 'MembershipFee97' },
        //                 { data: 'MembershipFee98' },
        //                 { data: 'MembershipFee99' },
        //                 { data: 'Membership00' },
        //                 { data: 'LockFee' },
        //                 { data: 'IrngvFee' },
        //                 { data: 'debt' },
        //                 { data: 'FinGreen' },
        //             ],
        //         "initComplete": function(settings, json) {
        //             click_tr_to_edit();
        //             open_edit_modal();
        //         },
        //         createdRow: function( row, data, dataIndex ) {
        //             $( row ).addClass(data);
        //         }
        //     })
        // })
        click_tr_to_edit()
        open_edit_modal()

        function click_tr_to_edit () { 
            $('.markaz-row').hover(function(){
                $(this).css('cursor', 'pointer')
            })
        }
        
        function open_edit_modal(){
            $('.markaz-row').click(function(){
                $('#modal-fin-edit').modal('show');
                var id = $(this).attr('aria-valuenow');
                $('input[name=markaz_id]').val(id);
                $.get(`{{ url('admin/hidro/get-info') }}/${id}`, function (data) { 
                    console.log(data.Membership00);
                    $("#markaz-fullname").html(data.Name)
                    $("#markaz-code").html(data.CodeEtehadie )

                    $("input[name=id]").val(data.id)

                    if(data.enable == '1')
                        $("input[name=enable]").prop('checked', true)
                    else
                        $("input[name=enable]").prop('checked', false)

                    $("input[name=ReceivingCodeYear]").val(data.ReceivingCodeYear)
                    $("input[name=NationalID]").val(data.NationalID)
                    $("input[name=Name]").val(data.Name)
                    
                    $("input[name=Province]").val(data.Province)
                    $("input[name=City]").val(data.City)
                    $("input[name=CodeEtehadie]").val(data.CodeEtehadie)
                    
                    $("input[name=GuildNumber]").val(data.GuildNumber)
                    $("input[name=IssueDate]").val(data.IssueDate)
                    $("input[name=ExpDate]").val(data.ExpDate)

                    $("input[name=PostalCode]").val(data.PostalCode)
                    $("input[name=Cellphone]").val(data.Cellphone)
                    $("input[name=Tel]").val(data.Tel)

                    $("input[name=Address]").val(data.Address)
                    $("input[name=Location]").val(data.Location)
                    $("input[name=Details]").val(data.Details)

                    if(data.InsUserDelivered == 'ok')
                        $("input[name=InsUserDelivered]").prop('checked', true)
                    else
                        $("input[name=InsUserDelivered]").prop('checked', false)

                    // SET VALUE OF FIN INFO INPUTS
                    $("input[name=MembershipFee96]").val(data.MembershipFee96)
                    $("input[name=MembershipFee96_PayDate]").val(data.MembershipFee96_PayDate)
                    $("input[name=MembershipFee96_Refid]").val(data.MembershipFee96_Refid)
                    
                    $("input[name=MembershipFee97]").val(data.MembershipFee97)
                    $("input[name=MembershipFee97_PayDate]").val(data.MembershipFee97_PayDate)
                    $("input[name=MembershipFee97_Refid]").val(data.MembershipFee97_Refid)
                    
                    $("input[name=MembershipFee98]").val(data.MembershipFee98)
                    $("input[name=MembershipFee98_PayDate]").val(data.MembershipFee98_PayDate)
                    $("input[name=MembershipFee98_Refid]").val(data.MembershipFee98_Refid)

                    $("input[name=MembershipFee99]").val(data.MembershipFee99)
                    $("input[name=MembershipFee99_PayDate]").val(data.MembershipFee99_PayDate)
                    $("input[name=MembershipFee99_Refid]").val(data.MembershipFee99_Refid)

                    $("input[name=Membership00]").val(data.Membership00)
                    $("input[name=Membership00_PayDate]").val(data.Membership00_PayDate)
                    $("input[name=Membership00_Refid]").val(data.Membership00_Refid)

                    $("input[name=Membership01]").val(data.Membership01)
                    $("input[name=Membership01_PayDate]").val(data.Membership01_PayDate)
                    $("input[name=Membership01_Refid]").val(data.Membership01_Refid)

                    $("input[name=debt]").val(data.debt)
                    $("input[name=debt_description]").val(data.debt_description)
                    $("input[name=def_refid]").val(data.debt_refid)

                    $("input[name=IrngvFee]").val(data.IrngvFee)
                    $("input[name=IrngvFee_PayDate]").val(data.IrngvFee_PayDate)
                    $("input[name=IrngvFee_Refid]").val(data.IrngvFee_Refid)

                    $("input[name=LockFee]").val(data.LockFee)
                    $("input[name=LockFee_PayDate]").val(data.LockFee_PayDate)
                    $("input[name=LockFee_Refid]").val(data.LockFee_Refid)

                    $("input[name=FinDetails]").val(data.FinDetails)

                    if(data.FinGreen == 'ok')
                        $("input[name=FinGreen]").prop('checked', true)
                    else
                        $("input[name=FinGreen]").prop('checked', false)



                })
            })
        }
    </script>
    <script>
        $('.cama-seprator').each(function(){
            var x = $(this).html();
            var y = x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $(this).html(y)
        })
    </script>
@endsection

