<form action="javascript:void(0)" method="POST" id="task-detail">
    @method('PUT')
    @csrf
    <input type="hidden" name="id" id="" value="{{ $task->id }}">
    <div class="col-sm-12 mt-3">
        <input type="checkbox" id="done" name="done" class="col-sm-2"
            @if ($task->done) checked @endif>
        <label for="done">کار انجام شد</label class="col-sm-10">
    </div>
    <div class="col-sm-12 mt-2">
        <label for="task" class="col-sm-12">کار :</label>
        <input type="text" id="task" name="task" value="{{ $task->task }}" class="col-sm-12 mb-2">
    </div>
    <div class="col-sm-12 mt-2">
        <label for="description" class="col-sm-12">توضیحات کار :</label>
        <textarea name="description" id="description" cols="30" rows="10" class="col-sm-12">{{ $task->description }}</textarea>
    </div>
    <div class="col-sm-12 mt-2">
        <label for="edit_reminder_date" class="col-sm-12">تاریخ یادآوری :</label>
        <input type="hidden" id="edit_reminder_date" name="reminder_date" value="{{ $task->reminder_date }}">
        <input type="text" id="edit_reminder_date_view" class="col-sm-12 form-control m-1" value="{{ $task->reminder_date }}">
    </div>
    <div class="col-sm-12 mt-2">
        <label for="edit_due_date">تاریخ تحویل :</label class="col-sm-12">
        <input type="hidden" id="edit_due_date" name="due_date" value="{{ $task->due_date }}">
        <input type="text" id="edit_due_date_view" class="col-sm-12 form-control m-1" value="{{ $task->due_date }}">
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
                console.log(res);
                refresh_table();
            }
        )
    }


    $("#edit_due_date_view").persianDatepicker({
        format: 'YYYY-MM-DD',
        toolbox: {
            calendarSwitch: {
                enabled: true
            }
        },
        initialValue: false,
        observer: true,
        altField: '#edit_due_date'
    });


    $("#edit_reminder_date_view").persianDatepicker({
        format: 'YYYY-MM-DD',
        toolbox: {
            calendarSwitch: {
                enabled: true
            }
        },
        initialValue: false,
        observer: true,
        altField: '#edit_reminder_date'
    });

    var data = "{{ $task->reminder_date }}";
    var DueUnixValue = new Date(data);
    var DueDate = DueUnixValue.toLocaleDateString('fa-IR');
    $("#edit_due_date_view").val(DueDate);

    var ReminderUnixValue = "{{ $task->reminder_date }}";
    var ReminderUnixValue = new Date(ReminderUnixValue);;
    var ReminderDate = ReminderUnixValue.toLocaleDateString('fa-IR');
    $("#edit_reminder_date_view").val(ReminderDate);

</script>
