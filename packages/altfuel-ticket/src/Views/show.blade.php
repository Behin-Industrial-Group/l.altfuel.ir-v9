<div class="row">
    <div class="col-sm-4">
        {{ $ticket->user()->display_name }} <br>
        شماره همراه: {{ $ticket->user()->email ?? '' }}
    </div>
    <div class="row col-sm-8">
        @foreach (config('ATConfig.status') as $key => $status)
            <div class="col-sm-3 p-1">
                <button class="btn col-sm-12 status-btn" id="{{ $key }}"
                    onclick="change_status('{{ $key }}')">{{ __($status) }}
                </button>
            </div>
        @endforeach
    </div>
</div>
<hr>
<div class="direct-chat-messages" style="height: 500px">
    @foreach ($ticket->comments() as $comment)
        <div class="direct-chat-msg {{ $comment->user()->id === auth()->user()->id ? 'right' : '' }}">
            <div class="direct-chat-infos clearfix">

            </div>
            <img class="direct-chat-img" src="{{ url('public/dashboard/dist/img/avatar5.png') }}"
                alt="message user image">
            <div class="direct-chat-text">
                <div>
                    <span class="direct-chat-name">{{ $comment->user()->display_name ?? '' }}</span>
                    <span class="direct-chat-timestamp float-left">{{ verta($comment->created_at) }}</span>
                </div>

                <hr>
                {{ $comment->text ?? '' }} <br>
                @empty(!$comment->voice)
                    <div class="green-player">
                        <audio controls>
                            <source src="{{ url("$comment->voice") }}" type="audio/wav">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                @endempty
                @foreach ($comment->attachments() as $attach)
                    <a href="{{ url("$attach->file") }}" target="_blank">پیوست</a>
                @endforeach

            </div>
        </div>
        <div id="end"></div>
    @endforeach
</div>


@if ($ticket->status === config('ATConfig.status.closed'))
    <div class="alert alert-danger">
        {{ __('This ticket is closed') }}
    </div>
@else
    <div class="card-body">
        @include('ATView::partial-view.add-comment-form', [
            'form_id' => 'comment-form',
            'ticket_id' => $ticket->ticket_id,
        ])
    </div>

    @if (auth()->user()->access('change-catagory'))
        <div class="card-body">
            @include('ATView::partial-view.change-catagory-form', [
                'form_id' => 'chage-cat-form',
                'ticket_id' => $ticket->ticket_id,
            ])
        </div>
    @endif
@endif



<script>
    change_status_btn_color()

    function change_status_btn_color() {
        url = "{{ route('ATRoutes.get.status', ['id' => 'id']) }}"
        url = url.replace('id', '{{ $ticket->ticket_id }}')
        send_ajax_get_request(
            url,
            function(res) {
                $('.status-btn').css('background', '#f8f9fa')
                console.log(res);
                $('#' + res).css('background', 'red')
            }
        )
    }

    function change_status(status_key) {
        fd = new FormData()
        fd.append('ticket_id', '{{ $ticket->ticket_id }}')
        fd.append('status_key', status_key)
        send_ajax_formdata_request(
            "{{ route('ATRoutes.changeStatus') }}",
            fd,
            function(res) {
                console.log(res);
                change_status_btn_color()
            }
        )
    }
</script>
