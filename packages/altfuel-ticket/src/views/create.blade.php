@extends('layouts.app')

@php
    $title = "ایجاد تیکت پشتیبانی";
    session_start();
    $_SESSION['nonce'] = substr(str_shuffle(MD5(microtime())), 0, 10);
@endphp

@section('content')
    <div class="card card-info">
        <div class="card-header">
            ایجاد تیکت پشتیبانی
        </div>
        <div class="card-body">
            <form action="javascript:void(0)" id="ticket-form">
                @csrf
                <div class="form-group">
                    <label for="">دسته بندی</label>
                    <select name="" id="parent_cat" class="select2"></select>
                    <select name="catagory" id="child_cat" class="select2"></select>
                </div>
                <div class="form-group">
                    <label for="">عنوان</label>
                    <input type="text" name="title" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">متن پیام</label>
                    <textarea name="text" id="" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group" id="voice">
                    <input type="button" class="btn" id="voice-input" value="برای ضبط نگه دارید" />
                    <button class="btn btn-success" id="play-btn" style="display: none">پخش</button>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" id="submit-btn">ثبت</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var parent_cat = $('#parent_cat')
        send_ajax_get_request(
            "{{ route('ATRoutes.catagory.getAllParent') }}",
            function(data){
                
                data.forEach(element => {
                    parent_cat.append(new Option(`${element.name}`, element.id));
                });
            }
        );
        parent_cat.on('change', function(){
            getChildrenByParentId($(this).val())
            console.log($(this).val());
        })
        function getChildrenByParentId(parentId){
            var url = "{{ route('ATRoutes.catagory.getChildrenByParentId', ['parent_id' => 'parent_id']) }}";
            url = url.replace('parent_id', parentId)
            var child_cat = $('#child_cat')
            send_ajax_get_request(
                url,
                function(data){
                    child_cat.html('');
                    data.forEach(element => {
                        child_cat.append(new Option(element.name, element.id))
                    });
                    console.log(data);
                }
            )
        }
    </script> 
    <script type="text/javascript">
        window.nonce = "<?php echo $_SESSION['nonce']; ?>"
        // courtesy https://medium.com/@bryanjenningz/how-to-record-and-play-audio-in-javascript-faa1b2b3e49b
        const recordAudio = () => {
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
        const sleep = time => new Promise(resolve => setTimeout(resolve, time));

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
                console.log('send');
                const f = new FormData($('#ticket-form')[0]);
                f.append("nonce", window.nonce);
                f.append("payload", a);

                fetch("{{ route('ATRoutes.store') }}", {
                    method: "POST",
                    body: f,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                })
                .then(response => {
                    console.log(response);
                    // $('#voice').append(`<br/> <a href="audio.wav">saved; click here</a>`);
                    // document.body.innerHTML += `
                    //     <br/> <a href="audio.wav">saved; click here</a>
                    // `
                });
            }


            btn.addEventListener("mousedown", recStart);
            btn.addEventListener("touchstart", recStart);
            btn.addEventListener("mouseup", recEnd);
            btn.addEventListener("touchend", recEnd);
            playBtn.on('click', recPlay);
            submitBtn.on('click', uploadAudio(audio.audioBlob));
            // playBtn.addEventListener("mousedown", recPlay);
            // playBtn.addEventListener("touchstart", recPlay);
        })();
        

    </script>  
    <script>
        function submitForm(){
            var data = new FormData($('#ticket-form')[0])
            data.append()
            send_ajax_formdata_request(
                "{{ route('ATRoutes.store') }}",
                data,
                function(data){
                    console.log(data);
                }
            )
            // send_ajax_request(
            //     "{{ route('ATRoutes.store') }}",
            //     data,
            //     function(data){
            //         console.log(data);
            //     }
            // )
        }
    </script>
@endsection