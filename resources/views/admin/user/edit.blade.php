@extends('layouts.app')

@section('title')
    کاربران
@endsection

<?php
use App\Models\AccessModel;
use App\Models\User;
?>

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <a href="all" class="btn btn-info">Back To List</a>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    
                </div>
                
                <div class="box-body">
                    <table class="table">
                        <tr>
                            <th>شناسه</th>
                            <td>{{$user->id}}</td>
                        </tr>
                        <tr>
                            <th>نام</th>
                            <td>{{$user->display_name}}</td>
                        </tr>
                        <tr>
                            <th>نام کاربری</th>
                            <td>{{$user->name}}</td>
                        </tr>
                        <tr>
                            <th>ایمیل</th>
                            <td>{{$user->email}}</td>
                        </tr>
                        <tr>
                            <form method="post" action="{{$user->id}}/changepass">
                                @csrf
                                <input type="password" name="pass">
                                <input type="submit" value="تغییر رمز">
                            </form>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="box">
                <div class="box-body">
                    <form method="post" action="{{$user->id}}/changeShowInReport">
                        @csrf
                        <input type="checkbox" name="showInReport" class="" <?php if(User::find($user->id)->showInReport == 1) echo "checked" ?>>نمایش در گزارشها
                        <input type="submit" class="btn btn-success" value="ثبت">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h3>دسترسی ها</h3>
                </div>
                
                <div class="box-body">
                    <button class="" id="check_all">انتخاب همه</button>
                    <form class="form-horizontal" method="post" action="" id="access_tbl">
                        @csrf
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>نام</th>
                                    <th>دسترسی</th>
                                    
                                </tr>
                            </thead>
                            @foreach($methods as $method)
                                    <tr>
                                        <td>{{$method->fa_name}}</td>
                                        <td>
                                            <?php
                                            $access = AccessModel::where('user_id',$user->id)->where('method_id',$method->id)->first();
                                            ?>
                                            <input type="checkbox" name="{{$method->name}}" <?php if( isset($access->access) && $access->access == 'yes') echo "checked" ?>>
                                        </td>
                                    </tr>
                            @endforeach
                        </table>
                        <hr>
                        <input type="submit" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $("#check_all").on('click',function(){
            $('#access_tbl input:checkbox').prop('checked', 'true');
        });
    </script>
@endsection