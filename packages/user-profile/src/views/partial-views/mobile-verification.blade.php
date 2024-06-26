<form action="javascript:void(0)" method="POST" id="mobile-verification">
    {{-- @method('PUT') --}}
    @csrf
    <div class="col-sm-12 mt-2">
        <label for="code" class="col-sm-12">کد تایید شماره موبایل</label>
        <input type="text" id="code" name="code" placeholder="کد 4 رقمی ..." class="col-sm-12 mb-2">
    </div>
    <button type="submit" onclick="generate()" class="col-sm-12 mt-2 btn btn-primary">تولید کد تایید</button>
    <button type="submit" onclick="verify()" class="col-sm-12 mt-2 btn btn-primary">تایید شماره موبایل</button>
</form>

<script>
    function generate() {
        fd = new FormData($('#mobile-verification')[0])
        send_ajax_formdata_request(
            "{{ route('user-profile.codeGenerator') }}",
            fd,
            function(res) {
                show_message(res);

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

            }
        )
    }
</script>
