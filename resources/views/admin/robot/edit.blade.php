@extends('layouts.app')

@section('content')
    @include('includes.success')
    <div class="box table-responsive">
        <form action="javascript:void(0)" id="form" method="POST">
            <table class="table table-striped">
                <tr>
                    <td>دسته بندی:</td>
                    <td>
                        <input list="value_list" name="value" id="value" required>
                        <datalist id="value_list"></datalist>
                    </td>
                </tr>
                <tr>
                    <td>پاسخ</td>
                    <td>
                        <textarea type="text" name="answer" id="answer" rows="10" class="form-control" required></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="submit" id="submit">
                    </td>
                </tr>
            </table>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $.get( "{{url('admin/robot/get/catagory')}}", function( data ) {
            $( "#value_list").html( data );
        });

        $('#value').on('keyup', function(){
            var value = $('#value').val();
            $.get( "{{url('admin/robot/get/answer')}}/" + value, function( data ) {
                $( "#answer").html( data );
            });
        });

        $('#submit').on('click', function(){
            $("#loading").show();
            var fd = $('#form').serialize();
            var reg_answer_url = "{{url('admin/robot/edit')}}";
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
                        alert(dataofsubmit);
                        $("#error").show().delay(10000).fadeOut();
                        $('#error').html(dataofsubmit);
                        $("#loading").fadeOut();
                    }
                    
                }
            });
        });
    </script>
@endsection