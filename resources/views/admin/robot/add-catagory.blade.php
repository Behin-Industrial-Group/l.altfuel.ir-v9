@extends('layouts.app')

@section('content')
    @include('includes.success')
    <div class="box table-responsive">
        <form action="javascript:void(0)" id="form" method="POST">
            <table class="table table-striped">
                <tr>
                    <td>نام:</td>
                    <td>
                        <input type="text" name="name" id="name">
                    </td>
                </tr>
                <tr>
                    <td>مقدار</td>
                    <td>
                        <input type="text" name="value" id="value">
                    </td>
                </tr>
                <tr>
                    <td>دسته بندی پدر:</td>
                    <td>
                        <input list="parent_list" name="parent_id" id="parent_id">
                        <datalist id="parent_list"></datalist>
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
            $( "#parent_list").html( data );
        });

        $('#submit').on('click', function(){
            $("#loading").show();
            var fd = $('#form').serialize();
            var reg_answer_url = "{{url('admin/robot/set')}}";
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
        });
    </script>
@endsection