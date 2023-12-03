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
                <a class="nav-link" id="fin-info-tab" data-toggle="pill" href="#fin-info" role="tab"
                    aria-controls="fin-info" aria-selected="false">{{ __('Agency Fin Info') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="docs-tab" data-toggle="pill" href="#docs" role="tab" aria-controls="docs"
                    aria-selected="false">{{ __('Docs') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="debts-tab" data-toggle="pill" href="#debts" role="tab" aria-controls="info"
                    aria-selected="true">{{ __('Debts Info') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="simfa-tab" data-toggle="pill" href="#simfa" role="tab" aria-controls="simfa"
                    aria-selected="true">{{ __('Simfa Info') }}</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
            <div class="tab-pane fade show" id="info" role="tabpanel" aria-labelledby="info-tab">
                <form action="javascript:void(0)" id="edit-form">
                    <input type="hidden" name="id" id="" value="{{ $customer_type->id ?? '' }}">
                    <table class="table table-striped ">
                        @foreach (config("agency_info.customer_type.$customer_type->value")['fields'] as $field_key => $field_detail)
                            @php
                                $value = $agency_fields->where('key', $field_key)->first()?->value;
                            @endphp
                            <tr>
                                <td>
                                    {{ __($field_key) }}
                                </td>
                                <td>
                                    @if ($field_detail['type'] == 'text')
                                        @php
                                            $required = '';
                                        @endphp
                                        <input type="text" name="{{ $field_key }}" value="{{ $value }}"
                                            class="form-control" id="">
                                    @endif
                                    @if ($field_detail['type'] == 'select')
                                        <select name="{{ $field_key }}" class="form-control select2 col-sm-12"
                                            id="">
                                            @if (!empty($field_detail['option-url']))
                                                @php
                                                    $url = $field_detail['option-url'];
                                                @endphp
                                                <script>
                                                    send_ajax_get_request(
                                                        "{{ Route::has($url) ? route($url) : url($url) }}",
                                                        function(res) {
                                                            selec_element = $('select[name={{ $field_key }}]')
                                                            res.forEach(function(item) {
                                                                var opt = new Option(item.province + ' - ' + item.city, item.id)
                                                                selec_element.append(opt)
                                                            })
                                                            selec_element.val('{{ $value }}').trigger('change')
                                                        }
                                                    )
                                                </script>
                                            @endif
                                            @if (is_array($field_detail['options']))
                                                @foreach ($field_detail['options'] as $opt)
                                                    <option value="{{ $opt['value'] }}">{{ $opt['label'] }}</option>
                                                @endforeach
                                                <script>
                                                    selec_element = $('select[name={{ $field_key }}]')
                                                    selec_element.val('{{ $value }}').trigger('change')
                                                </script>
                                            @endif

                                        </select>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <button class="btn btn-primary" onclick="edit()">{{ __('Edit') }}</button>
                </form>
            </div>
            <div class="tab-pane fade" id="fin-info" role="tabpanel" aria-labelledby="fin-info-tab">
                <form action="javascript:void(0)" id="fin-form" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="" value="{{ $customer_type->id ?? '' }}">
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th>{{ __('Year') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Payment date') }}</th>
                                <th>{{ __('Payment ref id') }}</th>
                                <th>{{ __('Payment file') }}</th>
                            </tr>
                        </thead>
                        @foreach (config("agency_info.customer_type.$customer_type->value")['memberships'] as $field_key => $field_detail)
                            <tr>
                                <td>
                                    {{ __($field_key) }}
                                </td>
                                @foreach ($field_detail as $item)
                                    @php
                                        $value = $agency_fields->where('key', $item)->first()?->value;
                                    @endphp
                                    <td style="text-align: center">
                                        @if (str_contains($item, 'file'))
                                            @if ($value)
                                                <a href="{{ url("public/$value") }}"
                                                    download="{{ __($item) }}">{{ __($item) }}</a>
                                                <i class="fa fa-trash"
                                                    onclick="delete_fin_pay_file('{{ $item }}')"
                                                    style="float: left; color: red; cursor: pointer"></i>
                                            @else
                                                <input type="file" name="{{ $item }}" id=""
                                                    class="form-control">
                                            @endif
                                        @else
                                            <input type="text" name="{{ $item }}"
                                                value="{{ $value }}"
                                                class="form-control {{ (str_contains($item, 'date') or str_contains($item, 'ref_id')) ? '' : 'cama-seprator' }}"
                                                id="">
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                    @foreach (config("agency_info.customer_type.$customer_type->value")['fin_fields'] as $field_key => $field_detail)
                        @php
                            $value = $agency_fields->where('key', $field_key)->first()?->value;
                        @endphp
                        {{ HtmlCreatorController::createInput($field_key, $field_detail, $value) }}
                    @endforeach
                    <button class="btn btn-primary" onclick="fin_edit()">{{ __('Edit') }}</button>
                </form>
            </div>
            <div class="tab-pane fade" id="docs" role="tabpanel" aria-labelledby="docs">
                <form action="javascript:void(0)" id="docs-form" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="" value="{{ $customer_type->id ?? '' }}">
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Doc') }}</th>
                            </tr>
                        </thead>
                        @foreach (config("agency_info.customer_type.$customer_type->value")['docs'] as $field_key => $field_detail)
                            <tr>
                                <td>
                                    {{ __($field_detail) }}
                                </td>
                                @php
                                    $value = $agency_fields->where('key', $field_detail)->first()?->value;
                                @endphp
                                <td style="text-align: center">
                                    @if ($value)
                                        <a href="{{ url("public/$value") }}"
                                            download="{{ __($field_detail) }}">{{ __($field_detail) }}</a>
                                        <i class="fa fa-trash" onclick="delete_fin_pay_file('{{ $field_detail }}')"
                                            style="float: left; color: red; cursor: pointer"></i>
                                    @else
                                        <input type="file" name="{{ $field_detail }}" id=""
                                            class="form-control">
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <button class="btn btn-primary" onclick="docs_edit()">{{ __('Edit') }}</button>
                </form>
            </div>
            <div class="tab-pane fade show" id="debts" role="tabpanel" aria-labelledby="debts-tab">
                <form action="javascript:void(0)" id="debt-form">
                    <input type="hidden" name="id" id="" value="{{ $customer_type->id ?? '' }}">
                    <table class="table table-striped">
                        <tr>
                            <th>{{ __('Debt Price') }}</th>
                            <th>{{ __('Debt Pay Date') }}</th>
                            <th>{{ __('Debt Ref Id') }}</th>
                            <th>{{ __('Debt Description') }}</th>
                        </tr>
                        @foreach (config("agency_info.customer_type.$customer_type->value")['debts'] as $debt)
                            <tr>
                                @foreach ($debt as $field_name)
                                    @php
                                        $disabled = $agency_fields->where('key', 'like', '%_ref_id%')->first()?->value ? 'disabled': '';
                                    @endphp
                                    <td>
                                        @if (str_contains($field_name, 'description'))
                                            <textarea name="{{ $field_name }}" id="" class="form-control" {{$disabled}}>{{ $agency_fields->where('key', $field_name)->first()?->value }}</textarea>
                                        @else
                                            <input type="text" name="{{ $field_name }}" {{$disabled}}
                                                class="form-control {{ (str_contains($field_name, 'date') or str_contains($field_name, 'ref_id')) ? '' : 'cama-seprator' }}"
                                                value="{{ $agency_fields->where('key', $field_name)->first()?->value }}">
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                    <button class="btn btn-primary" onclick="debt_edit()">{{ __('Edit') }}</button>
                </form>
            </div>
            @isset(config("agency_info.customer_type.$customer_type->value")['simfa_fields'])
            <div class="tab-pane fade show" id="simfa" role="tabpanel" aria-labelledby="simfa-info">
                <form action="javascript:void(0)" id="simfa-form">
                    <input type="hidden" name="id" id="" value="{{ $customer_type->id ?? '' }}">
                    <table class="table table-striped ">
                        @foreach (config("agency_info.customer_type.$customer_type->value")['simfa_fields'] as $field_key => $field_detail)
                            @php
                                $value = $agency_fields->where('key', $field_key)->first()?->value;
                            @endphp
                            <tr>
                                <td>
                                    {{ __($field_key) }}
                                </td>
                                <td>
                                    {{ HtmlCreatorController::createInput($field_key, $field_detail, $value) }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <button class="btn btn-primary" onclick="edit()">{{ __('Edit') }}</button>
                </form>
            </div>
            @endisset
        </div>
    </div>

</div>


<script>
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
