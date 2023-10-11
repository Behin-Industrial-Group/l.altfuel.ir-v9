<div class="row" style="border-bottom: solid 1px black">
    <h4>{{ $caseTitle ?? '' }} - {{ $processTitle ?? '' }}</h4>
    <button type="button" style="flex: auto; text-align: left" class="close" data-dismiss="modal"
        aria-hidden="true">&times;</button>
</div>
<div class="row" style="height: 10px"></div>


<form action="javascript:void(0)" id="main-form">
    @yield('content')
</form>

<div class="row form-group">
    <button class="btn btn-primary m-1" onclick="save_and_next()">{{ __('save and next') }}</button>

    <button class="btn btn-default m-1" onclick="save()">{{ __('save') }}</button>
</div>
<script>
    function save_and_next() {
        var fd = new FormData($("#main-form")[0]);
        fd.append('caseId', '{{ $caseId }}')
        // fd.append('del_index', '')
        // fd.append('task', '')
        // fd.append('user_logged', '')

        send_ajax_formdata_request(
            "{{ route('MkhodrooProcessMaker.api.saveAndNext') }}",
            fd,
            function(response) {
                console.log(response);
                refresh_table()
            }
        )
    }

    function save() {
        var fd = new FormData($("#main-form")[0]);
        fd.append('caseId', '{{ $caseId }}')
        // fd.append('del_index', '')
        // fd.append('task', '')
        // fd.append('user_logged', '')

        send_ajax_formdata_request(
            "{{ route('MkhodrooProcessMaker.api.save') }}",
            fd,
            function(response) {
                console.log(response);
            }
        )
    }
</script>

@if (config('pm_config.debug'))
    <div class="col-sm-12" dir="ltr" style="text-align: left">
        <pre>
            {{ print_r($vars) }}
        </pre>
    </div>
@endif
