@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ url('public/packages/behin-todo-list/style.css') }}">
@endsection

@section('content')
    <div id="myDIV" class="header">
        <h2>To Do List</h2>
        <form action="{{ route('todoList.create') }}" method="POST">
            @csrf
            <div class="col-sm-12 mt-2">
                <label for="task" class="col-sm-12">کار :</label>
                <input type="text" id="task" name="task" placeholder="Task..." class="col-sm-12 mb-2">
            </div>
            <div class="col-sm-12 mt-2">
                <label for="description" class="col-sm-12">توضیحات کار :</label>
                <textarea name="description" id="description" cols="30" rows="10" class="col-sm-12"></textarea>
            </div>
            <div class="col-sm-12 mt-2">
                <label for="reminder_date" class="col-sm-2">تاریخ یادآوری :</label>
                <input type="date" id="reminder_date" name="reminder_date" class="col-sm-10">
            </div>
            <div class="col-sm-12 mt-3">
                <label for="due_date">تاریخ تحویل :</label class="col-sm-2">
                <input type="date" id="due_date" name="due_date" class="col-sm-10">
            </div>
            <button type="submit" class="col-sm-12 mt-2 btn btn-primary">اضافه کردن</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-stripped" id="todos-table">
            <thead>
                <tr>
                    <th>کار</th>
                    <th>توضیحات کار</th>
                    <th>وضعیت</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{ url('public/packages/behin-todo-list/script.js') }}"></script>
    <script>
        var table = create_datatable(
            'todos-table',
            "{{ route('todoList.list') }}",
            [{
                    data: 'task'
                },

                {
                    data: 'description'
                },
                {
                    data: 'done'
                },
            ],
            null,
            [
                [2, 'asc']
            ]
        );
    </script>
@endsection
