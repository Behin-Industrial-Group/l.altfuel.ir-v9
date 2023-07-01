<form action="javascript:void(0)" id="{{ $form_id ?? 'comment-form' }}" enctype="multipart/form-data">
    @csrf
    @isset($ticket_id)
        <input type="hidden" name="ticket_id" id="" value="{{ $ticket_id }}">
    @endisset
    <div class="card">
        <div class="row">
            <div class="col-sm-12 p-2">
                <div class="input-group mb-3 col-sm-8 float-right">
                    <button class="btn btn-success" id="play-btn" style="display: none">پخش</button>
                    <textarea name="text" id="" class="form-control" style="border: none" rows="4" placeholder="متن پیام"></textarea>
                    <div class="input-group-append">
                        {{-- <div class="input-group-text" id="voice-input" style="cursor: pointer; background:rgb(207, 1, 1); color:white; text-align: center">
                            <span class="fa fa-microphone" ></span><br>
                            <span style="writing-mode: vertical-lr;">
                                نگه دارید
                            </span>
                        </div> --}}
                    </div>
                </div>
                <div class="col-sm-4 float-left" style="font-size: 15px">
                    پیوست: فایل های مجاز {{ json_encode(config('ATConfig.attachment-file-types-translate')) }}
                    <input type="file" name="file" class="filepond">
                </div>
                
            </div>
        </div>

    </div>

</form>
<div class="btn btn-success" id="submit-btn" onclick="submit()">
    ثبت
</div>


<script>
    $('.filepond').filepond();
    $('.filepond').filepond('storeAsFile', true);
</script>

<script type="text/javascript">
    // var recordAudio = () => {
    //     audio = '';
    //     return new Promise(async resolve => {
    //         const stream = await navigator.mediaDevices.getUserMedia({
    //             audio: true
    //         });
    //         const mediaRecorder = new MediaRecorder(stream);
    //         const audioChunks = [];

    //         mediaRecorder.addEventListener("dataavailable", event => {
    //             audioChunks.push(event.data);
    //         });

    //         const start = () => mediaRecorder.start();

    //         const stop = () =>
    //             new Promise(resolve => {
    //                 mediaRecorder.addEventListener("stop", () => {
    //                     const audioBlob = new Blob(audioChunks);
    //                     const audioUrl = URL.createObjectURL(audioBlob);
    //                     const audio = new Audio(audioUrl);
    //                     const play = () => audio.play();
    //                     resolve({
    //                         audioBlob,
    //                         audioUrl,
    //                         play
    //                     });
    //                 });

    //                 mediaRecorder.stop();
    //             });

    //         resolve({
    //             start,
    //             stop
    //         });
    //     });
    // }

    // /* simple timeout */
    // var sleep = time => new Promise(resolve => setTimeout(resolve, time));

    // /* init */
    // (async () => {
    //     const btn = $('#voice-input')[0];
    //     const playBtn = $('#play-btn');
    //     const recorder = await recordAudio();
    //     let audio; // filled in end cb
    //     const submitBtn = $('#submit-btn')



    //     const recStart = e => {
    //         console.log('start');
    //         recorder.start();
    //         btn.initialValue = btn.innerHTML;
    //         btn.innerHTML = "درحال ضبط...";
    //     }
    //     const recEnd = async e => {
    //         console.log('end');
    //         btn.innerHTML = btn.initialValue;
    //         audio = await recorder.stop();
    //         showPlayAudioBtn();
    //         // audio.play();
    //         // uploadAudio(audio.audioBlob);
    //     }

    //     const recPlay = e => {
    //         console.log('play');
    //         audio.play();
    //     }

    //     const showPlayAudioBtn = e => {
    //         console.log('show');
    //         playBtn.show()
    //     }


    //     const uploadAudio = a => {
    //         if (a.size > (10 * Math.pow(1024, 2))) {
    //             document.body.innerHTML += "Too big; could not upload";
    //             return;
    //         }
    //         const f = new FormData($('#{{ $form_id ?? 'comment-form' }}')[0]);

    //         if (audio) {
    //             a = audio.audioBlob;
    //             f.append("payload", a);
    //         }
    //         console.log('send');
    //         // f.append("nonce", window.nonce);
    //         send_ajax_formdata_request(
    //             "{{ route('ATRoutes.store') }}",
    //             f,
    //             function(response) {
    //                 ticket = response.ticket;
    //                 show_message(response.message)
    //                 console.log(response);
    //                 if (typeof(show_comment_modal) === "function") {
    //                     show_comment_modal(ticket.id, ticket.title, ticket.user_id)
    //                 } else {
    //                     // window.location = "{{ route('ATRoutes.show.listForm') }}"
    //                 }
    //             },
    //             function(data) {
    //                 show_error(data);
    //                 console.log(data);
    //             }
    //         )
    //     }


    //     btn.addEventListener("mousedown", recStart);
    //     btn.addEventListener("touchstart", recStart);
    //     btn.addEventListener("mouseup", recEnd);
    //     btn.addEventListener("touchend", recEnd);
    //     playBtn.on('click', recPlay);
    //     submitBtn.on('click', uploadAudio);
    //     playBtn.addEventListener("mousedown", recPlay);
    //     playBtn.addEventListener("touchstart", recPlay);
    // })();

    function submit() {
        const f = new FormData($('#{{ $form_id ?? 'comment-form' }}')[0]);

        // if(audio){
        //     a = audio.audioBlob;
        //     f.append("payload", a);
        // }
        console.log('send1');
        // f.append("nonce", window.nonce);
        send_ajax_formdata_request(
            "{{ route('ATRoutes.store') }}",
            f,
            function(response) {
                ticket = response.ticket;
                show_message(response.message)
                show_message("لطفا منتظر بمانید")
                console.log(response);
                if (typeof(show_comment_modal) === "function") {
                    show_comment_modal(ticket.id, ticket.title, ticket.user_id)
                } else {
                    window.location = "{{ route('ATRoutes.show.listForm') }}"
                }
            },
            function(data) {
                show_error(data);
                console.log(data);
            }
        )
    }
</script>
