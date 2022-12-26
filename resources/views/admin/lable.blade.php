@extends('layouts.app')


@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    @if (!empty($Message))
                        <div class="alert alert-success">
                            {{ $Message }}
                        </div>
                    @endif
                    @if (!empty($Error))
                        <div class="alert alert-success">
                            {{ $Error }}
                        </div>
                    @endif
                    </div>
                        <div class="box-body">
                            <div class="table-response">
                            <table class="table table-bordered table-hover" id="table">
                                <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>کد مرکز</th>
                                    <th>مدیر مرکز</th>
                                    <th>کد پیگیری</th>
                                    <th>پکیج</th>
                                    <th>تاریخ</th>
                                    <th>شماره شروع</th>
                                    <th>شماره پایان</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                @foreach ($lables as $lable)
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $lable->Markaz_ID ?></td>
                                        <td><?php echo $lable->Name ?></td>
                                        <td><?php echo $lable->RefID ?></td>
                                        <td id="package{{$lable->RefID}}"><?php echo $lable->Package * 500 ?></td>
                                        <td><?php echo $lable->Date ?></td>
                                        <?php 
                                        if( $lable->startNo == 0 )
                                        {
                                            ?>
                                            <form method="post" action="">
                                                @csrf
                                                <input type="hidden" name="id" value="<?php echo $lable->ID ?>">
                                                <input type="hidden" name="Markaz_ID" value="<?php echo $lable->Markaz_ID ?>">
                                                <td><input type="number" name="startNo" id="startNo{{$lable->RefID}}" onkeyup="fillEndNo({{$lable->RefID}})" required></td>
                                                <td>
                                                    <input type="number" name="endNo" id="endNo{{$lable->RefID}}" required>
                                                    <input type="submit" name="submit" value="ثبت">
                                                    <p id='demo'></p>
                                                </td>
                                                
                                            </form>
                                            <script>
                                                function fillEndNo(refID){
                                                    var refID = refID;
                                                    var s = 'startNo' + refID;
                                                    var startNo = parseInt(document.getElementById(s).value);
                                                    var d = 'package'+refID;
                                                    var p = parseInt(document.getElementById(d).innerHTML);
                                                    var e = 'endNo'+refID;
                                                    document.getElementById(e).value = startNo + p -1;
                                                }
                                            </script>
                                            <?php
                                        }else
                                        {
                                        ?>
                                            <td><?php echo $lable->startNo ?></td>
                                            <td><?php echo $lable->endNo ?></td>
                                        <?php
                                        $i++;
                                        }
                                        ?>
                                        </tr>
                                        
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection