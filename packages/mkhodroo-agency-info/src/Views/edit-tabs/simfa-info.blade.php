@if (auth()->user()->access('Show Agency Simfa Info'))
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
                            {{ $HtmlCreator::createInput($field_key, $field_detail, $value) }}
                        </td>
                    </tr>
                @endforeach
            </table>
            <button class="btn btn-primary" onclick="simfa_edit()">{{ __('Edit') }}</button>
        </form>
    </div>
@endisset

@endif