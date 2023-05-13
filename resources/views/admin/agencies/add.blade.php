
<form action="javascript:void(0)" id="add-agency-form">
    <table class="table table-bordered table-striped">
        <tr>
            <td>نوع مرکز: </td>
            <td>
                <select name="agency_table" id="">
                    @foreach (config('app.agencies') as $agency)
                        <option value="{{ $agency['table'] }}">{{$agency['fa_name']}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>نام</td>
            <td><input type="text" class="form-control" id="" name="Name" value="" required></td>
        </tr>
        
    </table>
</form>
<button type="button" class="btn btn-primary" id="submit-markaz-form" onclick="add()">ذخیره</button>

<script>

    function add(){
        send_ajax_request_with_confirm(
            "{{ route('agency.add') }}",
            $('#add-agency-form').serialize(),
            function(data){
                console.log(data);
                toastr.success("مرکز افزوده شد")
            },
            function(data){
                console.log(data);
                show_error(data);
            }
        )
    }
</script>