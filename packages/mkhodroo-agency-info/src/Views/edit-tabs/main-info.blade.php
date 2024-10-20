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

                                @if ($field_key === 'agency_code')
                                    <input type="text" name="{{ $field_key }}" value="{{ $value }}"
                                        class="form-control" id="{{ $field_key }}"
                                        @if (isset($field_detail['disabled']) and $field_detail['disabled'] === true) disabled @endif>
                                    <span id="gen_code" class="col-sm-3"
                                        style="background: #db4f4f;padding-top:5px; height:32px; text-align:center; font-weight:bold; cursor:pointer">
                                        تولید کد
                                    </span>
                                    <script>
                                        $('#gen_code').on('click', function() {
                                            var city = $('#city').val();
                                            var nationalId = $('#national_id').val();
                                            var postalCode = $('#postal_code').val();
                                            let formData = new FormData();

                                            formData.append('city', city);
                                            formData.append('national_id', nationalId);
                                            formData.append('postal_code', postalCode);
                                            formData.append('customer_type', "{{ $customer_type->value }}")
                                            send_ajax_formdata_request(
                                                "{{ route('agencyInfo.codeGenerator') }}",
                                                formData,
                                                function(response) {
                                                    console.log(response);
                                                    alert(response.msg)
                                                }
                                            )
                                            // send_ajax_get_request(
                                            //     "{{ url('GenCode') }}/{{ $customer_type->value }}/" + city,
                                            //     function(data) {
                                            //         alert('کد جدید:  ' + data)
                                            //         console.log(data);
                                            //     }
                                            // )
                                        })
                                    </script>
                                @elseif ($field_key === 'exp_date')
                                    <input type="hidden" id="exp_date" value="{{ $value }}" name="exp_date">
                                    <input type="text" id="exp_date_view" class="form-control">
                                    <script>
                                        $(document).ready(function() {
                                            $("#exp_date_view").persianDatepicker({
                                                format: 'YYYY-MM-DD',
                                                toolbox: {
                                                    calendarSwitch: {
                                                        enabled: true
                                                    }
                                                },
                                                initialValue: false,
                                                observer: true,
                                                altField: '#exp_date'
                                            });
                                        });

                                        var ExpDateData = "{{ $value }}";
                                        var ExpDate = convertTimeStampToJalali(parseInt(ExpDateData));
                                        $("#exp_date_view").val(ExpDate);

                                        function convertTimeStampToJalali(timestamp) {
                                            var date = new Date(timestamp);
                                            if (!date)
                                                return false;
                                            return (gregorian_to_jalali(date.getFullYear(), (date.getMonth() + 1), date.getDate()));
                                        }

                                        function gregorian_to_jalali(gy, gm, gd) {
                                            g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
                                            if (gy > 1600) {
                                                jy = 979;
                                                gy -= 1600;
                                            } else {
                                                jy = 0;
                                                gy -= 621;
                                            }
                                            gy2 = (gm > 2) ? (gy + 1) : gy;
                                            days = (365 * gy) + (parseInt((gy2 + 3) / 4)) - (parseInt((gy2 + 99) / 100)) + (parseInt((gy2 + 399) / 400)) -
                                                80 + gd + g_d_m[gm - 1];
                                            jy += 33 * (parseInt(days / 12053));
                                            days %= 12053;
                                            jy += 4 * (parseInt(days / 1461));
                                            days %= 1461;
                                            if (days > 365) {
                                                jy += parseInt((days - 1) / 365);
                                                days = (days - 1) % 365;
                                            }
                                            jm = (days < 186) ? 1 + parseInt(days / 31) : 7 + parseInt((days - 186) / 30);
                                            jd = 1 + ((days < 186) ? (days % 31) : ((days - 186) % 30));
                                            return jy + '/' + jm + '/' + jd;
                                        }
                                    </script>
                                @else
                                    <input type="text" name="{{ $field_key }}" value="{{ $value }}"
                                        class="form-control" id="{{ $field_key }}"
                                        @if (isset($field_detail['disabled']) and $field_detail['disabled'] === true) disabled @endif>
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
