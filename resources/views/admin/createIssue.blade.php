@extends('layouts.app')

<?php
use App\Models\IssuesCatagoryModel;
?>

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-heading">
                
            </div>
            <div class="box-body">
                <div>
                    <form method="post" action="http://l.altfuel.ir/admin/issues/createIssue" class="from-horizontal">
                        @csrf
                        <div class="form-group">
                            <select class="select" name="catagory">
                                <?php $catagories =  IssuesCatagoryModel::get()?>
                                @foreach($catagories as $catagory)
                                    <option value="{{$catagory->name}}">{{$catagory->fa_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <lable>
                                کدملی:
                            </lable>
                            <input type="text" class="form-control" name="NationalID">
                        </div>
                        <div class="form-group">
                            <lable>
                                شماره موبایل:
                            </lable>
                            <input type="text" class="form-control" name="cellphone">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="ایجاد">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection