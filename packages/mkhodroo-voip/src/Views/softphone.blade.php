@extends('layouts.app')
@section('title')
    Altfuel Softphone
@endsection
@section('script_in_head')
    <meta charset="utf-8" />
    <script src="{{ url('public/webphone/webphone_api.js?jscodeversion=733') }}"></script>
@endsection
@section('content')
    <div>This is the simplest example to demonstrate how to handle an incoming call and display the caller's
        name.<br />Don't use this in production as it is not a complete implementation.<br /><br /><br /></div>
    <div id="caller_info"></div>
    <div id="caller_info_name"></div>
    <div id="caller_info_line"></div>
    <div id="call_history_id"></div>
    <div id="start_time"></div>
    <div id="end_time"></div>

    <div id="after_accept_call" style="display: none">
        <div class="row">
            <div class="col-sm-6">
                <button id="btn_hangup" onclick="Hangup()" class="btn btn-danger">{{ __('Hangup') }}</button>
            </div>
            <div class="row col-sm-6">
                <input type="text" name="transfer_number" id="transfer_number" class="form-control col-sm-8">
                <button id="btn_transfer" onclick="Transfer()" class="btn btn-success">{{ __('Transfer') }}</button><br />
            </div>
        </div>
    </div>
    <div id="icoming_call_layout" class="row" style="display: none;">
        <button id="btn_accept" onclick="Accept()" class="btn btn-success col-sm-6">{{ __('Accept') }}</button>
        <button id="btn_reject" onclick="Reject()" class="btn btn-danger col-sm-6">{{ __('Reject') }}</button><br />
    </div>

    <div class="row" id="call">
        <input type="text" name="callto" id="callto" class="form-control text-center ">
        <button class="col-sm-4 btn btn-default" onclick="dial(3)">3</button>
        <button class="col-sm-4 btn btn-default" onclick="dial(2)">2</button>
        <button class="col-sm-4 btn btn-default" onclick="dial(1)">1</button>
        <button class="col-sm-4 btn btn-default" onclick="dial(6)">6</button>
        <button class="col-sm-4 btn btn-default" onclick="dial(5)">5</button>
        <button class="col-sm-4 btn btn-default" onclick="dial(4)">4</button>
        <button class="col-sm-4 btn btn-default" onclick="dial(9)">9</button>
        <button class="col-sm-4 btn btn-default" onclick="dial(8)">8</button>
        <button class="col-sm-4 btn btn-default" onclick="dial(7)">7</button>
        <button class="col-sm-4 btn btn-default" onclick="dial('*')">*</button>
        <button class="col-sm-4 btn btn-default" onclick="dial(0)">0</button>
        <button class="col-sm-4 btn btn-default" onclick="dial('#')">#</button>
        <button id="button_click2call" style="width: 100%;" class="btn btn-success"
            onclick="ButtonOnclick()">{{ __('Call') }}</button>
    </div>
    <iframe allow="microphone; camera; autoplay" style="display:none" height="0" width="0" id="loader"></iframe>

    <script>
        function dial(char) {
            $('#callto').val($('#callto').val() + char)
        }
        var btnc2c = document.getElementById("button_click2call");


        function ButtonOnclick() {
            if (webphone_api.isincall() === true) {
                webphone_api.hangup();
                btnc2c.innerHTML = '{{ __('Call') }}';
            } else {
                webphone_api.call($('#callto').val());
                btnc2c.innerHTML = '{{ __('Hangup') }}';
            }
        }
    </script>
    <script>
        webphone_api.onAppStateChange(function(state) {
            if (state === 'loaded') {
                webphone_api.setparameter('serveraddress', 'voip.altfuel.ir');
                webphone_api.setparameter('username', '113');
                webphone_api.setparameter('password', '2418a355572fc2bf16b0b67b50bbf540');

                webphone_api.start();
            }
        });

        function Hangup() {
            webphone_api.hangup();
            document.getElementById('after_accept_call').style.display = 'none';
            $('#call').show()
            var fd = new FormData();
            fd.append('id', $('#call_history_id').html());
            fd.append('duration', Date.now().toString() - $('#start_time').html())
            send_ajax_formdata_request(
                "{{ route('voip.callHistory.update') }}",
                fd,
                function(res) {
                    display_element_when_disconnected()
                }
            )
        }

        function Accept() {
            document.getElementById('icoming_call_layout').style.display = 'none';
            document.getElementById('after_accept_call').style.display = 'block';
            webphone_api.accept();
            var fd = new FormData();
            fd.append('id', $('#call_history_id').html());
            fd.append('status', "{{ config('voip-config.call-status.answered') }}")
            send_ajax_formdata_request(
                "{{ route('voip.callHistory.update') }}",
                fd,
                function(res) {
                    $('#start_time').html(Date.now())
                }
            )
        }

        function Transfer() {
            var transfer_number = $('#transfer_number').val();
            if (transfer_number === '') {
                show_error("{{ __('enter a valid number') }}")
            }
            webphone_api.transfer(transfer_number);
            document.getElementById('after_accept_call').style.display = 'none';
            $('#call').show()
            var fd = new FormData();
            fd.append('id', $('#call_history_id').html());
            fd.append('duration', Date.now().toString() - $('#start_time').html())
            send_ajax_formdata_request(
                "{{ route('voip.callHistory.update') }}",
                fd,
                function(res) {
                    display_element_when_disconnected()
                }
            )

        }

        function Reject() {
            document.getElementById('icoming_call_layout').style.display = 'none';
            document.getElementById('after_accept_call').style.display = 'none';
            $('#call').show()
            webphone_api.reject();
        }
        // to initiate an outgoing you would call the following API function   webphone_api.call(DESTINATION_NUMBER);

        // handling actions on call state change
        webphone_api.onCallStateChange(function(event, direction, peername, peerdisplayname, line, callid) {
            if (event === 'setup') {
                if (direction == 1) {
                    // means it's outgoing call
                } else if (direction == 2) {
                    // means it's icoming call
                    document.getElementById('icoming_call_layout').style.display = 'inline';
                    $('#call').hide()
                    document.getElementById('caller_info').innerHTML = peerdisplayname;
                    document.getElementById('caller_info_name').innerHTML = peername;
                    document.getElementById('caller_info_line').innerHTML = line;
                    send_sms(peerdisplayname)

                }
            }

            // end of a call, even if it wasn't successfull
            if (event === 'disconnected') {
                display_element_when_disconnected()
                btnc2c.innerHTML = '{{ __('Call') }}';

            }
        });

        function display_element_when_disconnected() {
            document.getElementById('icoming_call_layout').style.display =
                'none'; // hide Accept, Reject buttons
            $('#callto').show();
            document.getElementById('caller_info').innerHTML = '';
            document.getElementById('caller_info_name').innerHTML = '';
            document.getElementById('caller_info_line').innerHTML = '';
            document.getElementById('call_history_id').innerHTML = '';
            document.getElementById('start_time').innerHTML = '';
            document.getElementById('end_time').innerHTML = '';
        }

        function send_sms(number) {
            if (number[0] == '9' && number[1] == '8' && number[2] == '9') {
                //its mobile number
                number = number.substring(1);
                number = number.substring(1);
                number = '0' + number;
                console.log(number);
                url = '{{ route('smsTemplate.send', ['sms_id' => '14030101', 'to' => 'number']) }}';
                url = url.replace("number", number);
                console.log(url)
                send_ajax_get_request(
                    url,
                    function(res) {
                        console.log('sms sended')
                    }
                )
            }
        }


        function create_history() {
            var fd = new FormData();
            fd.append('from', peerdisplayname);
            fd.append('status', "{{ config('voip-config.call-status.no-answer') }}")
            send_ajax_formdata_request(
                "{{ route('voip.callHistory.create') }}",
                fd,
                function(res) {
                    $('#call_history_id').html(res.id)
                }
            )
        }
    </script>
@endsection
