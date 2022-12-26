@extends('layouts.app')

@section('content')
    @include('includes.success')
    <div class="box table-responsive">
        <form action="javascript:void(0)">
            <table class="table table-striped" id="ip_tbl">
                <tr id="row">
                    <td>IP</td>
                    <td>
                        <input type="text" name="ip[]" class="form-control" dir="ltr">
                    </td>
                </tr>
                <tfoot>
                    <tr>
                        <td>
                            <button onclick="add()" class="btn btn-info">+</button>
                        </td>
                        <td>
                            <button onclick="set_ips()" class="btn btn-danger">غیرفعال کردن</button>
                        </td>
                        <td>
                            <button onclick="enable_app()" class="btn btn-success">فعال کردن نرم افزار</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $.get("{{url('admin/disable/get-all-ips')}}", function(data){
                data = jQuery.parseJSON(data);
                $.each(data,function(index, value){
                    var tr = "<tr>";
                        tr += "<td>ip</td>";
                        tr += "<td>"+ data[index].ip + "</td>";
                        tr += "</tr>";

                    $('#ip_tbl tfoot').append(tr);
                });
            });
        });

        function add(){
            var tr = $('#row').html();
            $('#ip_tbl').append('<tr>' + tr + '</tr>');
        }

        function set_ips(){
            $("#loading").show();
            var form = $('form')
            var fd = form.serialize();
            var send_url = "{{url('admin/disable')}}";
            $.ajax({
                url: send_url,
                type: 'POST',
                data: fd,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(dataofconfirm){
                    if(dataofconfirm == 'done'){
                        $('#success').show().delay(1000).fadeOut();
                    }
                    location.reload();  
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            });
        }

        function enable_app(){
            $("#loading").show();
            var send_url = "{{url('admin/disable/enable-app')}}";
            $.ajax({
                url: send_url,
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(dataofconfirm){
                    if(dataofconfirm == 'done'){
                        $('#success').show().delay(1000).fadeOut();
                    }
                    location.reload();  
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            });
        }
    </script>
@endsection