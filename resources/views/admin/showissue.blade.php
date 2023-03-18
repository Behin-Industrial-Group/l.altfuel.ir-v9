@extends('layouts.app')

<?php
use App\Models\AnswerTemplateModel;
use App\Models\IssuesCatagoryModel;
use App\Models\RelatedIssueModel;
use App\Http\Controllers\CommentsController;
use App\CustomClasses\Access;
use App\CustomClasses\Logs;
?>
@section('title')
    تیکت - <?php if(isset($issues[0])) echo $issues[0]->name ?>
@endsection

@section('custom_css')
    html{
        scroll-behavior: smooth;
    }
@endsection


@section('content')
@include('includes.success')
    <div class="box box-default">
        <div class="box-body">
            <p><?php echo Verta(); ?></p>
            @foreach ($issues as $issue)
                @if($issue->catagory == $catagory)
                    <div class="box <?php if($issue->status == 0 || $issue->trackinglater == 'yes') echo "box-danger"; else echo "box-default" ?> box-solid" id="issue_{{$issue->id}}">
                        <div class="box-header">
                            {{$issue->id}} - {{$issue->catagory}} - 
                            وضعیت: {{$issue->status}} - 
                            @if( Access::checkView('Issuse_showLogs') )
                                آخرین اقدام کننده: 
                                
                                @if( Logs::lastLog( 'issues', $issue->id ) != null )
                                    {{ Logs::lastLog( 'issues', $issue->id )->display_name }}
                                @else
                                    NULL
                                @endif
                            @endif
                            <div class="pull-left box-tools">
                                <button data-toggle='collapse' data-target="#{{$issue->id}}"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div 
                            <?php 
                            if($issue->status == 0) 
                                echo "class='box-body'"; 
                            elseif($issue->trackinglater == 'yes') 
                                echo "class='box-body'"; 
                            else 
                                echo "class='box-body collapse'"; 
                            ?>  
                            id="{{$issue->id}}"
                        >
                            <div class="col-sm-9 box box-default" style="width:80%">
                                <form method="post" action="javascript:void(0)" id="form_{{$issue->id}}">
                                    @csrf
                                    <table class="table table-striped" style="font-size:13px;">
                                        <tr>
                                            <th colspan="2">
                                                <a href="">
                                                    {{ $issue->name }}<i class="{{ $user['isAgancy'] }}" style="font-size:22px;color:#0a95ff"></i>
                                                </a> | 
                                                {{ $issue->NationalID }} | 
                                                {{ $issue->cellphone }} |
                                                <span dir="ltr">{{ Str::limit($issue->created_at,10) }}</span> | 
                                                <span dir="ltr">{{ Str::limit($issue->updated_at,10) }}</span> | 
                                                عدم نیاز به پاسخ<input type="checkbox" name="junk" <?php if($issue->junk == 'yes') echo 'checked'; ?>>
                                            </th>
                                        </tr>
                                            <th>متن پیام</th>
                                            <td><textarea rows="5" class="col-sm-12">{{ $issue->issue }}</textarea></td>
                                        </tr>
                                        <tr>
                                            <th>فایل پیوست</th>
                                            <td>
                                                @if ($issue->file)
                                                    <a href="{{ "https://l.altfuel.ir/$issue->file" }}" target="_blank">نمایش</a> | 
                                                    <a href="{{ "https://label.altfuel.ir/$issue->file" }}" target="_blank">نمایش</a>
                                                @else
                                                    ندارد
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>پاسخ</th>
                                            <td>
                                                    
                                                    <input type="checkbox" name="track" <?php  if($issue->trackinglater == 'yes') echo 'Checked' ?> >نیاز به پیگیری بعدی<br>
                                                    <textarea name="answer" rows="5" class='col-sm-12' id="answer{{$issue->id}}">{{$issue->answer}}</textarea>
                                                    <input type="hidden" name="id" value="{{$issue->id}}">
                                                    <input type="submit" value="ثبت" onclick="RegAnswer({{$issue->id}})" class="btn btn-success col-sm-12">
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>

                            <div class="col-sm-9 box box-default" style="width:19%; float:left">
                                <form method="post" action="javascript:void(0)" id="related_form_{{$issue->id}}">
                                    @csrf
                                    <table class="table table-striped" style="font-size:13px;">
                                        <thead>
                                            <th colspan="2">
                                                تیکت های مرتبط
                                            </th>
                                        </thead>
                                        <?php $related_issues = RelatedIssueModel::where('issue_id',$issue->id)->get(); ?>
                                        @foreach ($issue->related as $related)
                                            <tr>
                                                <td>
                                                    <a target="_blank" href="<?php echo url("admin/issues/show/irngv/national-id/$related->NationalID#issue_$related->related_issue_id") ?>">
                                                        {{$related->related_issue_id }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>
                                                <input list="issue_no_{{$issue->id}}" name="issue_number_{{$issue->id}}" onkeyup="GetIssues({{$issue->id}})" id="issue_number_{{$issue->id}}" class="form-control">
                                                <datalist id="issue_no_{{$issue->id}}" dir="rtl"></datalist>
                                            </td>
                                            <td>
                                                <button class="btn btn-default" onclick="SetRelatedIssue({{$issue->id}})" id="submit_issue_no">ثبت</button>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                            
                            
                            <div class="box box-info col-sm-12" style="padding: 5px">
                                <div class="box box-danger col-sm-5" style="width:49%">
                                    <?php $comments = CommentsController::get('issues',$issue->id); ?>
                                    <form class="form-horizontal" action="javascript:void(0)" id="comment_form_{{$issue->id}}" style="">
                                        <table class="table table-striped" style="font-size:10px">
                                            @foreach($comments as $comment)
                                            <tr>
                                                <td>
                                                    <?php echo Verta($comment->updated_at); ?>
                                                </td>
                                                <td>
                                                    <?php echo "// ",$comment->comment; ?>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td>
                                                    <button class="form-control btn btn-default" onclick="setComment({{$issue->id}})">ثبت یادداشت</button>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="hidden" name="record_id" value="{{$issue->id}}">
                                                    <input class="form-control" type="hidden" name="table_name" value="issues">
                                                    <input class="form-control" type="text" name="comment">
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                                <div class="box box-danger col-sm-5" style="width:49%; float:left">
                                    <form class="form-horizontal"action="javascript:void(0)" id="sendto_form_{{$issue->id}}">
                                        <input type="hidden" name="id" value="{{ $issue->id }}">
                                        <table class="table table-striped">
                                        <tr>
                                            <td>
                                            ارجاع به دسته بندی:
                                            </td>
                                            <td>
                                                <select class="form-control" name="catagory" required>
                                                    @foreach( $catagories as $cat )
                                                    <option value="{{$cat->name}}">{{$cat->fa_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <button onclick="sendto({{$issue->id}})" class="form-control btn btn-default">ارجاع</button>
                                            </td>
                                        </tr>
                                        
                                        </table>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                @endif
            @endforeach
            
            <!--Create Issue Form -->
            <div class="">
                <div class="box box-success box-solid">
                    <div class="box-header">
                        <i class="fa fa-info-circle"></i>
                        <h3 class="box-title">ایجاد تیکت و ارسال به متقاضی</h3>
                        <!-- tools box -->
                        <div class="pull-left box-tools">
                        <button type="button" class="btn bg-info btn-sm" data-toggle="collapse" data-target="#reg_issue"><i class="fa fa-minus"></i>
                        </button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <div class="box-body" id="reg_issue">
                        <form method="POSt" action="{{url('/admin/issues/create-new-issue')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="catagory" value="{{ $catagory }}" required>
                        <table class="table col-sm-3" style="font-size:13px;">
                            
                            <tr>
                                <th>نام و نام خانوادگی</th>
                                <td><input type="text" name="name" value="{{ $user['name'] }}" required></td>
                            </tr>
                            <tr>
                                <th>کد ملی</th>
                                <td><input type="text" name="NationalID" value="{{ $user['NationalID'] }}" required></td>
                            </tr>
                            <tr>
                                <th>شماره موبایل</th>
                                <td><input type="text" name="cellphone" value="{{ $user['cellphone'] }}" required></td>
                            </tr>
                        </table>
                        <table class="table col-sm-6 col-sm-offset-1" style="font-size:13px;">
                            <tr>
                                <th>متن پیام</th>
                                <td>
                                    <input type="text" name="issue" value="پیگیری نامه شماره ---" required>
                                </td>
                            </tr>
                            <tr>
                                <th>فایل پیوست</th>
                                <td>
                                    <input type="file" name="attach" />
                                </td>
                            </tr>
                            <tr>
                                <th>پاسخ</th>
                                <td>
                                    <textarea name="answer" rows="5" cols="50" id="answer" required></textarea>
                                    <input type="submit" value="ارسال پیام" class="btn btn-success">
                                </td>
                            </tr>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
        <!-- other catagory 
        <div class="col-sm-4">
            <div class="box box-info">
            <div class="box-body">
                foreach ($issues as $issue)
                    if($issue->catagory != $catagory)
                        <div class="">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    دسته بندی: $issue->catagory}}---------------
                                    وضعیت: $issue->status}}
                                </div>
                                <div class="panel-body">
                                    <table class="table">
                                        <tr dir="ltr">
                                            <th>تاریخ ایجاد</th>
                                            <td> $issue->created_at }}</td>
                                        </tr>
                                        <tr dir="ltr">
                                            <th>تاریخ آپدیت</th>
                                            <td>$issue->updated_at }}</td>
                                        </tr>
                                        <tr>
                                            <th>متن پیام</th>
                                            <td>$issue->issue }}</td>
                                        </tr>
                                        <tr>
                                            <th>فایل پیوست</th>
                                            <td>
                                                if ($issue->file)
                                                    <a href="Url("$issue->file") }}" target="_blank">نمایش</a>
                                                else
                                                    ندارد
                                                endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>پاسخ</th>
                                            <td>
                                                <form method="POSt" action="http://l.altfuel.ir echo $_SERVER['REQUEST_URI'] ?>">
                                                    csrf
                                                    <textarea  disabled>$issue->answer}}</textarea>
                                                    <input type="hidden" name="id" value="$issue->id}}">
                                                    <input type="submit" value="ثبت" class="btn btn-success" disabled>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    endif
                endforeach
            </div>
        </div>
        </div>
-->
    
@endsection

@section('custom_script')
    <script>
        window.onload = function(){
            var issueId = window.location.href;
            issueId = issueId.split('#');
            issueId = issueId[1];
            var elmnt = document.getElementById(issueId);
            elmnt.scrollIntoView();
            elmnt.style.border = "5px solid blue";
        }
    </script>
@endsection

@section('script')
<script>
    function GetIssues(issue_id){
        var no = $("#issue_number_" + issue_id).val();
        $.get( "{{url('admin/issues/get-issues-no')}}/"+ no, function( data ) {
            $( "#issue_no_" + issue_id ).html( data );
        });
    }

    function SetRelatedIssue(issue_id){
        $("#loading").show();
        var fd = $('#related_form_' + issue_id).serialize();
        var reg_answer_url = "{{url('admin/issues/set-related-issue')}}/" + issue_id;
        $.ajax({
            url: reg_answer_url,
            type: 'POST',
            data: fd,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(dataofsubmit){
                if(dataofsubmit == 'done'){
                    $("#success").show().delay(1000).fadeOut();
                    location.reload();
                }
                else{
                    $("#error").show().delay(10000).fadeOut();
                    $('#error').html(dataofsubmit);
                    $("#loading").fadeOut();
                }
                
            }
        });
    }
    
    function RegAnswer(issue_id){
        $("#loading").show();
        var fd = $('#form_' + issue_id).serialize();
        var reg_answer_url = "{{url('admin/issues/reg-answer/')}}";
        $.ajax({
            url: reg_answer_url,
            type: 'POST',
            data: fd,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(dataofsubmit){
                console.log(dataofsubmit);
                if(dataofsubmit == 'done'){
                    $("#success").show().delay(1000).fadeOut();
                    $("#loading").fadeOut();
                    location.reload();
                }
                else{
                    $("#error").show().delay(1000).fadeOut();
                    $('#error').html(dataofsubmit);
                    $("#loading").fadeOut();
                }
                
            }
        });
    }

    function setComment(issue_id){
        $("#loading").show();
        var fd = $('#comment_form_' + issue_id).serialize();
        var reg_answer_url = "{{url('admin/issues/set-comment/')}}";
        $.ajax({
            url: reg_answer_url,
            type: 'POST',
            data: fd,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(dataofsubmit){
                if(dataofsubmit == 'done'){
                    $("#success").show().delay(1000).fadeOut();
                    location.reload();
                }
                else{
                    $("#error").show().delay(10000).fadeOut();
                    $('#error').html(dataofsubmit);
                    $("#loading").fadeOut();
                }
                
            }
        });
    }

    function sendto(issue_id){
        $("#loading").show();
        var fd = $('#sendto_form_' + issue_id).serialize();
        var reg_answer_url = "{{url('admin/issues/sendto/')}}";
        $.ajax({
            url: reg_answer_url,
            type: 'POST',
            data: fd,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(dataofsubmit){
                if(dataofsubmit == 'done'){
                    $("#success").show().delay(1000).fadeOut();
                    location.reload();
                }
                else{
                    $("#error").show().delay(10000).fadeOut();
                    $('#error').html(dataofsubmit);
                    $("#loading").fadeOut();
                }
                
            }
        });
    }

    
</script>
@endsection