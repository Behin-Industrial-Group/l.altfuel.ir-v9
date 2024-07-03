@if (auth()->user()->access('Validate Mobile In Profile'))
    <div class="col-sm-4">
        <label for="code" class="col-sm-12">{{ __('Mobile Verification') }}</label>
    </div>
    <div class="col-sm-8">
        @if (auth()->user()?->mobile_verified)
            {{ __('Mobile Verified') }}
        @else
            <div id="send-code">
                <button class="btn btn-success" onclick="generate()"
                    class="col-sm-12 mt-2 btn btn-primary">{{ __('Send Code') }}</button>
            </div>
            <form action="javascript:void(0)" method="POST" id="mobile-verification">
                @csrf
                <div class="col-sm-12 mt-2">
                    <input type="text" id="code" name="code" placeholder="کد 4 رقمی ..."
                        class="col-sm-12 mb-2">
                </div>
                <button type="submit" onclick="verify()"
                    class="col-sm-12 mt-2 btn btn-primary">{{ __('Verify') }}</button>
            </form>
        @endif
    </div>

    <script>
        var mobile_verification_form = $('#mobile-verification');
        var send_code = $('#send-code')

        function change_verify_display() {
            if (mobile_verification_form.css('display') == 'none') {
                mobile_verification_form.show();
            } else {
                mobile_verification_form.hide();
            }
        }

        function change_send_code_display() {
            if (send_code.css('display') == 'none') {
                send_code.show();
            } else {
                send_code.hide();
            }
        }

        change_verify_display()

        function generate() {
            fd = new FormData()
            send_ajax_formdata_request(
                "{{ route('user-profile.codeGenerator') }}",
                fd,
                function(res) {
                    show_message(res);
                    change_send_code_display()
                    change_verify_display()
                }
            )
        }

        function verify() {
            fd = new FormData($('#mobile-verification')[0])
            send_ajax_formdata_request(
                "{{ route('user-profile.verify') }}",
                fd,
                function(res) {
                    show_message(res);
                    location.reload()
                }
            )
        }
    </script>
@endif
