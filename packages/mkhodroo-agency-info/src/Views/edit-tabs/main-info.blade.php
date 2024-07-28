@if (auth()->user()->access('نمایش اطلاعات مرکز'))
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
                                    class="form-control" id="{{ $field_key }}"
                                    @if (isset($field_detail['disabled']) and $field_detail['disabled'] === true) disabled @endif>
                                @if ($field_key === 'agency_code')
                                    <span id="gen_code" class="col-sm-3"
                                        style="background: #db4f4f;padding-top:5px; height:32px; text-align:center; font-weight:bold; cursor:pointer">
                                        تولید کد
                                    </span>
                                    <script>
                                        $('#gen_code').on('click', function() {
                                            var province = $('#province').val();
                                            send_ajax_get_request(
                                                "{{ url('GenCode') }}/{{ $customer_type->value }}/" + province,
                                                function(data) {
                                                    alert('کد جدید:  ' + data)
                                                    console.log(data);
                                                }
                                            )
                                        })
                                    </script>
                                @endif
                            @endif
                            @if ($field_detail['type'] == 'select')
                                <select name="{{ $field_key }}" class="form-control select2 col-sm-12"
                                    id="{{ $field_key }}">
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
                                                        if (item.name) {
                                                            var opt = new Option(item.name, item.id)
                                                        } else {
                                                            var opt = new Option(item.province + ' - ' + item.city, item.id)
                                                        }
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
                            @if ($field_detail['type'] == 'textarea')
                                {{ $HtmlCreator::createInput($field_key, $field_detail, $value) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
            <button class="btn btn-primary" onclick="edit()">{{ __('Edit') }}</button>
        </form>
    </div>
@endif
