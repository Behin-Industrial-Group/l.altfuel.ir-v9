    @php
        $tab_name = 'last_action';
        $prefix_key_name = 'last_action_';
        $fields = collect($agency_fields)->filter(function ($item) {
            if (stristr($item->key, 'last_action')) {
                return $item;
            }
        });

    @endphp
    <div class="tab-pane fade show" id="{{ $tab_name }}" role="tabpanel" aria-labelledby="{{ $tab_name }}-info">
        <form action="javascript:void(0)" id="{{ $tab_name }}-form" enctype="multipart/form-data">
            <input type="hidden" name="id" id="" value="{{ $customer_type->id ?? '' }}">
            <table class="table table-striped ">
                @foreach ($fields as $item)
                    @php
                        $timestamp = explode('@', $item->key)[1];
                        $action = $item->value;
                        $file = $item->description;
                    @endphp
                    <tr>
                        <td id="{{ $timestamp }}">
                            <script>
                                var date = new persianDate.unix({{ $timestamp }});
                                console.log(date);
                                
                                $('#{{ $timestamp }}').html(date.year() + '/' + date.month() + '/' + date.date())
                                
                            </script>
                        </td>
                        <td>{{ $action }}</td>
                        <td>
                            @if ($file)
                                <a href="{{ url("public/$file") }}"
                                    download="{{ __('last-action') }}">{{ __('Attachment') }}</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2">
                        <input type="text" name="last_action" id="" class="form-control">
                    </td>
                    <td>
                        <input type="file" name="last_action_file" id="">
                    </td>
                </tr>
            </table>
            <button class="btn btn-primary" onclick="{{ $tab_name }}_edit()">{{ __('Edit') }}</button>
        </form>
    </div>
    <script>
        function last_action_edit() {
            var fd = new FormData($('#{{ $tab_name }}-form')[0]);
            send_ajax_formdata_request(
                "{{ route('agencyInfo.createNewAction') }}",
                fd,
                function(res) {
                    console.log(res);
                    show_message("{{ __('Edited') }}");
                    open_edit_form(res.parent_id, '{{ $tab_name }}-info')
                    filter();
                }
            )
        }
    </script>
