<?php

namespace TodoList\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TodoList\Models\Todo;

class TodoListController extends Controller
{
    public function index()
    {
        return view('TodoListViews::index');
    }

    public static function get($id)
    {
        return Todo::find($id);
    }

    public function list()
    {
        $tasks = Todo::where('user_id', Auth::id())->get();
        return $tasks;
    }

    public function create(Request $request)
    {
        $task = Todo::create([
            'creator' => Auth::id(),
            'user_id' => Auth::id(),
            'task' => $request->task,
            'description' => $request->description,
            'reminder_date' => $request->reminder_date,
            'due_date' => $request->due_date,
        ]);
        return view('TodoListViews::index');
    }

    public function update(Request $request)
    {
        $task = self::get($request->id);
        if ($task->creator != Auth::id()) {
            return response(trans("update not ok"), 403);
        }
        $task->done = $task->done ? 0 : 1;
        $task->save();
        return response(trans("update ok"));
    }

    public function delete(Request $request)
    {
        $task = self::get($request->id);
        if ($task->creator != Auth::id()) {
            return response(trans("delete not ok"), 403);
        }
        $task->delete();
        return response(trans("delete ok"));
    }
}
