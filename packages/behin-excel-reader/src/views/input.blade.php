@extends('layouts.app')

@section('content')
<form action="javascript:void(0)" id="excel-form">
    @csrf
    <input type="file" name="file">
    <button onclick="submitForm()">excel upload</button>
</form>
<div id="json-data" class="alert alert-success mt-2">
    <p>تعداد ردیف‌های اضافه‌شده: <span id="added-rows"></span></p>
    <p>تعداد ردیف‌های به‌روزشده: <span id="updated-rows"></span></p>

    <div class="alert alert-warning">ردیف های با شماره پرونده تکراری
        <p id="error-rows"></p>
    </div>
</div>

<script>
    function submitForm() {
        var form = $('#excel-form')[0];
        var data = new FormData(form);
        send_ajax_formdata_request(
            "{{ route('excelReader.read') }}",
            data,
            function(response) {
                show_message("{{ trans('ok') }}")
                // location.reload()
                console.log(response);

                // نمایش تعداد ردیف‌های اضافه‌شده و به‌روزشده
                $('#added-rows').text(response.numberOfAddedRows);
                $('#updated-rows').text(response.numberOfUpdatedRows);

                // نمایش خطاها
                var errorRows = response.errorRows;
                if (errorRows.length > 0) {
                    $.each(errorRows, function (index, error) {
                        $('#error-rows').append(
                            'ردیف: ' + error.row + ' شماره پرونده: ' + error.file_number + '<br>'
                        );
                    });
                } else {
                    $('#error-rows').append('هیچ خطایی وجود ندارد');
                }

            }
        )
    }
</script>
@endsection

