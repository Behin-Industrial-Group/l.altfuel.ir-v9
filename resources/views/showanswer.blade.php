@extends('layout.welcome_layout')

<?php
use App\Models\IssuesCatagoryModel;
?>

@section('title')
    مشاهده پاسخ تیکت های ثبت شده
@endsection

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-header">
                @if (!empty($message))
                    <div class='alert alert-success'>
                        {{ $message }}
                    </div>
                @endif
                @if (!empty($Error))
                    <div class='alert alert-danger'>
                        {{ $Error }}
                    </div>
                @endif
            </div>
            <div class="box-body">
                <div class="col-sm-8 col-sm-offset-2">
                    @foreach($answers as $answer)
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <span>
                                    شماره: {{$answer->id}} -
                                </span>
                                <span>
                                    تاریخ: {{$answer->updated_at}}
                                </span>
                                <p>
                                    <?php
                                    $catagory = IssuesCatagoryModel::where('name',$answer->catagory)->first();
                                    ?>
                                    دسته بندی:
                                    {{$catagory->fa_name}}
                                </p>
                            </div>
                            <div class="panel-body">
                                <p>
                                    <span>سوال: </span>
                                    {{$answer->issue}}
                                </p>
                                <p>
                                    <span>پیوست: </span>
                                    @if( !is_null( $answer->file ) )
                                        <a href="{{ Url($answer->file) }}">نمایش</a>
                                    @else
                                        <span>ندارد</span>
                                    @endif
                                </p>
                                <p>

                                    <p>پاسخ:</p>
                                        <?php
                                        if($answer->trackinglater == "yes"):
                                            echo "<p class='badge bg-green' style='display:block'>کارشناسان ما درحال پیگیری این موضوع هستند.</p>";
                                        elseif($answer->status == 4):
                                            $txt = "<p class='badge bg-red' style='display:block'>
                                            این تیکت عدم نیاز به پاسخ ثبت شده است. عدم نیاز به پاسخ میتواند به یکی از دلایل زیر باشد:
                                            <ul>
                                                <li>سوال تکراری که قبلا به آن پاسخ دا ده شده است.</li>
                                                <li>سوال ناقص است</li>
                                            </ul>
                                            </p>";
                                            echo $txt;
                                        endif;
                                        if(empty($answer->answer)):
                                            $txt = "هنوز پاسخی برای این تیکت ثبت نشده";
                                            echo $txt;
                                        else:
                                            echo "<textarea rows='10' class='form-control col-sm-12' disabled>$answer->answer</textarea>";
                                        endif;
                                        ?>
                                </p>
                                <p>
                                    <form action="javascript:void(0)" id="survay_form_{{$answer->id}}">
                                        @csrf
                                        <p>نظرتون در رابطه با کیفیت پاسخ دهی به این تیکت:</p>
                                        <p>
                                            <input type="hidden" name="survay_value" id="survay_value_{{$answer->id}}">
                                            <button value="{{$answer->id}}-1" class="survay_btn">افتضاح &#129324</button>
                                            <button value="{{$answer->id}}-2" class="survay_btn">بد &#128548</button>
                                            <button value="{{$answer->id}}-3" class="survay_btn"> متوجه پاسخ نشدم &#128560</button>
                                            <button value="{{$answer->id}}-4" class="survay_btn">قانع کننده &#128578</button>
                                            <button value="{{$answer->id}}-5" class="survay_btn">عالی &#129321</button>
                                        </p>
                                    </form>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $('.survay_btn').on('click', function(){
        var val = $(this).val();
        var id = $(this).val().split('-');
        $("#survay_value_" + id[0]).val(val);
        var fd = $('#survay_form_' + id[0]).serialize();
        var reg_answer_url = "{{url('issues/survay')}}/" + val;
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
    })
</script>

@endsection
