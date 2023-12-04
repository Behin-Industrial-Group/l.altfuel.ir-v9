@if (auth()->user()->access('Show Agency Debt Info'))
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
@endif