<?php
use Mkhodroo\AgencyInfo\Controllers\HtmlCreatorController;

?>
<h4>
    {{ __('Edit customer info') }}: {{ $agency_fields->where('key', 'firstname')->first()?->value }}
    {{ $agency_fields->where('key', 'lastname')->first()?->value }}
    @php
        $customer_type = $agency_fields->where('key', config('agency_info.main_field_name'))->first();
    @endphp
</h4>

<div class="card card-primary card-tabs">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="foreman-tab" data-toggle="pill" href="#foreman" role="tab" aria-controls="foreman-info"
                    aria-selected="true">{{ __('Foreman Info') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="docs-tab" data-toggle="pill" href="#docs" role="tab" aria-controls="docs"
                    aria-selected="false">{{ __('Docs') }}</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
            @include('MyAgencyViews::edit-tabs.doc-info', [
                'customer_type' => $customer_type,
                'agency_fields' => $agency_fields
            ])
            @include('MyAgencyViews::edit-tabs.foreman-info', [
                'customer_type' => $customer_type,
                'agency_fields' => $agency_fields
            ])
        </div>
    </div>

</div>


<script>
    initial_view()

    function docs_edit() {
        var fd = new FormData($('#docs-form')[0]);
        send_ajax_formdata_request(
            "{{ route('myAgency.docsEdit') }}",
            fd,
            function(res) {
                console.log(res);
                show_message("{{ __('Edited') }}");
                open_edit_form(res.parent_id, 'docs')
                filter()
            }
        )
    }


    function foreman_edit() {
        send_ajax_request(
            "{{ route('myAgency.foremanEdit') }}",
            $('#foreman-form').serialize(),
            function(res) {
                console.log(res);
                show_message("{{ __('Edited') }}");
                open_edit_form(res.parent_id, 'info')
                filter()
            }
        )
    }

    function delete_fin_pay_file(key) {
        var fd = new FormData();
        fd.append('parent_id', $($('input[name=id]')[1]).val());
        fd.append('key', key);
        send_ajax_formdata_request_with_confirm(
            "{{ route('agencyInfo.deleteByKey') }}",
            fd,
            function(res) {
                console.log(res);
                open_edit_form(res.parent_id)
                show_message("{{ __('Deleted') }}");
            },
            null,
            "{{ __('Are you sure?') }}"
        )

    }
    runCamaSeprator('cama-seprator')
    camaSeprator('cama-seprator')
</script>
