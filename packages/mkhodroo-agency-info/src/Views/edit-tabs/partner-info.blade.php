@if (auth()->user()->access('Show Agency Foreman Info'))
    @php
        $tab_name = 'partner';
    @endphp
    @isset(config("agency_info.customer_type.$customer_type->value")[$tab_name])
        <div class="tab-pane fade show" id="{{ $tab_name }}" role="tabpanel" aria-labelledby="{{ $tab_name }}-info">
            <form action="javascript:void(0)" id="{{ $tab_name }}-form">
                <input type="hidden" name="id" id="" value="{{ $customer_type->id ?? '' }}">
                <table class="table table-striped ">
                    @foreach (config("agency_info.customer_type.$customer_type->value")[$tab_name] as $field_key => $field_detail)
                        @php
                            $value = $agency_fields->where('key', $field_key)->first()?->value;
                        @endphp
                        <tr>
                            <td>
                                {{ __($field_key) }}
                            </td>
                            <td>
                                {{ $HtmlCreator::createInput($field_key, $field_detail, $value) }}
                            </td>
                        </tr>
                        @if (config('agency_info.show_non_valid_info'))
                            @php
                                $non_valid_value = $agency_fields->where('key', "non_valid_$field_key")->first()
                                    ?->value;
                            @endphp
                            <tr>
                                <td>
                                </td>

                                <td style="text-align: center; font-size: 10px">
                                    {{ __('non_valid_') . __($field_key) }}
                                    {{ $HtmlCreator::createInput("non_valid_$field_key", $field_detail, $non_valid_value) }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </table>
                <button class="btn btn-primary" onclick="{{ $tab_name }}_edit()">{{ __('Edit') }}</button>
            </form>
        </div>
        <script>
            function partner_edit() {
                var fd = new FormData($('#partner-form')[0]);
                send_ajax_formdata_request(
                    "{{ route('agencyInfo.partnerEdit') }}",
                    fd,
                    function(res) {
                        console.log(res);
                        show_message("{{ __('Edited') }}");
                        open_edit_form(res.parent_id, 'info')
                        filter()
                    }
                )
            }
        </script>
    @endisset

@endif
