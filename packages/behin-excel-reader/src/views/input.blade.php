@extends('layouts.welcome')

@section('content')
<form action="javascript:void(0)" id="excel-form">
    @csrf
    <input type="file" name="file">
    <button onclick="submitForm()">excel upload</button>
</form>

<script>
    function submitForm() {
        var form = $('#excel-form')[0];
        var data = new FormData(form);
        send_ajax_formdata_request(
            "{{ route('excelReader.read') }}",
            data,
            function(response) {
                show_message("{{ trans('ok') }}")
                location.reload()
            }
        )
    }
</script>
@endsection

