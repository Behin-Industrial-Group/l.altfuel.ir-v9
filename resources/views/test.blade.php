
    @isset($error)
        <div class="alert alert-danger">{{$error}}</div>
    @endisset
    <iframe src="{{ $src ?? '' }}" frameborder="0"
        style="width: 100%; height: 100vh"
        id="iframeId"
    ></iframe>


