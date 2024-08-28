@if (auth()->user()->access('Show Agency Doc Info'))
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
                @if (config('agency_info.show_non_valid_info'))
                    <tr>
                        <td>
                        </td>
                        @php
                            $non_valid_value = $agency_fields->where('key', "non_valid_$field_detail")->first()?->value;
                        @endphp
                        <td style="text-align: center; font-size: 10px">
                            {{ __("non_valid_") . __($field_detail) }}<br>
                            @if ($non_valid_value)
                                <a href="{{ url("public/$non_valid_value") }}"
                                    download="{{ __("non_valid_") . __($field_detail) }}">{{ __("non_valid_") . __($field_detail) }}</a>
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        </table>
        <button class="btn btn-primary" onclick="docs_edit()">{{ __('Edit') }}</button>
    </form>
</div>
@endif