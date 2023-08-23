@extends('layouts.app')

@section('content')
{{-- {{ $_SERVER['REMOTE_ADDR'] }} --}}
{{-- {{ env('PM_SERVER') }} --}}
{{ $pass }}
    @isset($error)
        <div class="alert alert-danger">{{$error}}</div>
    @endisset
    <iframe src="" frameborder="0"
        style="width: 100%; height: 85vh"
        id="iframeId"
    ></iframe>
    
@endsection
@section('script')
<script type="text/javascript">
    //change to the address and workspace of your ProcessMaker server:
    var restServer = "https://pmaker.altfuel.ir/workflow/";
  
    var jqxhr = $.ajax({
       type: "POST",
       url:  restServer + "oauth2/token",
       dataType: 'json',
       // insecure example of data to obtain access token and login:
       data: {
          grant_type   : 'password',
          scope        : '*',
          client_id    : 'NSQTKOWQUBZIYTZYBPWOTFOUJOIHWENA',
          client_secret: '93750749964e31e776029e1054980667',
          username     : 'rest_api',
          password     : 'Mk09376922176'        
       }
    })
    .done( function(data) {
       if (data.error) {
          alert("Error in login!\nError: " + data.error + "\nDescription: " + data.error_description);
       }
       else if (data.access_token) {
          //Can call REST endpoints here using the data.access_token.
  
          //To call REST endpoints later, save the access_token and refresh_token
          //as cookies that expire in one hour    
          var d = new Date();
          d.setTime(d.getTime() + 60*60*1000);
          document.cookie = "access_token="  + data.access_token  + "; expires=" + d.toUTCString();
          document.cookie = "refresh_token=" + data.refresh_token; //refresh token doesn't expire
          $('iframe').attr('src', 'https://pmaker.altfuel.ir/sysworkflow/en/neoclassic/setup/main')
       }
       else {
          alert(JSON.stringify(data, null, 4)); //for debug
       }
    })
    .fail(function(data, statusText, xhr) {
        console.log(data);
        console.log(statusText);
        console.log(xhr);
       alert("Failed to connect.\nHTTP status code: " + xhr.status + ' ' + statusText);
    });
  </script>
@endsection


