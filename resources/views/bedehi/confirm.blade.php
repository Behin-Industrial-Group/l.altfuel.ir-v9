@extends('layout.welcome_layout')
<?php
use App\Enums\EnumsEntity;

?>

@section('content')
    <div class="col-sm-4"></div>
    <div class="col-sm-4" align='center' style="margin: 15% 0 0 0; background: white">
        <form method="POST" action="{{url('/bedehi/pay')}}" style="margin: 50px">
            @csrf
            <input type="hidden" name="type" value="{{$type}}" id="">
            <table class="table table-striped table-bordered">
                <tr>
                    <td class="col-sm-3">
                        <label for="" class="">کدملی</label>
                    </td>
                    <td class="col-sm-9">
                        <input type="text" class="form-control col-sm-9" name="nid" value="{{$markaz->NationalID}}" readonly/>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3">
                        <label for="" class="">شماره موبایل</label>
                    </td>
                    <td class="col-sm-9">
                        <input type="text" class="form-control col-sm-9" name="mobile" value="{{$markaz->Cellphone}}" readonly/>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3">
                        <label for="" class="">کد یا شناسه صنفی</label>
                    </td>
                    <td class="col-sm-9">
                        <?php 
                        if($type === EnumsEntity::$AgencyType['agency']['value']){
                            $code = $markaz->CodeEtehadie;
                        }
                        if($type === EnumsEntity::$AgencyType['kamfeshar']['value']){
                            $code = $markaz->GuildNumber;
                        }
                        ?>
                        <input type="text" class="form-control col-sm-9" name="code" 
                        value="{{ $code }}" readonly/>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3">
                        <label for="" class="col-sm-3">میزان بدهی</label>
                    </td>
                    <td class="col-sm-9">
                        <input type="text" class="form-control col-sm-9" name="debt" value="{{$markaz->debt}}" readonly/>
                        <label for="" class="">
                            <script>
                                document.write(Num2persian( '{{ (int)$markaz->debt/10 }}' ))
                            </script>
                            تومان
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3">
                        <label for="" class="col-sm-3">شرح بدهی</label>
                    </td>
                    <td class="col-sm-9">
                        <textarea type="text" class="form-control col-sm-9" name="debt_description" readonly>{{$markaz->debt_description}}</textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label for="" class="col-sm-8" style="padding: 10px"><input type="checkbox" name="accept" id="" style="padding: 10px;"> صحت اطلاعات فوق را تایید میکنم
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3"></td>
                    <td class="col-sm-9">
                        <input type="submit" class="btn btn-success col-sm-12" value="پرداخت" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
@endsection