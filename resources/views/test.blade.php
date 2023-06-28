@isset($data)
    <pre>
        @php
            print_r($data)
        @endphp
    </pre>
@endisset
@isset($result)
    <pre>
        @php
            print_r($result)
        @endphp
    </pre>
@endisset
{{phpinfo()}}
<form action="{{ route('test') }}" enctype="multipart/form-data" method="POST">
    @csrf
    <input type="file" name="file" id="">
    <input type="submit" name="" id="">
</form>



