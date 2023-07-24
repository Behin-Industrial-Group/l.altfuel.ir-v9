<div class="row">
    {{ $ticket->user()->display_name }} <br>
    شماره همراه:  {{ $ticket->user()->email ?? '' }}
</div>
<div class="direct-chat-messages" style="height: 500px">
    @foreach ($ticket->comments() as $comment)
            <div class="direct-chat-msg {{ ($comment->user()->id === auth()->user()->id) ? 'right' : '' }}">
                <div class="direct-chat-infos clearfix">
                
                </div>
                <img class="direct-chat-img" src="{{ url('public/dashboard/dist/img/avatar5.png') }}" alt="message user image">
                <div class="direct-chat-text">
                    <div>
                        <span class="direct-chat-name">{{ $comment->user()->display_name ?? '' }}</span>
                        <span class="direct-chat-timestamp float-left">{{ $comment->created_at }}</span>
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
                    @foreach($comment->attachments() as $attach)
                        <a href="{{ url("$attach->file") }}" target="_blank">پیوست</a>
                    @endforeach
                    
                </div>
            </div>
            <div id="end"></div>
    @endforeach
</div>
<div class="card-body">
    @include('ATView::partial-view.add-comment-form', ['form_id' => 'comment-form', 'ticket_id' => $ticket->ticket_id])
</div>

@if(auth()->user()->access('change-catagory'))
<div class="card-body">
    @include('ATView::partial-view.change-catagory-form', ['form_id' => 'chage-cat-form', 'ticket_id' => $ticket->ticket_id])
</div>
@endif


