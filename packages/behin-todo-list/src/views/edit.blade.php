<form action="javascript:void(0)" method="POST" id="task-detail">
    @method('PUT')
    @csrf
    <input type="hidden" name="id" id="" value="{{ $task->id }}">
    <div class="col-sm-12 mt-2">
        <label for="task" class="col-sm-12">کار :</label>
        <input type="text" id="task" name="task" value="{{ $task->task }}" class="col-sm-12 mb-2">
    </div>
    <div class="col-sm-12 mt-2">
        <label for="description" class="col-sm-12">توضیحات کار :</label>
        <textarea name="description" id="description" cols="30" rows="10" class="col-sm-12">{{ $task->description }}</textarea>
    </div>
    <div class="col-sm-12 mt-2">
        <label for="reminder_date" class="col-sm-2">تاریخ یادآوری :</label>
        <input type="date" id="reminder_date" name="reminder_date" class="col-sm-10" value="{{ $task->reminder_date }}">
    </div>
    <div class="col-sm-12 mt-3">
        <label for="due_date">تاریخ تحویل :</label class="col-sm-2">
        <input type="date" id="due_date" name="due_date" class="col-sm-10" value="{{ $task->due_date }}">
    </div>
    <button type="submit" onclick="update()" class="col-sm-12 mt-2 btn btn-primary">بروزرسانی</button>
</form>

<script>
    function update() {
        fd = new FormData($('#task-detail')[0])
        send_ajax_formdata_request(
            "{{ route('todoList.update') }}",
            fd,
            function(res) {
                show_message(res);
                refresh_table();
            }
        )
    }
</script>
