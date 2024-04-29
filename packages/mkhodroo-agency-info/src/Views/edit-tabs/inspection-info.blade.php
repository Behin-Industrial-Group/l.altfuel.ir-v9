@if (auth()->user()->access('Show Agency Inspection Info'))
    @php
        $tab_name = 'inspection';
        $prefix_key_name = 'inspection_';
        $fields = config("agency_info.customer_type.$customer_type->value")[$tab_name];
    @endphp
    @isset($fields)
        <div class="tab-pane fade show" id="{{ $tab_name }}" role="tabpanel" aria-labelledby="{{ $tab_name }}-info">
            <form action="javascript:void(0)" id="{{ $tab_name }}-form" enctype="multipart/form-data">
                <input type="hidden" name="id" id="" value="{{ $customer_type->id ?? '' }}">
                <table class="table table-striped ">
                    @foreach ($fields as $number => $field_details)
                        <tr>
                            @foreach ($fields[$number] as $field_key => $field_detail)
                                @php
                                    $key = $prefix_key_name . $number . '_' . $field_key;
                                    $value = $agency_fields->where('key', $key)->first()?->value;
                                @endphp
                                <td>
                                    {{ __($field_key) }}
                                </td>
                                <td>
                                    {{ $HtmlCreator::createInput($key, $field_detail, $value) }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
                <button class="btn btn-primary" onclick="{{ $tab_name }}_edit()">{{ __('Edit') }}</button>
            </form>
        </div>
        <script>
            function inspection_edit() {
                var fd = new FormData($('#{{ $tab_name }}-form')[0]);
                send_ajax_formdata_request(
                    "{{ route('agencyInfo.InspectionEdit') }}",
                    fd,
                    function(res) {
                        console.log(res);
                        show_message("{{ __('Edited') }}");
                        open_edit_form(res.parent_id, '{{ $tab_name }}-info')
                        filter()
                    }
                )
            }
        </script>
    @endisset

@endif
