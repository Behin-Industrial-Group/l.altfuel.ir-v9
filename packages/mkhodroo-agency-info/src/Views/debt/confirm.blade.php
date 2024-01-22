<div class="register-box card">
    <form method="POST" action="javascript:void(0)" style="margin: 5px" id="bedehi-form">
        @csrf
        <table class="table table-striped table-bordered">
            <input type="hidden" name="data" id="" value="{{ serialize($data) }}">
            @foreach ($debts as $debt)
                @if ($debt['price'])
                    <tr>
                        <td>{{ $debt['title'] }}</td>
                        <td>
                            {{ $debt['price'] }} ریال
                            <input type="hidden" name="agency_info_row_id[]" value="{{ $debt['id'] }}">
                        </td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td>{{ __('Total') }}</td>
                <td>
                    {{ $sum }} ریال
                    <input type="hidden" name="amount" id="" value="{{ $sum }}">
                    <p id="total_string"></p>
                    <script>
                        $('#total_string').html(Num2persian('{{ (int) $sum / 10 }}') + ' تومان')
                    </script>
                </td>
            </tr>
            <tr>
                <td class="col-sm-3"></td>
                <td class="col-sm-9">
                    <input type="submit" class="btn btn-success" onclick="pay()" value="پرداخت" />
                </td>
            </tr>
        </table>
    </form>
</div>
<div>
    <script>
        const type_input = $('input[name="type"]');
        type_input.click(function() {
            var value = $(this).val();
            const code_label = $('#code_label');
            if (value == 'agency') {
                code_label.html('کد 5 رقمی مرکز خدمات فنی')
            }
            if (value == 'low-pressure') {
                code_label.html('شماره صنفی پروانه کسب ')
            }
            if (value == 'hidrostatic') {
                code_label.html('کد 7 رقمی آزمایشگاه هیدرواستاتیک')
            }
        })
    </script>
    <script>
        function pay() {
            const form = $('#bedehi-form')[0];
            var fd = new FormData(form);
            send_ajax_formdata_request(
                '{{ route('pay') }}',
                fd,
                function(data) {
                    console.log(data);
                    show_message(data.message);
                    location.href = data.url
                }
            )
        }
    </script>
</div>
