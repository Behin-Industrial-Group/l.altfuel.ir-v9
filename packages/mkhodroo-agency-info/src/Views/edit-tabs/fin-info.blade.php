@if (auth()->user()->access('Show Agency Fin Info'))
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
            {{ $HtmlCreator::createInput($field_key, $field_detail, $value) }}
        @endforeach
        <button class="btn btn-primary" onclick="fin_edit()">{{ __('Edit') }}</button>
    </form>
</div>
@endif