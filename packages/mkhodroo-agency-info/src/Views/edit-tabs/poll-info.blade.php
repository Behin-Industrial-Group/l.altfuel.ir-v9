@if (auth()->user()->access('Show Agency Poll Info'))
@php
    $tab_name = "poll-info";
@endphp
    <div class="tab-pane fade show" id="{{$tab_name}}" role="tabpanel" aria-labelledby="{{$tab_name}}-info">
        @php
            $agency_code = $agency_fields->where('key', 'agency_code')->first()?->value;
        @endphp
        <div id="col-sm-12 row" style="background: red">
            <div class="col-sm-6" id="numberOfSms">{{ __('number of sended sms') }} =  </div>
        </div>
        <div class="row" id="averages">

        </div>
        @if ($agency_code)
        <script>
            url = "{{ route('irngvPoll.getUsers', ['agency_code' => 'agency_code']) }}";
            url = url.replace('agency_code', '{{$agency_code}}')
            send_ajax_get_request(
                url,
                function(res){
                    $('#numberOfSms').append(res.numberOfSms);
                    var averagesDiv = $('#averages');
                    for(var key in res.data){
                        averagesDiv.append(`<div class='col-sm-12'>${key} = ${res.data[key]}</div>`)
                    }
                }
            )
        </script>
        @endif
        
    </div>

@endif