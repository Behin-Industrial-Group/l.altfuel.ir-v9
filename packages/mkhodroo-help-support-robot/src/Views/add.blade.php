@extends('layouts.app')


@section('content')
    <form action="javascript:void(0)" id="add-help-support-form">
        <select name="parent_id" id="" class="select2">
            <option value=""></option>
            @foreach ($datas as $item)
                <option value="{{ $item->id }}">{{ $item->key }} - {{ $item->value }}</option>
            @endforeach
        </select>
        <input type="text" name="key" id="" class="form-control" placeholder="{{__('key')}}">
        <input type="text" name="value" id="" class="form-control" placeholder="{{__('value')}}">
    </form>
    <button onclick="submit()">submit</button>

@endsection

@section('script')
    <script>
        initial_view()
        function submit() {
            var form = $('#add-help-support-form')[0]
            var fd = new FormData(form)
            send_ajax_formdata_request(
                "{{ route('helpSupport.add') }}",
                fd,
                function(res){
                    console.log(res);
                }
            )
        }
    </script>
@endsection
