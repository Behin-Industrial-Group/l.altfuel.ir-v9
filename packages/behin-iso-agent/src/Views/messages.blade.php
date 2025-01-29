@foreach ($messages as $message)
    <div class="alert alert-primary">{{ $message->message }}</div>
    <div class="alert alert-warning">{{ $message->response }}</div>
@endforeach
