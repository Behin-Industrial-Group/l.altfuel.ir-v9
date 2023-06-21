<div class="card">
    {{ $role->name }}
    <form action="javascript:void()" id="method-form">
        @csrf
        <input type="text" name="role_id" id="" value="{{$role->id}}">
    @foreach ($methods as $method)
            <input type="checkbox" name="{{$method->id}}" id="" {{ $method->access ? 'checked' : '' }}>{{$method->name}}
            <br>
    @endforeach
    </form >
    <button onclick="submit()">submit</button>


</div>
<script>
    function submit(){
        send_ajax_request(
            "{{ route('role.edit') }}",
            $('#method-form').serialize(),
            function(data){
                console.log(data);
            }
        )
    }
</script>