@if (auth()->user()->access('امتیاز دهی به تیکت'))
    

<link rel="stylesheet" href="{{ url('public/packages/altfuel-ticket/css/style.css')}}">


<form action="" class="score col-12">
    <section class="d-flex justify-content-between row">
        <section class="col-sm-6">
            <p>نظر شما در مورد کیفیت پاسخگویی(محرمانه خواهد ماند) : </p>
        </section>
        <section class="col-sm-6">
            <label class="score-label" id="heart" onclick="set_score(5)">&#128525;</label>
            <label class="score-label" id="happy" onclick="set_score(4)">&#128578;</label>
            <label class="score-label" id="poker" onclick="set_score(3)">&#128528;</label>
            <label class="score-label" id="sad" onclick="set_score(2)">&#128577;</label>
            <label class="score-label" id="angry" onclick="set_score(1)">&#128545;</label>
        </section>
    </section>
</form>

<script src="{{ url('public/packages/altfuel-ticket/js/script.js')}}"></script>

<script>
    function set_score(score){
        var fd = new FormData();
        fd.append('ticket_id', "{{ $ticket_id }}")
        fd.append('score', score)
        send_ajax_formdata_request(
            "{{ route('ATRoutes.setScore') }}",
            fd,
            function(res){
                show_message("{{ __('score set') }}")
                show_score()
            },
            function(res){
                show_error(res);
            }
        )
    }

    show_score()
    function show_score(){
        var url = "{{ route('ATRoutes.get.score', ['id' => $ticket_id]) }}"
        send_ajax_get_request(
            url,
            function(res){
                $('.score-label').css({
                    "filter": "grayscale(100)"
                })
                if(res == 5){
                    $('#heart').css({
                        "filter": "grayscale(0)"
                    })
                }
                if(res == 4){
                    $('#happy').css({
                        "filter": "grayscale(0)"
                    })
                }
                if(res == 3){
                    $('#poker').css({
                        "filter": "grayscale(0)"
                    })
                }
                if(res == 2){
                    $('#sad').css({
                        "filter": "grayscale(0)"
                    })
                }
                if(res == 1){
                    $('#angry').css({
                        "filter": "grayscale(0)"
                    })
                }
            }
        )
    }
</script>

@endif

