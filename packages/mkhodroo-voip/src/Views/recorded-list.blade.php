@extends('layouts.app')

@section('content')
<div class="row card p-2 m-2">
    <table class="table table-striped " id="table">
        <thead>
            <tr>
                <th>شماره</th>
            </tr>
        </thead>
        @foreach ($result as $item)
            <tr>
                <td><a href="{{ $item }}">{{ $item }}</a></td>
            </tr>
        @endforeach

    </table>
</div>
    
@endsection
@section('script')
    <script>
        $('#table').DataTable()
    </script>
@endsection
