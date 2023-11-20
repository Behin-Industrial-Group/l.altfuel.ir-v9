<form action="javascript:void(0)" id="new-agency-form" class="col-sm-12 table-responsive">
    <table class="table table-striped">
        <tbody>
            <tr>
                <td>{{ __(config('agency_info.main_field_name')) }}</td>
                <td>
                    <select name="{{ config('agency_info.main_field_name') }}" id="" class="form-control">
                        @foreach (config('agency_info.customer_type') as $catagory => $catagory_detail)
                            <option value="{{ $catagory }}">{{ $catagory_detail['name'] }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    <button onclick="create()" class="btn btn-primary">{{ __('Create') }}</button>
</form>

<script>
    function create() {
        send_ajax_request(
            "{{ route('agencyInfo.create') }}",
            $('#new-agency-form').serialize(),
            function(res) {
                console.log(res);
                open_edit_form(res.id)
                filter()
            }
        )
    }
</script>
