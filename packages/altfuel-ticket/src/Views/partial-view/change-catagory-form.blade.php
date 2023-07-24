<form action="javascript:void(0)" id="{{ $form_id ?? 'change-cat-form' }}" enctype="multipart/form-data">
    @csrf
    @isset($ticket_id)
        <input type="hidden" name="ticket_id" id="" value="{{ $ticket_id }}">
    @endisset
    <div class="card">
        <div class="row">
            <div class="col-sm-12 p-2">
                <div class="input-group mb-3 col-sm-12 float-right">
                    <button class="btn btn-success" id="play-btn" style="display: none">پخش</button>
                    <div class="input-group-append">
                        @include('ATView::partial-view.catagory')
                    </div>
                    <div class="btn btn-danger" id="submit-btn" onclick="change_cat()">
                        تغییر دسته بندی
                    </div>
                </div>
            </div>
        </div>

    </div>

</form>



<script>
    $('.filepond').filepond();
    $('.filepond').filepond('storeAsFile', true);
</script>

<script type="text/javascript">
    function change_cat() {
        const f = new FormData($('#{{ $form_id ?? 'change-cat-form' }}')[0]);
        send_ajax_request_with_confirm(
            "{{ route('ATRoutes.changeCatagory') }}",
            $('#{{ $form_id ?? 'change-cat-form' }}').serialize(),
            function(response) {
                show_message("{{ trans('ATTrans.success') }}")
                filter()
            },
            function(data) {
                show_error(data);
                console.log(data);
            }
        )
    }
</script>
