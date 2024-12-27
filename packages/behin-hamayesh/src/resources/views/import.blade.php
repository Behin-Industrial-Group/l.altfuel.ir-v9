@extends('layouts.app')

@php
    use Behin\Hamayesh\Http\EventEnum as EventEnum;
@endphp

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">ورود دیتاهای رویداد  {{ EventEnum::Title[$eventId] }} - شماره رویداد {{ $eventId }}</div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('event-verification.import', $eventId) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file">Excel File</label>
                    <input type="file" class="form-control" name="file" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Import</button>
            </form>
        </div>
    </div>
</div>
@endsection