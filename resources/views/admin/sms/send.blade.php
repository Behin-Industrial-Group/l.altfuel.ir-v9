@extends('layouts.app')

@section('content')
    @include('includes.success')
    <div class="box table-responsive">
        <form action="javascript:void(0)" id="sms-form">
            <table class="table table-striped" id="">
                <tr>
                    <td>شماره موبایل:</td>
                    <td><input type="text" name="to" id="" class="form-control"></td>
                </tr>
                <tr>
                    <td>متن پیامک: </td>
                    <td>
                        <textarea name="msg" id="" class="form-control" cols="30" rows="10" ></textarea>
                    </td>
                </tr>
                <tr>
                    <td><button id="send_newpass_sms">ارسال</button></td>
                </tr>
            </table>
        </form>
    </div>
@endsection

@section('script')
    <script>
        


        $('#send_newpass_sms').click(function(){
            $('#loading').show();
            var fd = $('#sms-form').serialize();
            var send_url = "{{url('admin/send-sms')}}";
            $.ajax({
                url: send_url,
                type: 'POST',
                data: fd,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(data){
                    alert(data);  
                    $('#loading').hide();
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                }
            });
            
        })
    </script>
@endsection