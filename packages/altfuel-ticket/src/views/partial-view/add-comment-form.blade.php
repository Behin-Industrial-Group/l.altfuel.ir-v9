@php
    session_start();
    $_SESSION['nonce'] = substr(str_shuffle(MD5(microtime())), 0, 10);
@endphp
<form action="javascript:void(0)" id="{{ $form_id ?? 'comment-form' }}">
    @csrf
    @isset($ticket_title)
        <input type="hidden" name="title" id="" value="{{ $ticket_title }}">
    @endisset
    <div class="card">
        <div class="row">
            <div class="col-sm-3" id="voice">
                <input type="button" class="btn" id="voice-input" value="برای ضبط نگه دارید" />
                <button class="btn btn-success" id="play-btn" style="display: none">پخش</button>
            </div>
            <div class="col-sm-7">
                <textarea name="text" id="" class="form-control" rows="4"></textarea>
            </div>
            <div class="col-sm-2 float-left">
                <button class="btn btn-success float-left" id="submit-btn">ثبت</button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    // window.nonce = "<?php echo $_SESSION['nonce']; ?>"
    // courtesy https://medium.com/@bryanjenningz/how-to-record-and-play-audio-in-javascript-faa1b2b3e49b
    var recordAudio = () => {
        audio = '';
      return new Promise(async resolve => {
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        const mediaRecorder = new MediaRecorder(stream);
        const audioChunks = [];

        mediaRecorder.addEventListener("dataavailable", event => {
          audioChunks.push(event.data);
        });

        const start = () => mediaRecorder.start();

        const stop = () =>
          new Promise(resolve => {
            mediaRecorder.addEventListener("stop", () => {
              const audioBlob = new Blob(audioChunks);
              const audioUrl = URL.createObjectURL(audioBlob);
              const audio = new Audio(audioUrl);
              const play = () => audio.play();
              resolve({ audioBlob, audioUrl, play });
            });

            mediaRecorder.stop();
          });

        resolve({ start, stop });
      });
    }

    /* simple timeout */
    var sleep = time => new Promise(resolve => setTimeout(resolve, time));

    /* init */
    (async () => {
        const btn = $('#voice-input')[0];
        const playBtn = $('#play-btn');
        const recorder = await recordAudio();
        let audio; // filled in end cb
        const submitBtn = $('#submit-btn')
        


        const recStart = e => {
            console.log('start');
            recorder.start();
            btn.initialValue = btn.value;
            btn.value = "درحال ضبط...";
        }
        const recEnd = async e => {
            console.log('end');
            btn.value = btn.initialValue;
            audio = await recorder.stop();
            showPlayAudioBtn();
            // audio.play();
            // uploadAudio(audio.audioBlob);
        }

        const recPlay = e => {
            console.log('play');
            audio.play();
        }

        const showPlayAudioBtn = e => {
            console.log('show');
            playBtn.show()
        }


        const uploadAudio = a => {
            // if (a.size > (10 * Math.pow(1024, 2))) {
            //     document.body.innerHTML += "Too big; could not upload";
            //     return;
            // }
            a = audio.audioBlob;
            console.log('send');
            const f = new FormData($('#{{ $form_id ?? "comment-form" }}')[0]);
            // f.append("nonce", window.nonce);
            f.append("payload", a);
            send_ajax_formdata_request(
                "{{ route('ATRoutes.store') }}",
                f,
                function(ticket){
                    console.log(ticket);
                    show_comment_modal(ticket.id, ticket.title, ticket.user_id)
                },
                function(data){
                    show_error(data);
                    console.log(data);
                }
            )
        }


        btn.addEventListener("mousedown", recStart);
        btn.addEventListener("touchstart", recStart);
        btn.addEventListener("mouseup", recEnd);
        btn.addEventListener("touchend", recEnd);
        playBtn.on('click', recPlay);
        submitBtn.on('click', uploadAudio);
        // playBtn.addEventListener("mousedown", recPlay);
        // playBtn.addEventListener("touchstart", recPlay);
    })();
    
</script>  