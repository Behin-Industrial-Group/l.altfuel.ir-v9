@extends('layout.welcome_layout')

@section('title')
    ثبت تیکت اتحادیه کشوری سوخت های جایگزین
@endsection


@section('content')
@include('includes.success')
        <div class="box col-sm-12" >
                <table class="table table-striped">
                    <form method="post" action="<?php echo url("irobot") ?>">
                        @csrf
                        <tr>
                            <td style="text-justify: inter-word;">پاسخ: </td>
                            <td><?php echo $case->answer ?></td>
                        </tr>
                        <tr>
                            <td>سوالتان در رابطه با :</td>
                            <td>
                                <select class="form-control select2" name="id">
                                    @foreach($catagories as $catagory)
                                    <option value="{{$catagory->id}}">{{$catagory->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" class="btn btn-info" value="ارسال"/>
                            </td>
                        </tr>
                    </form>
                    <tr>
                        <td>
                            <button id="receive_answer">پاسخ خود را دریافت کردم</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
@endsection

@section('script')
    <script>
        $('#receive_answer').on('click', function(){
            $("#loading").show();
            var reg_answer_url = "{{url("admin/robot/receive_answer/$case->id")}}";
            $.get( reg_answer_url, function( data ) {
                window.location.replace("{{url("irobot")}}");
            });
        });
    </script>
@endsection