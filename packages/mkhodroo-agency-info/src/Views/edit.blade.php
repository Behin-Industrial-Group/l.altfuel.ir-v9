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
                <a class="nav-link" id="info-tab" data-toggle="pill" href="#info" role="tab" aria-controls="info"
                    aria-selected="true">{{ __('Agency Info') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="foreman-tab" data-toggle="pill" href="#foreman" role="tab" aria-controls="foreman-info"
                    aria-selected="true">{{ __('Foreman Info') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="partner-tab" data-toggle="pill" href="#partner" role="tab" aria-controls="partner-info"
                    aria-selected="true">{{ __('Partner Info') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="docs-tab" data-toggle="pill" href="#docs" role="tab" aria-controls="docs"
                    aria-selected="false">{{ __('Docs') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="additional_docs-tab" data-toggle="pill" href="#additional_docs" role="tab" aria-controls="additional_docs-info"
                    aria-selected="true">{{ __('Additional Docs') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="inspection-tab" data-toggle="pill" href="#inspection" role="tab" aria-controls="inspection-info"
                    aria-selected="true">{{ __('Inspection Info') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="fin-info-tab" data-toggle="pill" href="#fin-info" role="tab"
                    aria-controls="fin-info" aria-selected="false">{{ __('Agency Fin Info') }}</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" id="debts-tab" data-toggle="pill" href="#debts" role="tab" aria-controls="info"
                    aria-selected="true">{{ __('Debts Info') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="last_action-tab" data-toggle="pill" href="#last_action" role="tab" aria-controls="last_action"
                    aria-selected="true">{{ __('Last Actions Info') }}</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
            @include('AgencyView::edit-tabs.main-info', [
                'customer_type' => $customer_type,
                'agency_fields' => $agency_fields
            ])
            
            @include('AgencyView::edit-tabs.fin-info', [
                'customer_type' => $customer_type,
                'agency_fields' => $agency_fields
            ])
            @include('AgencyView::edit-tabs.doc-info', [
                'customer_type' => $customer_type,
                'agency_fields' => $agency_fields
            ])
            @include('AgencyView::edit-tabs.additional-docs-info', [
                'customer_type' => $customer_type,
                'agency_fields' => $agency_fields
            ])
            @include('AgencyView::edit-tabs.debt-info', [
                'customer_type' => $customer_type,
                'agency_fields' => $agency_fields
            ])
            @include('AgencyView::edit-tabs.foreman-info', [
                'customer_type' => $customer_type,
                'agency_fields' => $agency_fields
            ])
            @include('AgencyView::edit-tabs.partner-info', [
                'customer_type' => $customer_type,
                'agency_fields' => $agency_fields
            ])
            @include('AgencyView::edit-tabs.inspection-info', [
                'customer_type' => $customer_type,
                'agency_fields' => $agency_fields
            ])
            @include('AgencyView::edit-tabs.last-actions', [
                'customer_type' => $customer_type,
                'agency_fields' => $agency_fields
            ])
        </div>
    </div>

</div>


<script>
    initial_view()
    function edit() {
        send_ajax_request(
            "{{ route('agencyInfo.edit') }}",
            $('#edit-form').serialize(),
            function(res) {
                console.log(res);
                show_message("{{ __('Edited') }}");
                open_edit_form(res.parent_id, 'info')
                filter()
            }
        )
    }

    function fin_edit() {
        var fd = new FormData($('#fin-form')[0]);
        send_ajax_formdata_request(
            "{{ route('agencyInfo.finEdit') }}",
            fd,
            function(res) {
                console.log(res);
                show_message("{{ __('Edited') }}");
                open_edit_form(res.parent_id, 'fin-info')
                filter()
            }
        )
    }

    function docs_edit() {
        var fd = new FormData($('#docs-form')[0]);
        send_ajax_formdata_request(
            "{{ route('agencyInfo.docsEdit') }}",
            fd,
            function(res) {
                console.log(res);
                show_message("{{ __('Edited') }}");
                open_edit_form(res.parent_id, 'docs')
                filter()
            }
        )

    }

    function debt_edit() {
        send_ajax_request(
            "{{ route('agencyInfo.edit') }}",
            $('#debt-form').serialize(),
            function(res) {
                console.log(res);
                show_message("{{ __('Edited') }}");
                open_edit_form(res.parent_id, 'info')
                filter()
            }
        )
    }

    function simfa_edit() {
        send_ajax_request(
            "{{ route('agencyInfo.edit') }}",
            $('#simfa-form').serialize(),
            function(res) {
                console.log(res);
                show_message("{{ __('Edited') }}");
                open_edit_form(res.parent_id, 'info')
                filter()
            }
        )
    }

    function foreman_edit() {
        var fd = new FormData($('#foreman-form')[0]);
        send_ajax_formdata_request(
            "{{ route('agencyInfo.foremanEdit') }}",
            fd,
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
