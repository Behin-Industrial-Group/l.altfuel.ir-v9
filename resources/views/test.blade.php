
    @isset($error)
        <div class="alert alert-danger">{{$error}}</div>
    @endisset
    @if(!isset($error))
        <script>
            window.location = '{{ $src ?? '' }}';
        </script>
    @endisset   


